<?php

namespace App\Http\Controllers;

use App\Models\BookShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\BookExam;
use App\Models\BookExamTmp;
use RealRashid\SweetAlert\Facades\Alert;

class BookshelfController extends Controller
{

    function getBookList() {
        $result = BookShop::query();
        return Datatables::of($result)
            ->addIndexColumn()
            ->addColumn('bookName', function($row){
                return $row -> book_name;
            })
            ->addColumn('bookTotal', function($row){
                return $row -> book_total;
            })
            ->addColumn('bookPrice', function($row){
                return $row -> book_price;
            })
            ->addColumn('createdBy', function($row){
                return $row -> created_by;
            })
            ->addColumn('createdDate', function($row){
                return $row -> created_date;
            })
            ->addColumn('viewButton', function($row){
                $actionBtn = '<a class="previewBook" href="#"><i class="ri-eye-line"></a></i>';
                return $actionBtn;
            })
            ->addColumn('deleteButton', function($row){
                $actionBtn = '<button type="button" class="btn btn-danger mb-3 deleteButton">Delete</button>';
                $hiddenElement = '<input type="hidden" class="bookId" value="'.$row->book_id.'" />';
                return $actionBtn . $hiddenElement;
            })
            ->rawColumns(['viewButton', 'deleteButton'])
            ->make(true);
    }

    function getBookDetail($bookId) {
        $book = BookShop::query()
            ->where("book_id", "=", $bookId)
            ->first();

        return response()->json([
            "bookName"  => $book->book_name,
            "bookDetail"=> $book->book_detail,
            "bookYear"  => $book->book_year,
            "bookTotal" => $book->book_total,
            "bookPrice" => $book->book_price,
            "bookImage" => base64_encode($book->book_img)
        ]);
    }

    function save(Request $request) {
        $bookName = $request["bookName"];
        $bookDes = $request["bookDes"];
        $year = $request["year"];
        $probNum = $request["probNum"];
        $price = $request["price"];
        $coverImg = file_get_contents($request["coverImg"]);

        DB::beginTransaction();
        BookShop::query()->create([
            "book_name" => $bookName,
            "book_detail" => $bookDes,
            "book_year" => $year,
            "book_total" => $probNum,
            "book_price" => $price,
            "book_img" => $coverImg,
            "book_available" => true
        ]);
        DB::commit();
    }

    function delete($bookId) {
        DB::beginTransaction();
        BookShop::query()
            ->where("book_id", "=", $bookId)
            ->delete();
        DB::commit();
    }

