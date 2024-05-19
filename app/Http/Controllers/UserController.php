<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserAccount;
use App\Models\ViewCreatorTran;
use App\Models\UsersCredit;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(){
        return view('admin.users');
    }

    public function getUser(Request $request)
    {
        if ($request->ajax()) {
            $data = UserAccount::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_date', function ($request) {
                    return $request->created_date->format('d-m-Y'); // human readable format
                  })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="users/view/'.$row->account_id.'" title="View User"><i class="ri-eye-line"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $users = DB::select('select
        user_account.account_id
        ,user_account.username ,user_account.created_date ,user_m_role.role_name
        ,user_account.status ,user_account.email
        ,user_profile.first_name ,user_profile.last_name ,user_profile.birth_date
        ,user_profile.profile_img ,user_profile.profile_img_type ,user_profile.address
        from user_account
        inner join user_profile on user_account.account_id = user_profile.account_id
        inner join user_m_role on user_account.role = user_m_role.role
        where user_account.account_id = ?',array($id));
        $userdata = $users[0];
        return view('admin.view', compact('userdata'));
    }

    public function dashboard(Request $request)
    {
        $id = session("user")->account_id;
        $totalSold = DB::table('v_crt_pur_db')->where('exam_created', '=', $id)->count();
        $cfix = DB::table('fix_exam')->where('created_by', '=', $id)->where('fe_status', '=', 'A')->count();
        $cmock = DB::table('mock_exam')->where('created_by', '=', $id)->where('me_status', '=', 'A')->count();
        $osExam = $cfix+$cmock;//ExamHist::where('account_id', '=', $id)->orderBy('updated_date', 'desc')->first(); //table('user_exam')->where('account_id', '=', $id)->max('updated_date');


        $mEarn = DB::table('v_crt_pur_db')->where('exam_created', '=', $id)->whereMonth('created_date', Carbon::now()->month)->sum('price');//$recExam->ex_name;
        $accBalance = // DB::table('v_crt_pur_db')->where('exam_created', '=', $id)->sum('price');//$recExam->ex_name;
        DB::table('user_credit_trans')->where('account_id', '=', $id)->orderByDesc('credit_id')->first();

        $mysold = DB::select('select count(pur_id) sold,concat(MONTH(created_date),"/",YEAR(created_date)) sold_month from v_crt_pur_db vcpd
        where exam_created = ?
        GROUP BY YEAR(created_date), MONTH(created_date)',array($id));
        $dby = array();
        $dbx = array();
        foreach($mysold as  $chart){
        //= array();
        // sold
        array_push($dby,intval ($chart->sold));
        // month
        array_push($dbx,strval ($chart->sold_month));

        }
        $inproc = DB::select(' select * from(
            select fe.created_by account_id, fen.ex_name ex_name,fe.created_date,fe.fe_status ex_status from   fix_exam fe
                join fix_exam_name fen on fe.fe_id = fen.fe_id
                UNION
               select me.created_by account_id, mx.mx_name ex_name,me.created_date,me.me_status ex_status from   mock_exam me
                join exam_mx_name mx on me.mx_id = mx.mx_id
               ) as exam_list
             where account_id = ?', [$id]);
        return view('creator.dashboard', compact('inproc','totalSold','osExam','mEarn','accBalance','dbx','dby'));
        // from user_exam ue join fix_exam fe on ue.fe_id = fe.fe_id
        // join exam_m_cate c on c.cate_id = fe.cate_id
        // join exam_m_chapter cp on cp.chap_id = fe.chap_id
        // join exam_m_grade g on g.g_id = fe.g_id
        // join exam_m_sub s on s.sub_id = fe.sub_id
        // union
        // SELECT ue.*, TIMEDIFF(me.me_time,ue.ex_time) total_time , "MOCK EXAM" as ex_name
        // from user_exam ue join mock_exam me on ue.me_id = me.me_id
        // ) as user_hist
        // where ex_status = ? and account_id = ?', ['S',$id]);


        // return view('std.dashboard', compact('inproc','lastExam','utExam','accBalance','dbx','dby'));
    }
    public function getLastTrans(Request $request)
    {
        if ($request->ajax()) {
            $data = ViewCreatorTran::where('exam_created', '=', session("user")->account_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_date', function ($request) {
                    return $request->created_date->format('d-m-Y'); // human readable format
                  })
                ->make(true);
        }
    }

    public function chkDashboard(){
        if(session("user")->role =='A'){
            return redirect('/admin/dashboard');
        }else{
            return redirect('/creator/dashboard');
        }
    }

    public function getUserCredit(Request $request)
    {
        if ($request->ajax()) {
            $data = UsersCredit::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('join_date', function ($request) {
                    return $request->join_date->format('d-m-Y'); // human readable format
                  })
                ->addColumn('action', function($row){
                    $actionBtn = '<button type="button" onclick="addCredit('.$row->account_id.')" class="btn btn-outline-dark rounded-pill mb-3">Add</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    // $actionBtn = '<a href="users/view/'.$row->account_id.'" title="View User"><i class="ri-eye-line"></i></a>';
    public function addCredit(Request $request){
        $id = session("user")->account_id;
        $credit = $request["credit"];
        $accId = $request["accId"];
            DB::beginTransaction();
            try{

                $balance = DB::table('user_credit_trans')->where('account_id', '=', $accId)->select('balance_amt')->latest('created_date')->first();
                if(!$balance)
                {
                    DB::table("user_credit_trans")->insert(
                        ['account_id' => $accId ,
                        'tran_amt' => $credit,
                        'balance_amt' => $credit,
                        'balance_amt_bf' => 0.00,
                        'tran_type' => 'A',
                        'created_date' => date("Y-m-d H:i:s"),
                        'created_by' => $id
                        ]
                    );
                    $balance = DB::table('user_credit_trans')->where('account_id', '=', $accId)->select('balance_amt')->latest('created_date')->first();
                }else{
                 DB::table("user_credit_trans")->insert(
                                ['account_id' => $accId ,
                                'tran_amt' => $credit,
                                'balance_amt' => $balance->balance_amt + $credit,
                                'balance_amt_bf' => $balance->balance_amt,
                                'tran_type' => 'A',
                                'created_date' => date("Y-m-d H:i:s"),
                                'created_by' => $id
                                ]
                            );
                }
                DB::commit();
            } catch(\Exception $e){
            //if there is an error/exception in the above code before commit, it'll rollback
                DB::rollBack();
                return $e->getMessage();
            }
            Alert::success('You have signed up successfully.');

        // }
        return response()->json(array('status' => 200));
    }
}
