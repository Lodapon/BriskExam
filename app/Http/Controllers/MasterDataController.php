<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Set;
use App\Models\Category;
use App\Models\Level;
use App\Models\MockUpName;
use App\Models\Tags;
use Illuminate\Support\Facades\DB;
class MasterDataController extends Controller
{
    public function subjects(){
        $subjects = Subject::select('sub_id', 'sub_name')->orderBy('sub_id')->get();
        return response()->json($subjects);
    }

    public function grades(){
        $grades = Grade::select('g_id', 'g_name')->orderBy('g_id')->get();
        return response()->json($grades);
    }

    public function chapters(){
        $chapters = Set::select('chap_id', 'chap_name')->orderBy('chap_id')->get();
        return response()->json($chapters);
    }

    public function categories($sub_id){
        $categories = Category::select('cate_id', 'cate_name')->where('sub_id',$sub_id)->get();
        return response()->json($categories);
    }

    public function levels(){
        $levels = Level::select('lv_id', 'lv_name')->get();
        return response()->json($levels);
    }

    public function mockNames(){
        $subjects = MockUpName::select('mx_id', 'mx_name')->orderBy('mx_id')->get();
        return response()->json($subjects);
    }

    public function addSubject(Request $request){
        $subname = $request["subname"];
        $count = Subject::where('sub_name', $subname)->count();
        if($count == 0){
            $subject = Subject::query()->create([
                "sub_name" => $subname,
                'created_by' => session("user")->account_id,
                'updated_by' => session("user")->account_id
            ]);
        }
        return response()->json($subject);
    }

    public function addMockName(Request $request){
        $mname = $request["mockname"];
        $count = MockUpName::where('mx_name', $mname)->count();
        if($count == 0){
            $subject = MockUpName::query()->create([
                "mx_name" => $mname,
                'created_by' => session("user")->account_id,
                'updated_by' => session("user")->account_id
            ]);
        }
        return response()->json($subject);
    }

    public function tags(Request $request){
        $tags = Tags::select('me_tags')->get();
        return response()->json($tags);
    }

    public function addGrades(Request $request){
        $gname = $request["gname"];
        $count = Grade::where('g_name', $gname)->count();
        if($count == 0){
            $grade = Grade::query()->create([
                "g_name" => $gname,
                'created_by' => session("user")->account_id,
                'updated_by' => session("user")->account_id
            ]);
        }
        return response()->json($grade);
    }

    public function addCategories(Request $request){
        $catename = $request["catename"];
        $subid = $request["subid"];
        $count = Category::where('cate_name', $catename)->where('sub_id', $subid)->count();
        if($count == 0){
            $cate = Category::query()->create([
                "cate_name" => $catename,
                "sub_id" => $subid,
                'created_by' => session("user")->account_id,
                'updated_by' => session("user")->account_id
            ]);
        }
        return response()->json($cate);
    }

    public function delSubject(Request $request){
        $subId = $request["subId"];
        DB::beginTransaction();
        try{
            Subject::where('sub_id', '=', $subId)->delete();
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return response()->json(array('status' => 400));
        }
            return response()->json(array('status' => 200));
    }

    public function delGrades(Request $request){
        $gId = $request["gId"];
        DB::beginTransaction();
        try{
            Grade::where('g_id', '=', $gId)->delete();
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return response()->json(array('status' => 400));
        }
            return response()->json(array('status' => 200));
    }

    public function delCategories(Request $request){
        $cateId = $request["cateId"];
        DB::beginTransaction();
        try{
            Category::where('cate_id', '=', $cateId)->delete();
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return response()->json(array('status' => 400));
        }
            return response()->json(array('status' => 200));
    }

    public function delMockName(Request $request){
        $mId = $request["mId"];
        DB::beginTransaction();
        try{
            MockUpName::where('mx_id', '=', $mId)->delete();
            DB::commit();
        } catch(\Exception $e){
        //if there is an error/exception in the above code before commit, it'll rollback
            DB::rollBack();
            return response()->json(array('status' => 400));
        }
            return response()->json(array('status' => 200));
    }
}
