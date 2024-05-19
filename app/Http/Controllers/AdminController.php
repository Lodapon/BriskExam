<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    //
    public function listUser(){
        // $users = DB::select('select
        // user_account.account_id
        // ,user_account.username ,user_account.created_date ,user_account.`role`
        // ,user_account.status ,user_account.email
        // ,user_profile.first_name ,user_profile.last_name
        // ,user_profile.profile_img ,user_profile.profile_img_type
        // from user_account
        // inner join user_profile on user_account.account_id = user_profile.account_id');
        // return view('admin/users',['users'=>$users]);
        $users = DB::table('user_account')
                ->join('user_profile','user_account.account_id','=','user_profile.account_id')
                ->join('user_m_role','user_account.role','=','user_m_role.role')
                ->select( 'user_account.account_id'
                ,'user_account.username' ,'user_account.created_date' ,'user_m_role.role_name'
                ,'user_account.status' ,'user_account.email'
                ,'user_profile.first_name' ,'user_profile.last_name'
                ,'user_profile.profile_img' ,'user_profile.profile_img_type')
                ->paginate(15);
        return view('admin/ausers',['users'=>$users]);

    }

    public function dashboard(Request $request)
    {
        $id = session("user")->account_id;
        $totalUser = DB::table('user_account')->count();
        $fixExam = DB::table('fix_exam')->count();
        $mockExam = DB::table('mock_exam')->count();
        $totalExam = $fixExam + $mockExam;
        $totalBook = DB::table('book_shop')->count(); // DB::table('v_crt_pur_db')->where('exam_created', '=', $id)->count();

        $examIn = DB::select(' select * from (
            select month, exam,
                 if(@last_entry = 0, 0, round(((exam - @last_entry) / @last_entry) * 100,2)) "growth_rate"
                 ,@last_entry := exam
          from
                (select @last_entry := 0) x,
                (select month, sum(sale) exam
                 from   (select month(created_date) as month,count(fe_id) as sale
                         from fix_exam group by month(created_date)
                         union all
                         select month(created_date) as month,count(me_id) as sale
                         from mock_exam group by month(created_date)) monthly_sales
                 group by month) y ) xx order by month DESC LIMIT 1');

        $userIn = DB::select('select * from (
            select month, sale,
                  if(@last_entry = 0, 0, round(((sale - @last_entry) / @last_entry) * 100,2)) "growth_rate",
                  @last_entry := sale
           from
                 (select @last_entry := 0) x,
                 (select month, sum(sale) sale
                  from   (select month(created_date) as month,count(username) as sale
                          from user_account group by month(created_date)) monthly_sales
                  group by month) y  ) xx order by month DESC LIMIT 1');

        $bookIn = DB::select('select * from (
            select month, sale,
                  if(@last_entry = 0, 0, round(((sale - @last_entry) / @last_entry) * 100,2)) "growth_rate",
                  @last_entry := sale
           from
                 (select @last_entry := 0) x,
                 (select month, sum(sale) sale
                  from   (select month(created_date) as month,count(book_id) as sale
                          from book_shop group by month(created_date)) monthly_sales
                  group by month) y  ) xx order by month DESC LIMIT 1');

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
        // $mEarn = DB::table('v_crt_pur_db')->where('exam_created', '=', $id)->whereMonth('created_date', Carbon::now()->month)->sum('price');//$recExam->ex_name;
        // $accBalance = // DB::table('v_crt_pur_db')->where('exam_created', '=', $id)->sum('price');//$recExam->ex_name;
        // DB::table('user_credit_trans')->where('account_id', '=', $id)->orderByDesc('credit_id')->first();

        $mysold = DB::select('select count(account_id) user_acc,umr.role_name from user_account ua
        join user_m_role umr on ua.`role` = umr.`role`
         where 1=1
         GROUP BY role_name');
        $dby = array();
        $dbx = array();
        foreach($mysold as  $chart){
        //= array();
        // user
        array_push($dby, $chart->user_acc);
        // type
        array_push($dbx,strval ($chart->role_name));

        }

      $saleInc = DB::select('WITH exam  AS
      (
            select sum(tran_amt) tran_amt,tran_type,created_date
              from user_credit_trans uct
              where tran_type = "P"
              group by tran_type,created_date
      ),
      book as (
          select sum(hist_paid) tran_amt,"B" as tran_type, date(created_date) created_date
      		from book_shop_cart_hist
            group by tran_type,date(created_date)
      )
      select COALESCE(exam.created_date,book.created_date) created_date,nvl(exam.tran_amt,0.00) exam_amt,nvl(book.tran_amt,0.00) book_amt from exam left outer join book on exam.created_date = book.created_date
      union
      select COALESCE(exam.created_date,book.created_date) created_date,nvl(exam.tran_amt,0.00) exam_amt,nvl(book.tran_amt,0.00) book_amt from exam right outer join book on exam.created_date = book.created_date
      order by created_date');
       $dxe = array();
       $dxb = array();
       $dyd = array();
       $dy = array();
       foreach($saleInc as  $chart){
        // exam
            array_push($dxe, $chart->exam_amt);
        // book
            array_push($dxb, $chart->book_amt);
        // date
            array_push($dyd, $chart->created_date);
        }
        // $inproc = DB::select(' select * from(
        //     select fe.created_by account_id, fen.ex_name ex_name,fe.created_date,fe_status ex_status from   fix_exam fe
        //         join fix_exam_name fen on fe.fe_id = fen.fe_id
        //         UNION
        //        select me.created_by account_id, mx.mx_name ex_name,me.created_date,me_status ex_status from   mock_exam me
        //         join exam_mx_name mx on me.mx_id = mx.mx_id
        //        ) as exam_list
        //      where account_id = ?', [$id]);
        $userLate = DB::select('select ua.account_id,CONCAT(up.first_name," ",up.last_name) name,ua.email,ua.created_date , umr.role_name
        from user_account ua
        join user_profile up on ua.account_id = up.account_id
        join user_m_role umr on ua.`role` = umr.`role`
        order by created_date desc limit 5');

        $examApp = DB::select('select CONCAT(up.first_name," ",up.last_name) name , fet.created_by,fet.ex_name exam_name,fet.fe_price price,fet.choice_total ,"Fix Exam" as exam_type,fet.fe_id id
        from fix_exam_template fet
        left join user_profile up on fet.created_by = up.account_id
        where fet.fe_status = "W" and  fet.choice_total is not null');
        // UNION
        // select CONCAT(up.first_name," ",up.last_name) name , vme.created_by,vme.mx_name exam_name,vme.me_price price,vme.total choice_total,"Mock Exam" as exam_type,vme.me_id id
        // from v_mock_exam vme
        // left join user_profile up on vme.created_by = up.account_id
        // where vme.me_status IS NULL or vme.me_status != "A"
        $bookApp = DB::select('select CONCAT(up.first_name , " ",up.last_name) order_by,hist_id,hist_detail_id,hist_paid,date(bsch.created_date) created_date,hist_delivery_status,hist_sent_addr from book_shop_cart_hist bsch
        join user_profile up on bsch.created_by = up.account_id
        where hist_delivery_status is null or hist_delivery_status != "S"');

        $bookDetail = DB::select('select bschd.hist_detail_id, bs.book_name,bschd.hist_book_amount from book_shop_cart_hist_detail bschd
        join book_shop bs on bschd.hist_book_id = bs.book_id');

        return view('admin.dashboard', compact('totalUser','totalExam','totalBook','userIn','examIn','bookIn','dbx','dby','dxe','dxb','dyd','userLate','examApp','bookApp','bookDetail'));
    }

    public function viewFix(Request $request)
    {
        $feId = $request["id"];
        $data = DB::table('fix_exam')
        ->join('fix_exam_det','fix_exam.fe_id' ,'=' ,'fix_exam_det.fe_id')
        ->join('fix_exam_det_ans','fix_exam_det.fe_det_id' ,'=' ,'fix_exam_det_ans.fe_det_id')
        ->join('exam_m_sub','fix_exam.sub_id','=','exam_m_sub.sub_id')
         ->join('exam_m_cate','fix_exam.cate_id','=','exam_m_cate.cate_id')
        ->join('exam_m_set','fix_exam.chap_id','=','exam_m_set.chap_id')
        ->join('exam_m_grade','fix_exam.g_id','=','exam_m_grade.g_id')
        ->where('fix_exam.fe_id',$feId)
        // ->groupBy('fix_exam_det.fe_det_id')
        ->select('fix_exam_det.fe_det_id','fix_exam_det.fe_que','fix_exam_det.fe_soln','fix_exam_det.fe_no_ans','fix_exam_det_ans.fe_ans_no','fix_exam_det_ans.fe_ans'
          ,'exam_m_cate.cate_name', 'exam_m_set.chap_name','exam_m_grade.g_name'
         ,'exam_m_sub.sub_name')
        ->get();

        $exname = $data[0]->sub_name ." - ".$data[0]->cate_name." - ".$data[0]->g_name." - ".$data[0]->chap_name;
        $data = $data->groupBy('fe_que');

        $test = $data;
        $total = $data->count();
        // $times =  DB::select('SELECT SEC_TO_TIME(  TIME_TO_SEC( TIME(fe_time) )  ) AS time
        // FROM fix_exam  where fe_id = ?',array($feId));
        // $time = $times[0]->time;
        return view('admin.fixExam', compact('test','total','exname','feId'));
    }

    public function approve(Request $request)
    {
        $id = $request["eid"];
        $type = $request["etype"];
        $status = $request["estatus"];
        if($type==='F'){
            DB::table("fix_exam")->where('fe_id',$id)
                ->update(
                    [
                    'fe_status' => $status ,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'updated_by' => session("user")->account_id,
                    ]
                );
        }else{
            DB::table("mock_exam")->where('me_id',$id)
                ->update(
                    [
                    'me_status' => $status ,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'updated_by' => session("user")->account_id,
                    ]
                );
        }
        Alert::success('Successfully.');
        return redirect('/admin/dashboard');
    }
    public function deliver(Request $request)
    {
        $id = $request["hbId"];
            DB::table("book_shop_cart_hist")->where('hist_id',$id)
                ->update(
                    [
                    'hist_delivery_status' =>'S' ,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'updated_by' => session("user")->account_id,
                    ]
                );
        Alert::success('Successfully.');
        return redirect('/admin/dashboard');
    }
}
