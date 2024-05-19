<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MockExamDetAns;
use App\Models\MockExamDet;
use App\Models\MockExam;
use App\Models\MockExamTmp;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TestMockController extends Controller
{
    function initialPage() {

        $questions = [];
        $answers = [];

        return view("test-mock.index")->with([
            'answers' => $answers,
            'answerAmount' =>  4,
            'questions' => $questions
        ]);
    }

    private function getQuestionList() {
        $result = MockExamDet::query()->get([
                'me_det_id',
                'me_que',
                'me_no_ans',
                'lv_id'
            ]);
        return $result->all();
    }

    function save(Request $request) {
        $data = $request->all();

//        DB::enableQueryLog();

        $questionText = $request["questionText"];
        $tags = $request["tags"];
        $solutionText = $request["solutionText"];
        $answerNo = $request["answerNo"];
        // $difficultLevel = $request["difficultLevel"];

        DB::beginTransaction();
        try{
        $test = MockExamDet::query()->create([
            "me_que" => $questionText,
            "me_soln" => $solutionText,
            "me_no_ans" => $answerNo,
            "me_type" => 'C',
            "me_tags" => $tags,
            'created_by' => session("user")->account_id,
            'updated_by' => session("user")->account_id
        ]);

        foreach ($data as $key => $value) {

            if(substr($key, 0, 10) === "answerText") {
                // Log::debug($key . " ==> " . $value);

                MockExamDetAns::query()->create([
                    "me_det_id" => $test->id,
                    "me_ans_no" => intval(substr($key,10)),
                    "me_ans" => $value,
                    'created_by' => session("user")->account_id,
                    'updated_by' => session("user")->account_id
                ]);

            } else {
                // Log::debug($key . " -> " . $value);
            }

        }

        DB::commit();
        } catch(\Exception $e){
            //if there is an error/exception in the above code before commit, it'll rollback
                DB::rollBack();
                return $e->getMessage();
        }
        return response()->json(true);
    }

    function saveW(Request $request) {
        // $data = $request->all();

//        DB::enableQueryLog();

        $questionText = $request["questionText"];
        $tags = $request["tags"];
        $solutionText = $request["solutionText"];
        $ansW = $request["ansW"];
        // $difficultLevel = $request["difficultLevel"];

        DB::beginTransaction();
        try{
        $test = MockExamDet::query()->create([
            "me_que" => $questionText,
            "me_soln" => $solutionText,
            "me_no_ans" => 1,
            "me_type" => 'W',
            "me_tags" => $tags,
            'created_by' => session("user")->account_id,
            'updated_by' => session("user")->account_id
        ]);



        MockExamDetAns::query()->create([
            "me_det_id" => $test->id,
            "me_ans_no" => 1,
            "me_ans" => $ansW,
            'created_by' => session("user")->account_id,
            'updated_by' => session("user")->account_id
        ]);



        DB::commit();
        } catch(\Exception $e){
            //if there is an error/exception in the above code before commit, it'll rollback
                DB::rollBack();
                return $e->getMessage();
        }
        return response()->json(true);
    }

    function template(Request $request) {
        $data = $request->all();
        DB::beginTransaction();
        if(session("user")->role =='A'){
            $me_status = 'A';
        }else{
            $me_status = 'I';
        }
        try{
        $test = MockExam::query()->create([
            "mx_id" => $data["mxId"],
            "sub_id" => $data["subId"],
            "me_time" => $data["time"],
            "me_status" => $me_status,
            "created_by" => session("user")->account_id,
            "updated_by" => session("user")->account_id
        ]);
        $j = 1;
        $tagNo = 0;
        for($i=1;$i<=intval($data["sections"]);$i++){

           $tagNo +=  intval($data["numProbC$i"]) + intval($data["numProbD$i"]);
           $tags = '';
            for($j; $j<=$tagNo ; $j++){
                $tags = $tags.$data["tag$j"].'|';
            }
            MockExamTmp::query()->create([
                "me_id" => $test->id,
                "me_sec" => $i,
                "me_choice_total" => intval($data["numProbC$i"]),
                "me_choice" => intval($data["numC$i"]),
                "me_write" => intval($data["numProbD$i"]),
                "me_tags" => substr($tags, 0, -1),
                "created_by" => session("user")->account_id,
                "updated_by" => session("user")->account_id
            ]);

        }
        DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return $e->getMessage();
        }

        return response()->json($data);
    }

    function edit() {

        // $result = MockExamDetAns::query()->get();
        // $answers = $result->all();
        // $questions = self::getQuestionList();

        // return view("test-mock.edit")->with([
        //     'answers' => $answers,
        //     'answerAmount' =>  4,
        //     'questions' => $questions
        // ]);
    }

    function mockYarjaList(){
        $result = DB::select('SELECT me_det_id,CASE when me_type = "C" then "Choice" else "Write" end type_str,
        me_que, me_tags, me_type, total_choice from v_mock_exam_detail vmed');
        return Datatables::of($result)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = "<a href='./question/$row->me_det_id' title='Edit Question'><i class='ri-edit-line'></i></a> <a href='javascript:delMock($row->me_det_id)' title='Delete Question'><i class='ri-delete-bin-line'></i></a>";
                return $actionBtn;
            })
            ->rawColumns(['me_que', 'action'])
            ->make(true);
    }

    function initQuestionPage($questionId) {

        $question = MockExamDet::query()
            ->where("me_det_id", $questionId)
            ->first();

        $answers = MockExamDetAns::query()
            ->where("me_det_id", $questionId)
            ->get();

        return view("test-mock.test-mock-question")->with([
            'question' => $question,
            'answers' => $answers,
            'answerAmount' => sizeof($answers) == 0 ? 4 : sizeof($answers)
        ]);
    }

    function updateExistQuestion(Request $request, $questionId) {
        $data = $request->all();

        $questionText = $request["questionText"];
        $tags = $request["tags"];
        $solutionText = $request["solutionText"];
        $answerNo = $request["answerNo"];

        DB::beginTransaction();
        DB::enableQueryLog();

        MockExamDet::query()
            ->where("me_det_id", $questionId)
            ->update([
                "me_que" => $questionText,
                "me_soln" => $solutionText,
                "me_no_ans" => $answerNo,
                "me_type" => 'C',
                "me_tags" => $tags,
                "updated_date" => date("Y-m-d H:i:s"),
                "updated_by" => session("user")->account_id
        ]);

        MockExamDetAns::query()
            ->where("me_det_id", $questionId)
            ->delete();

        foreach ($data as $key => $value) {
            if(substr($key, 0, 10) === "answerText") {
                MockExamDetAns::query()->create([
                    "me_det_id" => $questionId,
                    "me_ans_no" => intval(substr($key,10)),
                    "me_ans" => $value,
                    "created_by" => session("user")->account_id,
                    "updated_by" => session("user")->account_id
                ]);
            } else {
                // Log::debug($key . " -> " . $value);
            }
        }

        DB::commit();

        return response()->json(true);
    }

    function updateExistQuestionW(Request $request, $questionId) {
        $data = $request->all();

        $questionText = $request["questionText"];
        $tags = $request["tags"];
        $solutionText = $request["solutionText"];
        $ansW = $request["ansW"];

        DB::beginTransaction();
        DB::enableQueryLog();

        MockExamDet::query()
            ->where("me_det_id", $questionId)
            ->update([
                "me_que" => $questionText,
                "me_soln" => $solutionText,
                "me_type" => 'W',
                "me_tags" => $tags,
                "updated_date" => date("Y-m-d H:i:s"),
                "updated_by" => session("user")->account_id
        ]);

        MockExamDetAns::query()
            ->where("me_det_id", $questionId)
            ->update([
                "me_ans" => $ansW,
                "updated_date" => date("Y-m-d H:i:s"),
                "updated_by" => session("user")->account_id
            ]);

        DB::commit();

        return response()->json(true);
    }

    function delMockDetail(Request $request){
        $meDetId = $request["meDetId"];
        DB::beginTransaction();
        try{
            MockExamDetAns::where('me_det_id', '=', $meDetId)->delete();
            MockExamDet::where('me_det_id', '=', $meDetId)->delete();
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return response()->json(array('status' => 400));
        }
            return response()->json(array('status' => 200));
    }

    function mockTmpYarjaList(){
        $result = DB::select('select me.me_id,emn.mx_name,me.me_time,
        count(met.me_sec)me_sec,sum(met.me_choice_total) me_choice,sum(met.me_write) me_write,
        me.me_status
        from mock_exam me
        join mock_exam_tmp met on me.me_id = met.me_id
        join exam_mx_name emn on me.mx_id = emn.mx_id
        group by me.me_id,emn.mx_name,me.me_time,me.me_status ');
        return Datatables::of($result)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = "<a href='/testmock/edittmp/$row->me_id' title='Edit Template'><i class='ri-edit-line'></i></a> <a href='javascript:delMockTmp($row->me_id)' title='Delete Template'><i class='ri-delete-bin-line'></i></a>";
                return $actionBtn;
            })
            ->addColumn('status', function($row){
                if($row->me_status=='A'){
                    $statusBtn = "<div class='custom-control custom-switch custom-switch-text custom-switch-color custom-control-inline'>
                    <div class='custom-switch-inner'>
                       <input type='checkbox' class='custom-control-input bg-success' id='meStatus-$row->me_id' checked='' onchange='changeStatus($row->me_id)'>
                       <label class='custom-control-label' for='meStatus-$row->me_id' data-on-label='Show' data-off-label='Hide'>
                       </label>
                    </div>
                  </div>";
                }else{
                    $statusBtn = "<div class='custom-control custom-switch custom-switch-text custom-switch-color custom-control-inline'>
                    <div class='custom-switch-inner'>
                       <input type='checkbox' class='custom-control-input bg-success' id='meStatus-$row->me_id' onchange='changeStatus($row->me_id)'>
                       <label class='custom-control-label' for='meStatus-$row->me_id' data-on-label='Show' data-off-label='Hide'>
                       </label>
                    </div>
                  </div>";
                }
                return $statusBtn;
            })
            ->rawColumns(['status', 'action'])
            ->whitelist(['me_id', 'mx_name','me_sec','me_choice','me_write'])
            ->make(true);
    }

    function changeStatus(Request $request) {
        DB::beginTransaction();

        MockExam::query()
        ->where("me_id", "=", $request["meId"])
        ->update([
        "me_status" => $request["status"],
        ]);
        DB::commit();

        return response()->json(true);
    }
    function initTmpEditPage(Request $request, $meId) {
        $tmp = DB::select('select * from mock_exam where me_id = ? ', [$meId]);
        $secs = DB::select('select * from mock_exam_tmp where me_id = ? ', [$meId]);
        $mx = DB::select('select * from exam_mx_name');
        $sub = DB::select('select * from exam_m_sub');
        $secTotal = count($secs);
        $probNum = 0;
        $tags = DB::select('select * from v_mock_exam_tag where me_id = ? ', [$meId]);
        foreach ($secs as $sec) {
            $probNum += intval($sec->me_choice_total) + intval($sec->me_write);
        }

        return view('test-mock.test-mock-edit-template', compact('tmp','secs','sub','mx','secTotal','probNum','tags'));
    }

    function delMockTmp(Request $request){
        $meId = $request["meId"];
        DB::beginTransaction();
        try{
            MockExamTmp::where('me_id', '=', $meId)->delete();
            MockExam::where('me_id', '=', $meId)->delete();
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return response()->json(array('status' => 400));
        }
            return response()->json(array('status' => 200));
    }

    function updtemplate(Request $request){
    $data = $request->all();
        DB::beginTransaction();
        if(session("user")->role =='A'){
            $me_status = 'A';
        }else{
            $me_status = 'I';
        }
        try{
            MockExam::query()
            ->where("me_id", $data["meId"])
            ->update([
                "mx_id" => $data["mxId"],
                "sub_id" => $data["subId"],
                "me_time" => $data["time"],
                "me_status" => $me_status,
                "updated_date" => date("Y-m-d H:i:s"),
                "updated_by" => session("user")->account_id
            ]);
            MockExamTmp::query()->where("me_id", $data["meId"])->delete();
            $j = 1;
            $tagNo = 0;
            for($i=1;$i<=intval($data["sections"]);$i++){

            $tagNo +=  intval($data["numProbC$i"]) + intval($data["numProbD$i"]);
            $tags = '';
                for($j; $j<=$tagNo ; $j++){
                    $tags = $tags.$data["tag$j"].'|';
                }
                MockExamTmp::query()->create([
                    "me_id" => $data["meId"],
                    "me_sec" => $i,
                    "me_choice_total" => intval($data["numProbC$i"]),
                    "me_choice" => intval($data["numC$i"]),
                    "me_write" => intval($data["numProbD$i"]),
                    "me_tags" => substr($tags, 0, -1),
                    "created_by" => session("user")->account_id,
                    "updated_by" => session("user")->account_id
                ]);

            }
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return $e->getMessage();
        }

        return response()->json($data);
    }
}