    function createtemplate(Request $request) {
        $data = $request->all();
        DB::beginTransaction();
        if(session("user")->role =='A'){
            $be_status = 'A';
        }else{
            $be_status = 'I';
        }
        try{
        $test = BookExam::query()->create([
            "mx_id" => $data["mxId"],
            "sub_id" => $data["subId"],
            // "ิbe_time" => $data["time"],
            "be_status" => $be_status,
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
            BookExamTmp::query()->create([
                "be_id" => $test->id,
                "be_sec" => $i,
                "be_choice_total" => intval($data["numProbC$i"]),
                "be_choice" => intval($data["numC$i"]),
                "be_write" => intval($data["numProbD$i"]),
                "be_tags" => substr($tags, 0, -1),
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

    function bookTmpYarjaList(){
        $result = DB::select('select be.be_id,ems.sub_name,emn.mx_name,
        count(bet.be_sec)be_sec,sum(bet.be_choice_total) be_choice,sum(bet.be_write) be_write,
        be.be_status
        from book_exam be
        join book_exam_tmp bet on be.be_id = bet.be_id
        join exam_mx_name emn on be.mx_id = emn.mx_id
        join exam_m_sub ems on be.sub_id = ems.sub_id
        group by be.be_id,emn.mx_name,be.be_status');
        return Datatables::of($result)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = "<a href='/admin/edittmp/$row->be_id' title='Edit Template'><i class='ri-edit-line'></i></a> <a href='javascript:delTmp($row->be_id)' title='Delete Template'><i class='ri-delete-bin-line'></i></a>";
                return $actionBtn;
            })
            ->addColumn('print', function($row){
                    $statusBtn = "<a href='/admin/printtmp/$row->be_id' title='Edit Template'><i class='ri-eye-line'></i></a>";

                return $statusBtn;
            })
            ->rawColumns(['print', 'action'])
            ->make(true);
    }

    function initTmpEditPage(Request $request, $beId) {
        $tmp = DB::select('select * from book_exam where be_id = ? ', [$beId]);
        $secs = DB::select('select * from book_exam_tmp where be_id = ? ', [$beId]);
        $mx = DB::select('select * from exam_mx_name');
        $sub = DB::select('select * from exam_m_sub');
        $secTotal = count($secs);
        $probNum = 0;
        $tags = DB::select('select * from v_book_exam_tag where be_id = ? ', [$beId]);
        foreach ($secs as $sec) {
            $probNum += intval($sec->be_choice_total) + intval($sec->be_write);
        }

        return view('admin.edittemplate', compact('tmp','secs','sub','mx','secTotal','probNum','tags'));
    }

    function delTmp(Request $request){
        $beId = $request["beId"];
        DB::beginTransaction();
        try{
            BookExamTmp::where('be_id', '=', $beId)->delete();
            BookExam::where('be_id', '=', $beId)->delete();
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
            $be_status = 'A';
        }else{
            $be_status = 'I';
        }
        try{
            BookExam::query()
            ->where("be_id", $data["beId"])
            ->update([
                "mx_id" => $data["mxId"],
                "sub_id" => $data["subId"],
                // "me_time" => $data["time"],
                "be_status" => $be_status,
                "updated_date" => date("Y-m-d H:i:s"),
                "updated_by" => session("user")->account_id
            ]);
            BookExamTmp::query()->where("be_id", $data["beId"])->delete();
            $j = 1;
            $tagNo = 0;
            for($i=1;$i<=intval($data["sections"]);$i++){

            $tagNo +=  intval($data["numProbC$i"]) + intval($data["numProbD$i"]);
            $tags = '';
                for($j; $j<=$tagNo ; $j++){
                    $tags = $tags.$data["tag$j"].'|';
                }
                BookExamTmp::query()->create([
                    "be_id" => $data["beId"],
                    "be_sec" => $i,
                    "be_choice_total" => intval($data["numProbC$i"]),
                    "be_choice" => intval($data["numC$i"]),
                    "be_write" => intval($data["numProbD$i"]),
                    "be_tags" => substr($tags, 0, -1),
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

    function initTmpViewPage(Request $request, $beId) {
        $id = session("user")->account_id;
        $mtmp = DB::select('select CONCAT(ems.sub_name, " - " ,emn.mx_name) mx_name,bet.be_id ,bet.be_choice_total,bet.be_choice,bet.be_sec,bet.be_write,vbet.be_tags
        from book_exam_tmp bet
        join v_book_exam_tag vbet on bet.be_id = vbet.be_id and bet.be_sec = vbet.be_sec
        join book_exam be on be.be_id = bet.be_id
        join exam_mx_name emn on be.mx_id = emn.mx_id
        join exam_m_sub ems on be.sub_id = ems.sub_id
        where bet.be_id = ?', [$beId]);

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
            if($oldSec==$tmp->be_sec){
                //ข้อที่
                $proc++;
                //sec ที่
                $oldSec = $tmp->be_sec;

            }else{
                //set ข้อใหม่ตาม sec
                $proc=1;
                $oldSec = $tmp->be_sec;

            }

            $tags = explode(',',$tmp->be_tags);
            foreach($tags as $key) {
                $tagSql = $tagSql.' and vmed.me_tags like "%'.$key.'%"';
            }
            //check ข้อช้อมครบแล้วมี ข้อเขียนบ่
            if($proc > $tmp->be_choice_total){
                if($tmp->be_write>0){
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
                , [$tmp->be_choice]);
            }
            if(!count($mocDet)==0){
                $medetId = $medetId.','.$mocDet[0]->me_det_id.',';
                array_push($midArr,$mocDet[0]->me_det_id);
            }else{
                //error no exam
                Alert::error('This Exam Error', 'Please Add exam '.$tmp->be_choice.' choices and tags :'. $tmp->be_tags);
                // Alert::success('Hello');
                return view('admin/print');
            }


        }
        $data = DB::table('mock_exam_det')
        ->join('mock_exam_det_ans','mock_exam_det.me_det_id' ,'=' ,'mock_exam_det_ans.me_det_id')
        ->whereIn('mock_exam_det.me_det_id',$midArr)
        // ->groupBy('fix_exam_det.fe_det_id')
        ->select('mock_exam_det.me_det_id','mock_exam_det.me_que','mock_exam_det_ans.me_ans_no','mock_exam_det_ans.me_ans','mock_exam_det.me_type','mock_exam_det.me_soln')
        ->orderByRaw('FIELD(mock_exam_det.me_det_id,'.implode(",",$midArr).')')
        ->get();
        $data = $data->groupBy('me_que');
        $test = $data;
        $exname = $mtmp[0]->mx_name;
        // foreach ($midArr as $value) {

        //     echo $value->me_det_id.',';
        //  }
        // echo $mtmp;
        $mid = implode(",",$midArr);
        // return view('std.mock.test', compact('mtmp','test','exname','total','time','meId','mid'));

        return view('admin.printview', compact('mtmp','test','exname'));
    }
}
