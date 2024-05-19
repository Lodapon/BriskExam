<?php


namespace App\Http\Utils;


use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailUtils
{

    public static function sendMailResetPassword($emailTo, $accountName, $link) : void {
        try {
            $data = [
                'accountName' => $accountName,
                'link'=> $link
            ];

            Mail::send('mail.resetpass', $data, function($message) use ($emailTo) {
                $message->to($emailTo)
                        ->subject("Reset password.");
                $message->from('noreply@briskexam.com','BriskExam');
            });

        } catch (Exception $e) {
            Log::error('Caught exception: '.$e->getMessage());
        }
    }

    public static function sendMailPasswordChanged($emailTo, $accountName) : void {
        try {
            $data = [
                'accountName' => $accountName
            ];

            Mail::send('mail.passchanged', $data, function($message) use ($emailTo) {
                $message->to($emailTo)
                    ->subject("Password changed.");
                $message->from('noreply@briskexam.com','BriskExam');
            });

        } catch (Exception $e) {
            Log::error('Caught exception: '.$e->getMessage());
        }
    }

}
