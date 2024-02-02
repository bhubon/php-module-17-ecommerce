<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Models\User;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function userLogin(Request $request)
    {
        try {
            $userMail = $request->email;
            $otp = rand(100000, 999999);
            $details = ['code' => $otp];

            Mail::to($userMail)->send(new OTPMail($details));
            User::updateOrCreate(['email' => $userMail], ['email' => $userMail, 'otp' => $otp]);

            return ResponseHelper::Out('success', 'A 6 Digit OTP has been sent to your email address', 200);
        } catch (\Exception $e) {
            return ResponseHelper::Out('failed', $e, 200);
        }
    }
    public function verifyLogin(Request $request)
    {
        $userMail = $request->email;
        $otp = $request->otp;

        $verification = User::where(['email' => $userMail, 'otp' => $otp])->first();

        if ($verification) {
            User::where(['email' => $userMail, 'otp' => $otp])->update(['otp' => '0']);
            $token = JWTToken::createToken($userMail, $verification->id);
            return ResponseHelper::Out('success', '', 200)->cookie('token', $token, 60 * 24 * 30);
        } else {
            return ResponseHelper::Out('failed', null, 401);
        }
    }
    public function userLogout()
    {
        return redirect('userLoginPage')->cookie('token', '', -1);
    }
}
