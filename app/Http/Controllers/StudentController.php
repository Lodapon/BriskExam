<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\FixExamDet;
use App\Models\ExamHist;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Log;

class StudentController extends Controller
{
    public function edit()
    {
        $id = session("user")->account_id;
        $users = DB::select('select
        user_account.account_id
        ,user_account.username ,user_account.created_date ,user_m_role.role_name
        ,user_account.status ,user_account.email
        ,user_profile.first_name ,user_profile.last_name ,user_profile.birth_date
        ,user_profile.profile_img ,user_profile.profile_img_type ,user_profile.address
        ,user_profile.school,user_profile.occupation
        from user_account
        inner join user_profile on user_account.account_id = user_profile.account_id
        inner join user_m_role on user_account.role = user_m_role.role
        where user_account.account_id = ?',array($id));
        $userdata = $users[0];
        return view('std.edit', compact('userdata'));
    }

    public function fixlist(Request $request)
    {
        $id = session("user")->account_id;
        $cateId = $request["cateId"];
        $subId = $request["subId"];
        $cretor = $request["creator"];
        // $libraly = DB::table('fix_exam')
        // // ->join('fix_exam_template','fix_exam.fe_id' ,'=' ,'fix_exam_template.fe_id')
        // // ->select('fix_exam.fe_id','fix_exam_template.ex_name','fix_exam_template.fe_price','fix_exam_template.choice_total','fix_exam_template.tags','fix_exam_template.do_all'
        // // ,'fix_exam_template.min_all','fix_exam_template.max_all','fix_exam_template.avg_time_all','fix_exam_template.user_all','fix_exam_template.mean','fix_exam_template.std_point')
        // // ->groupBy('fix_exam.fe_id','fix_exam_template.ex_name','fix_exam_template.fe_price','fix_exam_template.choice_total','fix_exam_template.tags','fix_exam_template.do_all'
        // // ,'fix_exam_template.min_all','fix_exam_template.max_all','fix_exam_template.avg_time_all','fix_exam_template.user_all','fix_exam_template.mean','fix_exam_template.std_point');
        // ->join('fix_exam_det','fix_exam.fe_id' ,'=' ,'fix_exam_det.fe_id')
        // ->join('exam_m_cate','fix_exam.cate_id','=','exam_m_cate.cate_id')
        // ->join('exam_m_set','fix_exam.chap_id','=','exam_m_set.chap_id')
        // ->join('exam_m_grade','fix_exam.g_id','=','exam_m_grade.g_id')
        // ->join('exam_m_sub','fix_exam.sub_id','=','exam_m_sub.sub_id')
        // ->select( 'fix_exam.fe_id',DB::raw('count(fix_exam_det.fe_id) as total')  ,'fix_exam.fe_price'
        //  ,'exam_m_cate.cate_name', 'exam_m_set.chap_name','exam_m_grade.g_name'
        //  ,'exam_m_sub.sub_name')
        //  ->groupBy('fix_exam.fe_id'
        //  , 'fix_exam.fe_price'
        //  ,'exam_m_cate.cate_name', 'exam_m_set.chap_name','exam_m_grade.g_name'
        //  ,'exam_m_sub.sub_name');
        // if($subId){
        //     $libraly = $libraly->where('fix_exam.sub_id',$subId);
        // }
        // if($cateId){
        //     $libraly = $libraly->where('fix_exam.cate_id',$cateId);
        // }
        $libraly = DB::select('select fix_exam.fe_id, fix_exam_template.ex_name, fix_exam_template.fe_price
        , fix_exam_template.choice_total, fix_exam_template.tags
        , nvl(fix_exam_template.do_all,0) do_all, nvl(fix_exam_template.min_all,0) min_all
        , nvl(fix_exam_template.max_all,0) max_all, nvl(fix_exam_template.avg_time_all,"00:00:00") avg_time_all
        , nvl(fix_exam_template.user_all,0) user_all, nvl(fix_exam_template.mean,0) mean, nvl(fix_exam_template.std_point ,0) std_point
        , nvl(ufet.done,0) done,nvl(ufet.max,0) max,nvl(ufet.best_time,"00:00:00") best_time,ua.username created_name
        from fix_exam
        join user_account ua on fix_exam.created_by = ua.account_id
        left join fix_exam_template on fix_exam.fe_id = fix_exam_template.fe_id
        left join user_fix_exam_total ufet on fix_exam.fe_id = ufet.fe_id and ufet.account_id = ?
        where fix_exam.fe_status = "A"
        and (? IS NULL OR fix_exam.sub_id = ?)
        and (? IS NULL OR fix_exam.cate_id = ?)
        and (? IS NULL OR ua.username like ?)', [$id,$subId,$subId,$cateId,$cateId,'%'.$cretor.'%','%'.$cretor.'%']);
        // $libraly = DB::select('select * from fix_exam_name');

        // $libraly =  $libraly->paginate(15);
        return view('std.fix.libraly', compact('libraly'));
    }

    public function chkFixPurchase(Request $request)
    {
        $id = session("user")->account_id;
        $feId = $request["feId"];
        $meId = $request["meId"];
        if($feId){
            $isPurchase = DB::table('user_purchase')->where('fe_id', '=', $feId)->where('account_id', '=', $id)->count();
        }else if($meId){
            $isPurchase = DB::table('user_purchase')->where('me_id', '=', $meId)->where('account_id', '=', $id)->count();
        }
        if($isPurchase > 0){
            //already purchase
            return response()->json(array('status' => 200));
        }else{
            // step purchase
            $balance = DB::table('user_credit_trans')->where('account_id', '=', $id)->select('balance_amt')->latest('created_date')->first();

            if($feId){
                $excost = DB::table('fix_exam')->where('fe_id', '=', $feId)->select('fe_price','created_by')->first();
            }else if($meId){
                $excost = DB::table('mock_exam')->where('me_id', '=', $meId)->select('me_price','created_by')->first();
            }
            $balanceCrt = DB::table('user_credit_trans')->where('account_id', '=', $excost->created_by)->select('balance_amt')->latest('created_date')->first();
            DB::beginTransaction();
            if(!$balance)
            {
                DB::table("user_credit_trans")->insert(
                    ['account_id' => $id ,
                    'tran_amt' => 0.00,
                    'balance_amt' => 0.00,
                    'balance_amt_bf' => 0.00,
                    'tran_type' => 'A',
                    'created_date' => date("Y-m-d H:i:s"),
                    'created_by' => $id
                    ]
                );
                $balance = DB::table('user_credit_trans')->where('account_id', '=', $id)->select('balance_amt')->latest('created_date')->first();
            }

            if(!$balanceCrt)
            {
                DB::table("user_credit_trans")->insert(
                    ['account_id' => $excost->created_by ,
                    'tran_amt' => 0.00,
                    'balance_amt' => 0.00,
                    'balance_amt_bf' => 0.00,
                    'tran_type' => 'A',
                    'created_date' => date("Y-m-d"),
                    'created_by' => $excost->created_by
                    ]
                );
                $balanceCrt = DB::table('user_credit_trans')->where('account_id', '=', $excost->created_by)->select('balance_amt')->latest('created_date')->first();
            }

            if($feId){
                    if(($balance->balance_amt - $excost->fe_price) >= 0){

                        //insert purchace exam data
                        try{
                            DB::table("user_purchase")->insert(
                                ['account_id' => $id ,
                                'fe_id' => $feId,
                                'created_date' => date("Y-m-d"),
                                'created_by' => $id
                                ]
                            );
                            //sum new balacne credit student
                            DB::table("user_credit_trans")->insert(
                                ['account_id' => $id ,
                                'tran_amt' => $excost->fe_price,
                                'balance_amt' => $balance->balance_amt - $excost->fe_price,
                                'balance_amt_bf' => $balance->balance_amt,
                                'tran_type' => 'P',
                                'created_date' => date("Y-m-d H:i:s"),
                                'created_by' => $id
                                ]
                            );
                            //sum new balacne credit creator
                            DB::table("user_credit_trans")->insert(
                                ['account_id' =>  $excost->created_by ,
                                'tran_amt' => $excost->fe_price,
                                'balance_amt' => $balanceCrt->balance_amt + $excost->fe_price,
                                'balance_amt_bf' => $balanceCrt->balance_amt,
                                'tran_type' => 'S',
                                'created_date' => date("Y-m-d H:i:s"),
                                'created_by' => $id
                                ]
                            );
                            DB::commit();
                        } catch(\Exception $e){
                        //if there is an error/exception in the above code before commit, it'll rollback
                            DB::rollBack();
                            return $e->getMessage();
                        }
                        //go exam test
                    }else{
                    //balance ไม่พอ
                        DB::commit();
                        return response()->json(array('status' => 400));
                    }
            } else if($meId){
                if(($balance->balance_amt - $excost->me_price) >= 0){

                    //insert purchace exam data
                    try{
                        DB::table("user_purchase")->insert(
                            ['account_id' => $id ,
                            'me_id' => $meId,
                            'created_date' => date("Y-m-d"),
                            'created_by' => $id
                            ]
                        );
                        //sum new balacne credit
                        DB::table("user_credit_trans")->insert(
                            ['account_id' => $id ,
                            'tran_amt' => $excost->me_price,
                            'balance_amt' => $balance->balance_amt - $excost->me_price,
                            'balance_amt_bf' => $balance->balance_amt,
                            'tran_type' => 'P',
                            'created_date' => date("Y-m-d H:i:s"),
                            'created_by' => $id
                            ]
                        );
                        //sum new balacne credit creator
                        DB::table("user_credit_trans")->insert(
                            ['account_id' =>  $excost->created_by ,
                            'tran_amt' => $excost->me_price,
                            'balance_amt' => $balanceCrt->balance_amt + $excost->me_price,
                            'balance_amt_bf' => $balanceCrt->balance_amt,
                            'tran_type' => 'S',
                            'created_date' => date("Y-m-d H:i:s"),
                            'created_by' => $id
                            ]
                        );
                        DB::commit();
                    } catch(\Exception $e){
                    //if there is an error/exception in the above code before commit, it'll rollback
                        DB::rollBack();
                        return $e->getMessage();
                    }
                    //go exam test
                }else{
                //balance ไม่พอ
                    DB::commit();
                    return response()->json(array('status' => 400));
                }
            }
        }
        return response()->json(array('status' => 200));
    }
    public function dotest(Request $request)
    {
        $id = session("user")->account_id;
        $feId = $request["test-fe-id"];
        $data = DB::table('fix_exam')
        ->join('fix_exam_det','fix_exam.fe_id' ,'=' ,'fix_exam_det.fe_id')
        ->join('fix_exam_det_ans','fix_exam_det.fe_det_id' ,'=' ,'fix_exam_det_ans.fe_det_id')
        ->join('exam_m_sub','fix_exam.sub_id','=','exam_m_sub.sub_id')
         ->join('exam_m_cate','fix_exam.cate_id','=','exam_m_cate.cate_id')
        ->join('exam_m_set','fix_exam.chap_id','=','exam_m_set.chap_id')
        ->join('exam_m_grade','fix_exam.g_id','=','exam_m_grade.g_id')
        ->where('fix_exam.fe_id',$feId)
        // ->groupBy('fix_exam_det.fe_det_id')
        ->select('fix_exam_det.fe_det_id','fix_exam_det.fe_que','fix_exam_det_ans.fe_ans_no','fix_exam_det_ans.fe_ans'
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
        return view('std.fix.test', compact('test','total','exname','feId'));
    }

    // public function paginate($items, $perPage = 1, $page = null, $options = [])
    // {
    //     $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    //     $items = $items instanceof Collection ? $items : Collection::make($items);
    //     return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    // }

    public function finishTest(Request $request)
    {
        $anss = json_decode($request["fixexamAns"]);
        $id = session("user")->account_id;
        $feId = $request["feId"];
        $rate = $request["examRating"];
        $time = $request["fixtime"];
        $status =  $request["status"];
        $pointTotal = 0;
        $tags = array();
        // user test point
        foreach($anss as  $ans){
            $point = DB::table('fix_exam_det')->where('fe_det_id',$ans->fe_det_id)->where('fe_no_ans',$ans->fe_ans_no)->count();
            if($point == 0){
                $tag = DB::table('fix_exam_det')->where('fe_det_id',$ans->fe_det_id)->select('fe_tags')->first();
                array_push($tags,$tag);
            }
            $pointTotal += $point;
        }
        $devPoint = '';
        foreach($tags as $k => $v){
            foreach ($v as $key => $val){
                //check all tag split , and loop for :
                    $alltag = explode(",",$val);
                    foreach ($alltag as $key => $val){
                            $valtag = explode(":",$val);
                            $ctag = sizeof($valtag);
                            // Log::debug($ctag);
                        if($ctag == 1){
                            $devPoint .=  $val.',';
                            // Log::debug($devPoint);
                        }else{
                            $devPoint .=  $valtag[1].',';
                            // Log::debug($devPoint);
                    }
                }
                // Log::debug($devPoint);
            }
        }
        $devPoint = implode(',',array_unique(explode(',', substr($devPoint,0,-1))));
        
        DB::beginTransaction();
        try{
            if($status == 'R' ){
                // update
                $exid = $request["exid"];
                DB::table("user_exam")->where('ex_id',$exid)
                ->update(
                    [
                    'ex_ans' => json_encode($anss),
                    'ex_point' => $pointTotal,
                    'ex_status' => 'S',
                    'ex_time' => $time,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'updated_by' => $id,
                    ]
                );
            }else{
                // save user test data
                DB::table("user_exam")->insert(
                    ['account_id' => $id ,
                    'fe_id' => $feId,
                    'ex_ans' => json_encode($anss),
                    'ex_point' => $pointTotal,
                    'ex_dev_point' => $devPoint,
                    'ex_status' => 'S',
                    'ex_time' => $time,
                    'created_date' => date("Y-m-d H:i:s"),
                    'created_by' => $id,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'updated_by' => $id,
                    ]
                );
            }
            // insert vote exam
            DB::table("rating")->insert(
                [
                'fe_id' => $feId,
                'rate_score' => $rate,
                'created_date' => date("Y-m-d"),
                'created_by' => $id
                ]
            );
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return $e->getMessage();
        }

        $data = DB::table('fix_exam')
        ->join('fix_exam_det','fix_exam.fe_id' ,'=' ,'fix_exam_det.fe_id')
        ->join('fix_exam_det_ans','fix_exam_det.fe_det_id' ,'=' ,'fix_exam_det_ans.fe_det_id')
        ->join('exam_m_sub','fix_exam.sub_id','=','exam_m_sub.sub_id')
        ->join('exam_m_cate','fix_exam.cate_id','=','exam_m_cate.cate_id')
        ->join('exam_m_set','fix_exam.chap_id','=','exam_m_set.chap_id')
        ->join('exam_m_grade','fix_exam.g_id','=','exam_m_grade.g_id')
        ->where('fix_exam.fe_id',$feId)
        // ->groupBy('fix_exam_det.fe_det_id')
        ->select('fix_exam_det.fe_det_id','fix_exam_det.fe_que','fix_exam_det_ans.fe_ans_no','fix_exam_det_ans.fe_ans'
          ,'exam_m_cate.cate_name', 'exam_m_set.chap_name','exam_m_grade.g_name' ,'fix_exam_det.fe_no_ans' ,'fix_exam_det.fe_soln'
         ,'exam_m_sub.sub_name')
        ->get();
        // $timexam =  DB::select('SELECT SEC_TO_TIME(  TIME_TO_SEC( TIME(fe_time) )  ) AS time
        // FROM fix_exam  where fe_id = ?',array($feId));
        //result data
        $exname = $data[0]->sub_name ." - ".$data[0]->cate_name." - ".$data[0]->g_name." - ".$data[0]->chap_name;
        $data = $data->groupBy('fe_que');

        $test = $data;
        $total = $data->count();
        $time1 = strtotime($time);
        // $time2 = strtotime($timexam[0]->time);
        $timediff =date('H:i:s',($time1));
        $percent = ($pointTotal/$total) * 100;
        $tags =  json_decode( json_encode($devPoint), true);
//        Log::debug( $result[0]->fe_que );
        $doTotal = DB::table('user_exam')->where('fe_id', '=', $feId)->where('account_id', '=', $id)->count();
        $allpTotal = DB::table('user_exam')->where('fe_id', '=', $feId)->avg('ex_point');
        $doTotal = round($doTotal,2) ;
        $allpTotal = round($allpTotal,2);
        $max = DB::table('user_exam')->where('fe_id', '=', $feId)->max('ex_point');
        $min = DB::table('user_exam')->where('fe_id', '=', $feId)->min('ex_point');
        $stddev = DB::select('select ROUND(STDDEV(ex_point),2) std_point
        FROM user_exam where fe_id = ?',array($feId));
        $std = $stddev[0];
        $utotals = DB::select('select count(DISTINCT account_id ) c_user
        FROM user_exam where fe_id = ?',array($feId));
        $utotal = $utotals[0];
        $avgTimes =  DB::select('SELECT SEC_TO_TIME( AVG( TIME_TO_SEC( TIME(ex_time) ) ) ) AS time
        FROM user_exam  where fe_id = ?',array($feId));
        $avgTime = strtotime($avgTimes[0]->time);
        $avgtimediff =date('H:i:s',($avgTime));
        return view('std.fix.result', compact('test','pointTotal','total','exname'
                                            ,'timediff','percent','tags'
                                            ,'doTotal','allpTotal','max','min'
                                            ,'std','utotal','avgtimediff'));
    }

    public function pauseTest(Request $request)
    {
        $anss = json_decode($request["fixexamAns"]);
        $id = session("user")->account_id;
        $feId = $request["feId"];
        $time = $request["fixtime"];
        $status =  $request["status"];
        $pointTotal = 0;
        $tags = array();
        // user test point
        foreach($anss as  $ans){
            $point = DB::table('fix_exam_det')->where('fe_det_id',$ans->fe_det_id)->where('fe_no_ans',$ans->fe_ans_no)->count();
            if($point == 0){
                $tag = DB::table('fix_exam_det')->where('fe_det_id',$ans->fe_det_id)->select('fe_tags')->first();
                array_push($tags,$tag);
            }
            $pointTotal += $point;
        }
        $devPoint = '';
        foreach($tags as $k => $v){
            foreach ($v as $key => $val){
               //check all tag split , and loop for :
                $alltag = explode(",",$val);
                foreach ($alltag as $key => $val){
                        $valtag = explode(":",$val);
                        $ctag = sizeof($valtag);
                        // Log::debug($ctag);
                    if($ctag == 1){
                        $devPoint .=  $val.',';
                        // Log::debug($devPoint);
                    }else{
                        $devPoint .=  $valtag[1].',';
                        // Log::debug($devPoint);
                    }
                }
            }
        }
        $devPoint = implode(',',array_unique(explode(',', substr($devPoint,0,-1))));
        DB::beginTransaction();
        try{
            // save user test data
            if($status == 'R' ){
                // update
                $exid = $request["exid"];
                DB::table("user_exam")->where('ex_id',$exid)
                ->update(
                    [
                    'ex_ans' => json_encode($anss),
                    'ex_point' => $pointTotal,
                    'ex_status' => 'P',
                    'ex_time' => $time,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'updated_by' => $id,
                    ]
                );
            }else{
                //insert
                DB::table("user_exam")->insert(
                    ['account_id' => $id ,
                    'fe_id' => $feId,
                    'ex_ans' => json_encode($anss),
                    'ex_point' => $pointTotal,
                    'ex_dev_point' => $devPoint,
                    'ex_status' => 'P',
                    'ex_time' => $time,
                    'created_date' => date("Y-m-d H:i:s"),
                    'created_by' => $id,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'updated_by' => $id,
                    ]
                );
            }
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return $e->getMessage();
        }

        return redirect('/std/fix/library');
    }

    public function dashboard(Request $request)
    {
        $id = session("user")->account_id;

        $recExam = ExamHist::where('account_id', '=', $id)->orderBy('updated_date', 'desc')->first(); //table('user_exam')->where('account_id', '=', $id)->max('updated_date');
        $lastExam = $recExam->ex_name ?? "ยังไม่ได้ทำข้อสอบ";
        $utExam = DB::table('user_purchase')->where('account_id', '=', $id)->count();
        $accBalance = DB::table('user_credit_trans')->where('account_id', '=', $id)->orderByDesc('credit_id')->first();

        $examhis = ExamHist::where('account_id', '=', $id)->where('ex_status', '=', 'S')->orderBy('created_date')->get();
        $dby = array();
        $dbx = array();
        foreach($examhis as  $chart){
        //= array();
        // point of test
        array_push($dby,intval ($chart->ex_point));
        // name exam
        array_push($dbx,strval ($chart->ex_name));

        }
        // from user_exam ue join fix_exam fe on ue.fe_id = fe.fe_id
        // join exam_m_cate c on c.cate_id = fe.cate_id
        // join exam_m_set cp on cp.chap_id = fe.chap_id
        // join exam_m_grade g on g.g_id = fe.g_id
        // join exam_m_sub s on s.sub_id = fe.sub_id
        // union
        // SELECT ue.*, TIMEDIFF(me.me_time,ue.ex_time) total_time , "MOCK EXAM" as ex_name
        // from user_exam ue join mock_exam me on ue.me_id = me.me_id
        // ) as user_hist
        // where ex_status = ? and account_id = ?', ['S',$id]);

        $inproc = DB::select('SELECT * FROM (SELECT ue.*, ue.ex_time total_time,CONCAT(  s.sub_name,"-", c.cate_name,"-",g.g_name ,"-",cp.chap_name) as ex_name
        from user_exam ue join fix_exam fe on ue.fe_id = fe.fe_id
        join exam_m_cate c on c.cate_id = fe.cate_id
        join exam_m_set cp on cp.chap_id = fe.chap_id
        join exam_m_grade g on g.g_id = fe.g_id
        join exam_m_sub s on s.sub_id = fe.sub_id
        union
        SELECT ue.*, TIMEDIFF(me.me_time,ue.ex_time) total_time , mx.mx_name as ex_name
        from user_exam ue join mock_exam me on ue.me_id = me.me_id
        join exam_mx_name mx on me.mx_id = mx.mx_id
        ) as user_hist
        where ex_status = ? and account_id = ?', ['P',$id]);
        return view('std.dashboard', compact('inproc','lastExam','utExam','accBalance','dbx','dby'));
    }
    public function getExamHist(Request $request)
    {
        if ($request->ajax()) {
            $data = ExamHist::where('account_id', '=', session("user")->account_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_date', function ($request) {
                    return $request->created_date->format('d-m-Y H:i:s'); // human readable format
                  })
                ->editColumn('updated_date', function ($request) {
                return $request->updated_date->format('d-m-Y H:i:s'); // human readable format
                })
                ->addColumn('action', function($row){
                    if($row->ex_type=='F'){
                        $actionBtn = '<a href="javascript:viewFix('.$row->fe_id.','.$row->ex_id.')" class="btn btn-light mb-3">View</a>';
                    }else{
                        $actionBtn = '<a href="javascript:viewMock('.$row->me_id.','.$row->ex_id.')" class="btn btn-light mb-3">View</a>';;
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function resumeTest(Request $request)
    {
        $id = session("user")->account_id;
        $exid = $request["exid"];
        $feId = $request["feid"];
        if($feId){
        $data = DB::table('fix_exam')
        ->join('fix_exam_det','fix_exam.fe_id' ,'=' ,'fix_exam_det.fe_id')
        ->join('fix_exam_det_ans','fix_exam_det.fe_det_id' ,'=' ,'fix_exam_det_ans.fe_det_id')
        ->join('exam_m_sub','fix_exam.sub_id','=','exam_m_sub.sub_id')
         ->join('exam_m_cate','fix_exam.cate_id','=','exam_m_cate.cate_id')
        ->join('exam_m_set','fix_exam.chap_id','=','exam_m_set.chap_id')
        ->join('exam_m_grade','fix_exam.g_id','=','exam_m_grade.g_id')
        ->where('fix_exam.fe_id',$feId)
        // ->groupBy('fix_exam_det.fe_det_id')
        ->select('fix_exam_det.fe_det_id','fix_exam_det.fe_que','fix_exam_det_ans.fe_ans_no','fix_exam_det_ans.fe_ans'
          ,'exam_m_cate.cate_name', 'exam_m_set.chap_name','exam_m_grade.g_name'
         ,'exam_m_sub.sub_name')
        ->get();

        $exname = $data[0]->sub_name ." - ".$data[0]->cate_name." - ".$data[0]->g_name." - ".$data[0]->chap_name;
        $data = $data->groupBy('fe_que');

        $test = $data;
        $total = $data->count();
        $uex =  DB::select('SELECT   TIME_TO_SEC( TIME(ex_time) )   AS time , ex_ans
        FROM user_exam  where ex_id = ?',array($exid));
        $time = $uex[0]->time;
        $anws = json_decode($uex[0]->ex_ans);
        $status = 'R';
        return view('std.fix.retest', compact('test','total','exname','feId','time','anws','status','exid'));
        }else{
            $uex =  DB::select('SELECT  ex_time AS time , ex_ans ,mock_choice,me_id FROM user_exam  where ex_id = ?',array($exid));
            $vEx =  DB::select('SELECT   * FROM v_mock_exam  where me_id = ?',array($uex[0]->me_id));
            $data = DB::table('mock_exam_det')
            ->join('mock_exam_det_ans','mock_exam_det.me_det_id' ,'=' ,'mock_exam_det_ans.me_det_id')
            ->whereRaw('mock_exam_det.me_det_id in ('.$uex[0]->mock_choice.')')
            // ->groupBy('fix_exam_det.fe_det_id')
            ->select('mock_exam_det.me_det_id','mock_exam_det.me_que','mock_exam_det_ans.me_ans_no','mock_exam_det_ans.me_ans','mock_exam_det.me_type')
            ->orderByRaw('FIELD(mock_exam_det.me_det_id,'.$uex[0]->mock_choice.')')
            ->get();

            $data = $data->groupBy('me_que');
            $meId = $uex[0]->me_id;
            $exname = $vEx[0]->mx_name;
            $test = $data;
            $total = $data->count();
            $time = $uex[0]->time;
            $anws = json_decode($uex[0]->ex_ans);
            $status = 'R';

            return view('std.mock.retest', compact('test','total','exname','meId','time','anws','status','exid'));
        }
    }


    public function mocklist(Request $request)
    {
        $id = session("user")->account_id;
        $mockname = $request["mockname"];

        $libraly = DB::select('select mt.me_id, mt.mx_name, mt.me_price
        , mt.total choice_total, mt.subjective tags
        , mt.do_all, mt.min_all
        , mt.max_all, mt.avg_time_all
        , mt.user_all, mt.mean, mt.std_point
        , nvl(ufet.done,0) done,nvl(ufet.max,0) max,nvl(ufet.best_time,"00:00:00") best_time
        from v_mock_exam_template mt
        left join user_mock_exam_total ufet on mt.me_id = ufet.me_id and ufet.account_id = ?
        where (? IS NULL OR mt.mx_id = ?)
        And me_status = "A" ', [$id, $mockname ,$mockname]);
        // $libraly = DB::select('select * from fix_exam_name');

        // $libraly =  $libraly->paginate(15);
        return view('std.mock.index', compact('libraly'));
    }

    public function doMocktest(Request $request)
    {
        try{
        $id = session("user")->account_id;
        $meId = $request["test-me-id"];
        $mtmp = DB::select('SELECT vmet.me_id,vmet.mx_name,vmet.me_time,vmet.total, tag.me_sec,tag.me_tags,mt.me_choice,mt.me_choice_total ,mt.me_write,vmet.me_time
        from v_mock_exam_template vmet
        join v_mock_exam_tag tag on vmet.me_id = tag.me_id
        join mock_exam_tmp mt on mt.me_id = vmet.me_id
        and mt.me_sec = tag.me_sec
        where vmet.me_id = ?', [$meId]);

        //get random exam from template
        //
        $midArr = array();
        //det ข้อสอบที่ random
        $medetId = '0,';
        $proc = 0;
        $oldSec = 1;

        foreach ($mtmp as $tmp) {
            $tagSql = '';
            //ข้อตามแต่ละ sec
            if($oldSec==$tmp->me_sec){
                //ข้อที่
                $proc++;
                //sec ที่
                $oldSec = $tmp->me_sec;

            }else{
                //set ข้อใหม่ตาม sec
                $proc=1;
                $oldSec = $tmp->me_sec;

            }

            $tags = explode(',',$tmp->me_tags);
            foreach($tags as $key) {
                $tagSql = $tagSql.' and vmed.me_tags like "%'.$key.'%"';
            }
            //check ข้อช้อมครบแล้วมี ข้อเขียนบ่
            if($proc > $tmp->me_choice_total){
                if($tmp->me_write>0){
                    // query ข้อเขียน
                    $medetId = substr($medetId, 0, -1);
                    $mocDet = DB::select('SELECT vmed.me_det_id
                    from v_mock_exam_detail vmed
                    where vmed.me_det_id not in ( '.$medetId.' )
                    '.$tagSql
                    .'and me_type = "W"
                    ORDER BY rand() LIMIT 1');
                }
            }else{
                // random ข้อสอบตาม template
                $medetId = substr($medetId, 0, -1);
                $mocDet = DB::select('SELECT vmed.me_det_id
                from v_mock_exam_detail vmed
                where
                vmed.me_det_id not in ( '.$medetId.' )
                '.$tagSql
                .'
                and me_type = "C"
                and total_choice = ?
                ORDER BY rand() LIMIT 1'
                , [$tmp->me_choice]);
            }
            if(!count($mocDet) == 0){
                $medetId = $medetId.','.$mocDet[0]->me_det_id.',';
                array_push($midArr,$mocDet[0]->me_det_id);
            }else{
                //error no exam
                // $medetId = $medetId;
                // array_push($midArr,0);
                Alert::error('This Exam Error', 'Please contact Administrator');
                // Alert::success('Hello');
                return redirect('/std/mock/index');
            }


        }
        $data = DB::table('mock_exam_det')
        ->join('mock_exam_det_ans','mock_exam_det.me_det_id' ,'=' ,'mock_exam_det_ans.me_det_id')
        ->whereIn('mock_exam_det.me_det_id',$midArr)
        // ->groupBy('fix_exam_det.fe_det_id')
        ->select('mock_exam_det.me_det_id','mock_exam_det.me_que','mock_exam_det_ans.me_ans_no','mock_exam_det_ans.me_ans','mock_exam_det.me_type')
        ->orderByRaw('FIELD(mock_exam_det.me_det_id,'.implode(",",$midArr).')')
        ->get();
        $data = $data->groupBy('me_que');
        $test = $data;
        $exname = $mtmp[0]->mx_name;
        $total = $mtmp[0]->total;
        $time = $mtmp[0]->me_time;
        // foreach ($midArr as $value) {

        //     echo $value->me_det_id.',';
        //  }
        // echo $mtmp;
        $mid = implode(",",$midArr);
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            // DB::rollBack();
            return $e->getMessage();
        }

        return view('std.mock.test', compact('mtmp','test','exname','total','time','meId','mid'));
    }

    public function finishMockTest(Request $request)
    {
        $anss = json_decode($request["mockexamAns"]);
        $id = session("user")->account_id;
        $meId = $request["meId"];
        $rate = $request["examRating"];
        $time = $request["mocktime"];
        $exname = $request["exname"];
        $status =  $request["status"];
        $pointTotal = 0;
        $tags = array();
        $midArr = array();
        // user test point
        foreach($anss as  $ans){
            // check choice
            if($ans->me_type == 'C'){
                $point = DB::table('mock_exam_det')->where('me_det_id',$ans->me_det_id)->where('me_no_ans',$ans->me_ans_no)->count();
                if($point == 0){
                    $tag = DB::table('mock_exam_det')->where('me_det_id',$ans->me_det_id)->select('me_tags')->first();
                    array_push($tags,$tag);
                }
            }else{
            //check write
                $point = DB::table('mock_exam_det_ans')->where('me_det_id',$ans->me_det_id)->where('me_ans',$ans->me_ans_no)->count();
                if($point == 0){
                    $tag = DB::table('mock_exam_det')->where('me_det_id',$ans->me_det_id)->select('me_tags')->first();
                    array_push($tags,$tag);
                }
            }
            array_push($midArr,$ans->me_det_id);
            $pointTotal += $point;
        }
        $devPoint = '';
        foreach($tags as $k => $v){
            foreach ($v as $key => $val){
                //check all tag split , and loop for :
                    $alltag = explode(",",$val);
                    foreach ($alltag as $key => $val){
                            $valtag = explode(":",$val);
                            $ctag = sizeof($valtag);
                            // Log::debug($ctag);
                        if($ctag == 1){
                            // $devPoint .=  $val.',';
                            // Log::debug($devPoint);
                        }else{
                            $devPoint .=  $valtag[1].',';
                            // Log::debug($devPoint);
                        }
                    }
            }
        }
        $devPoint = implode(',',array_unique(explode(',', substr($devPoint,0,-1))));
        DB::beginTransaction();
        try{
            if($status == 'R' ){
                // update
                $exid = $request["exid"];
                DB::table("user_exam")->where('ex_id',$exid)
                ->update(
                    [
                    'ex_ans' => json_encode($anss),
                    'ex_point' => $pointTotal,
                    'ex_status' => 'S',
                    'ex_time' => $time,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'updated_by' => $id,
                    ]
                );
            }else{
                // save user test data
                DB::table("user_exam")->insert(
                    ['account_id' => $id ,
                    'me_id' => $meId,
                    'ex_ans' => json_encode($anss),
                    'ex_point' => $pointTotal,
                    'ex_dev_point' => $devPoint,
                    'mock_choice' => implode(",",$midArr),
                    'ex_status' => 'S',
                    'ex_time' => $time,
                    'created_date' => date("Y-m-d H:i:s"),
                    'created_by' => $id,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'updated_by' => $id,
                    ]
                );
            }
            // insert vote exam
            DB::table("rating")->insert(
                [
                'me_id' => $meId,
                'rate_score' => $rate,
                'created_date' => date("Y-m-d"),
                'created_by' => $id
                ]
            );
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return $e->getMessage();
        }

        $data = DB::table('mock_exam_det')
        ->join('mock_exam_det_ans','mock_exam_det.me_det_id' ,'=' ,'mock_exam_det_ans.me_det_id')
        ->whereIn('mock_exam_det.me_det_id',$midArr)
        // ->groupBy('fix_exam_det.fe_det_id')
        ->select('mock_exam_det.me_det_id','mock_exam_det.me_que','mock_exam_det_ans.me_ans_no','mock_exam_det_ans.me_ans','mock_exam_det.me_type','mock_exam_det.me_no_ans' ,'mock_exam_det.me_soln')
        ->orderByRaw('FIELD(mock_exam_det.me_det_id,'.implode(",",$midArr).')')
        ->get();

        $timexam =  DB::select('SELECT SEC_TO_TIME(  TIME_TO_SEC( TIME(me_time) )  ) AS time
        FROM mock_exam  where me_id = ?',array($meId));
        //result data
        $data = $data->groupBy('me_que');

        $test = $data;
        $total = $data->count();
        $time1 = strtotime($time);
        $time2 = strtotime($timexam[0]->time);
        $timediff =date('H:i:s',($time2-$time1));
        $percent = ($pointTotal/$total) * 100;
        $tags =  json_decode( json_encode($devPoint), true);
//        Log::debug( $result[0]->fe_que );
        $doTotal = DB::table('user_exam')->where('me_id', '=', $meId)->where('account_id', '=', $id)->count();
        $allpTotal = DB::table('user_exam')->where('me_id', '=', $meId)->avg('ex_point');
        $doTotal = round($doTotal,2) ;
        $allpTotal = round($allpTotal,2);
        $max = DB::table('user_exam')->where('me_id', '=', $meId)->max('ex_point');
        $min = DB::table('user_exam')->where('me_id', '=', $meId)->min('ex_point');
        $stddev = DB::select('select ROUND(STDDEV(ex_point),2) std_point
        FROM user_exam where me_id = ?',array($meId));
        $std = $stddev[0];
        $utotals = DB::select('select count(DISTINCT account_id ) c_user
        FROM user_exam where me_id = ?',array($meId));
        $utotal = $utotals[0];
        $avgTimes =  DB::select('SELECT SEC_TO_TIME( AVG( TIME_TO_SEC( TIME(ex_time) ) ) ) AS time
        FROM user_exam  where me_id = ?',array($meId));
        $avgTime = strtotime($avgTimes[0]->time);
        $avgtimediff =date('H:i:s',($time2-$avgTime));
        return view('std.mock.result', compact('test','pointTotal','total','exname'
                                            ,'timediff','percent','tags'
                                            ,'doTotal','allpTotal','max','min'
                                            ,'std','utotal','avgtimediff'));
    }

    public function pauseMockTest(Request $request)
    {
        $anss = json_decode($request["mockexamAns"]);
        $id = session("user")->account_id;
        $meId = $request["meId"];
        $time = $request["mocktime"];
        $mid = $request["mid"];
        $status =  $request["status"];
        $pointTotal = 0;
        $tags = array();
        // user test point
        foreach($anss as  $ans){
            // check choice
            if($ans->me_type == 'C'){
                $point = DB::table('mock_exam_det')->where('me_det_id',$ans->me_det_id)->where('me_no_ans',$ans->me_ans_no)->count();
                if($point == 0){
                    $tag = DB::table('mock_exam_det')->where('me_det_id',$ans->me_det_id)->select('me_tags')->first();
                    array_push($tags,$tag);
                }
            }else{
            //check write
                $point = DB::table('mock_exam_det_ans')->where('me_det_id',$ans->me_det_id)->where('me_ans',$ans->me_ans_no)->count();
                if($point == 0){
                    $tag = DB::table('mock_exam_det')->where('me_det_id',$ans->me_det_id)->select('me_tags')->first();
                    array_push($tags,$tag);
                }
            }
            $pointTotal += $point;
        }
        $devPoint = '';
        foreach($tags as $k => $v){
            foreach ($v as $key => $val){
             //check all tag split , and loop for :
                $alltag = explode(",",$val);
                foreach ($alltag as $key => $val){
                        $valtag = explode(":",$val);
                        $ctag = sizeof($valtag);
                        // Log::debug($ctag);
                    if($ctag == 1){
                        // $devPoint .=  $val.',';
                        // Log::debug($devPoint);
                    }else{
                        $devPoint .=  $valtag[1].',';
                        // Log::debug($devPoint);
                    }
                }
            }
        }
        $devPoint = implode(',',array_unique(explode(',', substr($devPoint,0,-1))));
        DB::beginTransaction();
        try{
            // save user test data
            if($status == 'R' ){
                // update
                $exid = $request["exid"];
                DB::table("user_exam")->where('ex_id',$exid)
                ->update(
                    [
                    'ex_ans' => json_encode($anss),
                    'ex_point' => $pointTotal,
                    'ex_status' => 'P',
                    'ex_time' => $time,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'updated_by' => $id,
                    ]
                );
            }else{
                //insert
                DB::table("user_exam")->insert(
                    ['account_id' => $id ,
                    'me_id' => $meId,
                    'ex_ans' => json_encode($anss),
                    'mock_choice' => $mid,
                    'ex_point' => $pointTotal,
                    'ex_dev_point' => $devPoint,
                    'ex_status' => 'P',
                    'ex_time' => $time,
                    'created_date' => date("Y-m-d H:i:s"),
                    'created_by' => $id,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'updated_by' => $id,
                    ]
                );
            }
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return $e->getMessage();
        }

        return redirect('/std/mock/index');
    }

    public function updateUser(Request $request) {
        $id = session("user")->account_id;
        // $acctype = $request["acctype"];
        $firstname = $request["firstname"];
        $lastname = $request["lastname"];
        $address = $request["address"];
        $birthdate = Carbon::createFromFormat('d/m/Y', $request["birthdate"])->format('Y-m-d');
        $school = $request["school"];
        $occupation = $request["occupation"];
        $accnum = $request["accnum"];
        $bank = $request["bank"];
        $email = $request["email"];
        // $username = $request['username'];
        // $psw = $request['psw'];
        // $salt = SecureUtil::generateRandomString();
        // $passwd = SecureUtil::hashing([$username, $psw, $salt]);
        DB::beginTransaction();
        try{
            DB::table("user_account")->where('account_id',$id)
                ->update(
                    [
                        'email' => $email,
                    ]
                    );
        if($request->hasFile('profileImg'))
        {
            $pimg = file_get_contents($_FILES['profileImg']['tmp_name']);
            $pimgType = getimagesize($_FILES['profileImg']['tmp_name'])['mime'];
            DB::table("user_profile")->where('account_id',$id)
            ->update(
                [
                'first_name' => $firstname,
                'last_name' => $lastname,
                'birth_date' => $birthdate,
                'school' => $school,
                'occupation' => $occupation,
                'address' => $address,
                'profile_img' => $pimg,
                'profile_img_type' => $pimgType,
                'updated_by' => $id,
                'updated_date' => date("Y-m-d")
                ]
            );
        }else{
            DB::table("user_profile")->where('account_id',$id)
            ->update(
                [
                'first_name' => $firstname,
                'last_name' => $lastname,
                'birth_date' => $birthdate,
                'school' => $school,
                'occupation' => $occupation,
                'address' => $address,
                'updated_by' => $id,
                'updated_date' => date("Y-m-d")
                ]
            );
        }

        DB::commit();
    } catch(\Exception $e){
    //if there is an error/exception in the above code before commit, it'll rollback
        DB::rollBack();
        return $e->getMessage();
    }
    // $pics = DB::select('select * from user_profile where account_id = ? ',array($accId));
    // $profileImg = 'data:'.$pics[0]->profile_img_type.';base64,'.base64_encode( $pics[0]->profile_img );
    Alert::success('Update successfully.');
    return redirect('/std/dashboard');
    }

    public function viewFix(Request $request)
    {
        $feId = $request["id"];
        $exid = $request["eid"];
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

        $uex =  DB::select('SELECT ex_ans
        FROM user_exam  where ex_id = ?',array($exid));

        $anws = json_decode($uex[0]->ex_ans);

        return view('std.fixExam', compact('test','total','exname','feId','anws'));
    }


    public function viewMock(Request $request)
    {
        $meId = $request["mid"];
        $exid = $request["xid"];
        $uex =  DB::select('SELECT  ex_time AS time , ex_ans ,mock_choice,me_id FROM user_exam  where ex_id = ?',array($exid));
        $vEx =  DB::select('SELECT   * FROM v_mock_exam  where me_id = ?',array($meId));
        $data = DB::table('mock_exam_det')
        ->join('mock_exam_det_ans','mock_exam_det.me_det_id' ,'=' ,'mock_exam_det_ans.me_det_id')
        ->whereRaw('mock_exam_det.me_det_id in ('.$uex[0]->mock_choice.')')
        ->select('mock_exam_det.me_det_id','mock_exam_det.me_que','mock_exam_det_ans.me_ans_no','mock_exam_det_ans.me_ans','mock_exam_det.me_type','mock_exam_det.me_no_ans','mock_exam_det.me_soln')
        ->orderByRaw('FIELD(mock_exam_det.me_det_id,'.$uex[0]->mock_choice.')')
        ->get();

        $data = $data->groupBy('me_que');
        $meId = $uex[0]->me_id;
        $exname = $vEx[0]->mx_name;
        $test = $data;
        $anws = json_decode($uex[0]->ex_ans);
        return view('std.mockExam', compact('test','exname','anws'));
    }
}
