<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Utils\SecureUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class SignUpController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function signUp(Request $request) {

        $acctype = $request["acctype"];
        $firstname = $request["firstname"];
        $lastname = $request["lastname"];
        $address = $request["address"];
        $birthdate = Carbon::createFromFormat('d/m/Y', $request["birthdate"])->format('Y-m-d');
        $school = $request["school"];
        $occupation = $request["occupation"];
        $accnum = $request["accnum"];
        $bank = $request["bank"];
        $email = $request["email"];
        $username = $request['username'];
        $psw = $request['psw'];
        $salt = SecureUtil::generateRandomString();
        $passwd = SecureUtil::hashing([$username, $psw, $salt]);
        DB::beginTransaction();
        try{
        $accId = DB::table("user_account")->insertGetId(
            ['username' => $username,
            'password' => $passwd,
            'salt' => $salt,
            'role' => $acctype,
            'status' => 'I',
            'email' => $email,
            'created_date' => date("Y-m-d")
            ]
        );
        $pimg = file_get_contents($_FILES['profileImg']['tmp_name']);
        $pimgType = getimagesize($_FILES['profileImg']['tmp_name'])['mime'];
        DB::table("user_profile")->insert(
            ['account_id' => $accId ,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'birth_date' => $birthdate,
            'school' => $school,
            'occupation' => $occupation,
            'address' => $address,
            'profile_img' => $pimg,
            'profile_img_type' => $pimgType,
            'created_date' => date("Y-m-d"),
            'created_by' => $accId,
            'updated_date' => date("Y-m-d")
            ]
        );
        DB::table("user_credit_trans")->insert(
            ['account_id' => $accId ,
            'tran_amt' => 0.00,
            'balance_amt' => 0.00,
            'balance_amt_bf' => 0.00,
            'tran_type' => 'A',
            'created_date' => date("Y-m-d H:i:s"),
            'created_by' => $accId
            ]
        );

        DB::commit();
    } catch(\Exception $e){
    //if there is an error/exception in the above code before commit, it'll rollback
        DB::rollBack();
        return $e->getMessage();
    }
    $pics = DB::select('select * from user_profile where account_id = ? ',array($accId));
    $profileImg = 'data:'.$pics[0]->profile_img_type.';base64,'.base64_encode( $pics[0]->profile_img );
    Alert::success('You have signed up successfully.');
    return view('/signin')->with('message', 'You have signed up successfully')->with('pic',$profileImg);
    }

    public function showProfileImg(Request $request) {

        $accId = 25;
        try{
            $pics = DB::select('select * from user_profile where account_id = ? ',array($accId));
        } catch(\Exception $e){

        return $e->getMessage();
        }

    $profileImg = 'data:'.$pics[0]->profile_img_type.';base64,'.base64_encode( $pics[0]->profile_img );
    return view('/showImg')->with('pic',$profileImg);
    }

    public function chkMail(Request $request) {
        try{
            $email = $request["email"];
            $chkMail = DB::table('user_account')->where('email',$email)->count();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    return response()->json($chkMail);
    }

    // public function chkUser(Request $request) {
    //     try{
    //         $username = $request["username"];
    //         $chkUser = DB::table('user_account')->where('username',$username)->count();
    //     }catch(\Exception $e){
    //         return $e->getMessage();
    //     }
    // return response()->json($chkUser);
    // }

    public function signUpErr(Request $request) {
        $img = '../../assets/images/user/1.jpg';
        Alert::error('Invalid Credential');
        return view('/signin')->with('pic',$img);
    }
}

