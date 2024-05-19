<?php

namespace App\Http\Controllers;

use App\Models\FixExam;
use App\Models\FixExamDet;
use App\Models\FixExamDetAns;
use App\Models\FixExamTmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class TestFixController extends Controller
{
    function getTemplate(Request $request) {
        $subId = $request["subid"];
        $gId = $request["gid"];
        $cateId = $request["cateid"];
        $chapId = $request["chapid"];
        $result = FixExamTmp::query();//('subject','grade','category','chapter');
        if($subId){
            $result->where('sub_id',$subId);
        }
        if($gId){
            $result->where('g_id',$gId);
        }
        if($cateId){
            $result->where('cate_id',$cateId);
        }
        if($chapId){
            $result->where('chap_id',$chapId);
        }
        if(session("user")->role !='A'){
            $result->where('created_by',session("user")->account_id);
        }
        return Datatables::of($result)
            ->addIndexColumn()
            // ->editColumn('created_date', function ($request) {
            //     return $request->created_date->format('d-m-Y'); // human readable format
            //   })
            // ->editColumn('updated_date', function ($request) {
            //     return $request->updated_date->format('d-m-Y'); // human readable format
            //   })
            ->addColumn('action', function($row){
                $actionBtn = '<a href="testfix/chap/'.$row->fe_id.'" title="Edit Exam"><i class="ri-edit-line"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    function initNewChapterPage() {
        return view("test-fix.test-fix-chap-new")->with([
            'fixExam' => []
        ]);
    }

    function initEditChapterPage($chapId) {
//        DB::enableQueryLog();
//        Log::debug($id);

        $fixExam = FixExam::query()
            ->leftJoin("exam_m_sub as sub", "fix_exam.sub_id", "=", "sub.sub_id")
            ->leftJoin("exam_m_cate as cat", "fix_exam.cate_id", "=", "cat.cate_id")
            ->leftJoin("exam_m_grade as g", "fix_exam.g_id", "=", "g.g_id")
            ->where("fe_id", $chapId)
            ->first([
                "fix_exam.fe_id",
                "sub.sub_name",
                "cat.cate_name",
                "g.g_name",
                "fix_exam.fe_price",
                DB::raw("concat('ชุดที่ ', fix_exam.chap_id) as chap_name")
            ]);

//        Log::debug(DB::getQueryLog());

        return view("test-fix.test-fix-chap-edit")->with([
            'fixExam' => $fixExam
        ]);
    }

    function getQuestionListYajra($chapId) {
        $result = self::getQuestionListById($chapId);
        return Datatables::of($result)
            ->addIndexColumn()
            ->addColumn('question', function($row){
                return $row -> fe_que;
            })
            ->addColumn('action', function($row) use ($chapId) {
                $actionBtn = "<a href='./$chapId/question/$row->fe_det_id' title='Edit Question'><i class='ri-edit-line'></i></a> <a href='javascript:delFix($row->fe_det_id)' title='Delete Question'><i class='ri-delete-bin-line'></i></a>";
                return $actionBtn;
            })
            ->rawColumns(['question', 'action'])
            ->make(true);
    }

    private function getQuestionListById($id) {
        return FixExamDet::query()
            ->where("fe_id","=", $id)
            ->get([
                'fe_det_id',
                'fe_que',
                'fe_no_ans',
                'lv_id'
            ]);
    }

    function createChapter(Request $request) {
        if(session("user")->role =='A'){
            $fe_status = 'A';
        }else{
            $fe_status = null;
        }
        DB::beginTransaction();

        $countExisting = FixExam::query()
            ->where("sub_id","=",$request["subject"])
            ->where("g_id","=",$request["grade"])
            ->where("cate_id","=",$request["category"])
            ->count();
        $newChapter = $countExisting + 1;

        $fixExam = FixExam::query()->create([
            "sub_id" => $request["subject"],
            "g_id" => $request["grade"],
            "cate_id" => $request["category"],
            "chap_id" => $newChapter,
            "fe_price" => $request["price"],
            "fe_status" => $fe_status,
        ]);
        DB::commit();
        return $fixExam;
    }

    function updateChapter(Request $request) {
        DB::beginTransaction();
        if(session("user")->role =='A'){
            $fe_status = 'A';
        }else{
            $fe_status = null;
        }
        $fixExam = FixExam::query()
            ->where("fe_id", "=", $request["chapId"])
            ->update([
            "fe_price" => $request["price"],
            "fe_status" => $fe_status,
        ]);
        DB::commit();
        return $fixExam;
    }

    function initEmptyQuestionPage($chapId) {
        $question = [];
        $answers = [];

        Log::debug(DB::getQueryLog());

        return view("test-fix.test-fix-question")->with([
            'question' => $question,
            'answers' => $answers,
            'answerAmount' => sizeof($answers) == 0 ? 4 : sizeof($answers)
        ]);
    }

    function initQuestionPage($chapId, $questionId) {
        DB::enableQueryLog();

        $question = FixExamDet::query()
            ->where("fe_det_id", $questionId)
            ->first();

        $answers = FixExamDetAns::query()
            ->where("fe_det_id", $questionId)
            ->get();

        Log::debug(DB::getQueryLog());

        return view("test-fix.test-fix-question")->with([
            'question' => $question,
            'answers' => $answers,
            'answerAmount' => sizeof($answers) == 0 ? 4 : sizeof($answers)
        ]);
    }

    function insertNewQuestion(Request $request, $chapId) {
        $data = $request->all();

        $questionText = $data["questionText"];
        $tags = $data["tags"];
        $solutionText = $data["solutionText"];
        $answerNo = $data["answerNo"];
        $difficultLevel = $data["difficultLevel"];

        DB::beginTransaction();
        DB::enableQueryLog();

        $fixExamDet = FixExamDet::query()->create([
            "fe_id" => $chapId,
            "fe_que" => $questionText,
            "fe_soln" => $solutionText,
            "fe_no_ans" => $answerNo,
            "lv_id" => $difficultLevel,
            "fe_tags" => $tags,
        ]);

//        Log::debug(DB::getQueryLog());
        foreach ($data as $key => $value) {
            if(substr($key, 0, 10) === "answerText") {
                Log::debug($key . " ==> " . $value);
                FixExamDetAns::query()->create([
                    "fe_det_id" => $fixExamDet->id,
                    "fe_ans" => $value,
                    "fe_ans_no" => intval(substr($key,10))
                ]);
            } else {
                Log::debug($key . " -> " . $value);
            }
        }

        DB::commit();

        return response()->json(true);
    }

    function updateExistQuestion(Request $request, $chapId, $questionId) {
        $data = $request->all();

        $questionText = $data["questionText"];
        $tags = $data["tags"];
        $solutionText = $data["solutionText"];
        $answerNo = $data["answerNo"];
        $difficultLevel = $data["difficultLevel"];

        DB::beginTransaction();
        DB::enableQueryLog();

        FixExamDet::query()
            ->where("fe_det_id", $questionId)
            ->update([
//                "fe_id" => $chapId,
                "fe_que" => $questionText,
                "fe_soln" => $solutionText,
                "fe_no_ans" => $answerNo,
                "lv_id" => $difficultLevel,
                "fe_tags" => $tags,
        ]);

        Log::debug(DB::getQueryLog());

        FixExamDetAns::query()
            ->where("fe_det_id", $questionId)
            ->delete();

        foreach ($data as $key => $value) {
            if(substr($key, 0, 10) === "answerText") {
                Log::debug($key . " ==> " . $value);
                FixExamDetAns::query()->create([
                    "fe_det_id" => $questionId,
                    "fe_ans_no" => intval(substr($key,10)),
                    "fe_ans" => $value
                ]);
            } else {
                Log::debug($key . " -> " . $value);
            }
        }

        DB::commit();

        return response()->json(true);
    }

    function sendAppr(Request $request) {

        DB::beginTransaction();

        FixExam::query()
        ->where("fe_id", "=", $request["feId"])
        ->update([
        "fe_status" => 'W',
        ]);
        DB::commit();

        return response()->json(true);
    }

    function delFixDetail(Request $request){
        $feDetId = $request["feDetId"];
        DB::beginTransaction();
        try{
            FixExamDetAns::where('fe_det_id', '=', $feDetId)->delete();
            FixExamDet::where('fe_det_id', '=', $feDetId)->delete();
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return response()->json(array('status' => 400));
        }
            return response()->json(array('status' => 200));
    }
}
