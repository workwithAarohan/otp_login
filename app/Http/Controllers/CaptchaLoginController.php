<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Rules\Captcha;

class CaptchaLoginController extends Controller
{
    //
    public function loginForm()
    {
        return view('captchaLogin');
    }

    public function login(Request $request)
    {
        // Validation Section
        $request->validate([
            'email' => 'required|email|',
            'password' => 'required|min:8|max:16',
            'g-recaptcha-response' => new Captcha(),
        ]);

        /**
         * Authenticate user
         */
        $userInfo = User::where('email', $request->email)->first();

        if(!$userInfo)
        {
            return back()->with('Fail', 'No user found.');
        }

        else
        {
            if(Hash::check($request->password, $userInfo->password))
            {
                // $request->session()->put('LoggedUser', $userInfo->id);

                // return redirect('/dashboard');
                return redirect('/sendOTP/'. $userInfo->mobile);
            }
            else
            {
                return back()->with('Fail', 'Incorrect Password');
            }
        }

    }

    public function sendOTP($mobile)
    {
        $otp = rand(1111,9999);
        $user = User::where('mobile', $mobile)->first();

        $user->otp = $otp;
        $user->save();
        dd($user->otp);

        $nexmo = app('Nexmo\Client');
        $nexmo->message()->send([
            'to' => '+977' . (int) $user->mobile,
            'from' => 'Laravel',
            'text' => 'Login code for Laravel: ' . $otp
        ]);


        return redirect('/otpVerificationPage');
    }

    public function OTP_VerificationPage()
    {
        return view('otplogin.otpVerification');
    }

    public function verifyOTP(Request $request)
    {
        // Validation Section
        $request->validate([
            'otp' => 'required',
        ]);

        $user = User::where('otp', $request->otp)->first();
        if($user)
        {
            $user->otp = NULL;
            $user->save();
            $request->session()->put('LoggedUser', $user->id);

            return redirect('/dashboard');
        }
        else
        {
            return back()->with('Fail', 'Incorrect Code');
        }
    }

    public function dashboard()
    {
        return view('dashboard', [
            'LoggedUserInfo' => User::where('id', session('LoggedUser'))->first()
        ]);
    }
}
