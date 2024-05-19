<?php


namespace App\Http\Controllers;


use App\Http\Utils\MailUtils;
use App\Http\Utils\SecureUtil;
use App\Models\UserAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ResetPasswordController
{

    public function initialResetForm() {
        return view("reset-pw.reset");
    }

    public function requestReset(Request $request): JsonResponse {
        $email = $request["email"];

        $accountToReset = UserAccount::query()
            ->where("email", "=", $email)
            ->first(["username", "password"]);

        if (null != $accountToReset) {
            MailUtils::sendMailResetPassword($email, $accountToReset->username, config("app.url")."/reset/confirm/" . $accountToReset->password);
        }

        return response()->json(null != $accountToReset);
    }

    public function initialConfirmForm($oldPassHash) {
        return view("reset-pw.confirm")->with(["resetToken"=>$oldPassHash]);
    }

    public function updateNewPassword(Request $request) {
        $oldPassHash = $request["resetToken"];
        $rawNewPass = $request["password1"];
        $rawNewPass2 = $request["password2"];

        if ($rawNewPass != $rawNewPass2) {
            return response()->json(false);
//            return Redirect::back()->with('message', "Password mismatch.");
        }

        $accountToReset = UserAccount::query()
            ->where("password", "=", $oldPassHash)
            ->first(["account_id", "username", "email"]);

        if (null != $accountToReset) {

            $newSalt = SecureUtil::generateRandomString();
            $newPassword = SecureUtil::hashing([$accountToReset->username, $rawNewPass, $newSalt]);

            UserAccount::query()
                ->where("account_id", "=", $accountToReset->account_id)
                ->update([
                    "salt" => $newSalt,
                    "password" => $newPassword
                ]);

            MailUtils::sendMailPasswordChanged($accountToReset->email, $accountToReset->username);

            return response()->json(true);
//            return redirect('/')->with('message', "Your password was changed, please login.");
        } else {
            return response()->json(false);
//            return redirect('/')->with('message', "Invalid condition, please try again.");
        }

    }

}
