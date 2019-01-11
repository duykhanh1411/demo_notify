<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use FCM;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\UserLogin;
use App\Models\UserInfo;
use App\User;
use Ixudra\Curl\Facades\Curl;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class LoginController extends BaseController
{


    public function showLogin()
    {
        if (Auth::check()) {
            // Create token
            echo 'aa';
        } else {
            return view('frmLogin');
        }

    } // frmLogin

    public function doLogin(Request $request)
    {
        $userLogin = new UserLogin();
        $user = new User();

        $respone = [];
        $respone['status'] = '';
        $respone['message'] = '';

        $data = $request->all();

        // Create a Curl
        $curlService = new \Ixudra\Curl\CurlService();

        $rules = array('input_email' => 'required',
            'input_password' => 'required|min:5'
        );
        /// \Log::debug($request);

        $messages = $this->modifine_messages_error();

        $loginValidator = Validator::make($data, $rules, $messages);

        if ($loginValidator->fails()) {
            $errors = $loginValidator->errors()->all();
            $respone['status'] = 0;
            $respone['message'] = $errors;
            return $respone; //view('doLogin')->with("show_error",  $errors );
        } else {
            $userdata = array("email" => $request->input_email, "password" => $request->input_password);
            if (Auth::attempt($userdata)) {
                //User::reguard();

                $respone['status'] = 1;
                $respone['message'] = 'Login Success';

                return $respone;

                // $str_request_token = 'http://localhost/learning_laravel_api/public/api/auth/create/'.$request->input_email.'/'.$request->input_password;
                // $response_token = Curl::to($str_request_token)->get();
                /* if($response_token){
                     return $response_token ;
                 }
                 else{
                     return false; //view('doLogin')->with("show_error", array('Please login'));
                 } */
            } else {
                $respone['status'] = 1;
                $respone['message'] = 'User or password not exist';
                return $respone; //view('doLogin')->with("show_error", array('User hoac password khong chinh xac'));
            }
        }
    } // doLogin


    public function modifine_messages_error()
    {
        return $messages_error = [
            'input_email.required' => 'Vui long nhap Email.',
            'input_password.required' => 'Vui long nhap Password.',
            'input_password.min' => 'Password phai dai hon 5 ky tu.',
        ];

    }

    public function notify(Request $request) {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $optionBuilder->setPriority("high");


        $notificationBuilder = new PayloadNotificationBuilder('my title khanh huynh');
        $notificationBuilder->setBody('Hello world ^_^')
            ->setSound('default')
            ->setTag('khanh');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'khanhHD-1']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        //$token = "eMEvJ6Dy8QQ:APA91bEaRGbeVYVoJgY_shPeHPo9-F6ELcqegxo3hUkn8Zxzn58MzcPpuLhcQUO2Qj_Q3wVfKjPkEpdM83kQkpxblp-5JPDxwquTw2rTFTVfJOjLy-HcWKdI-DtOVM2xjP-xXwKY9eI8";
        //$token = "cLkvuHh_6UE:APA91bHmNXThe7xnydyvEtsXlel20-vNSzhKpKfkXcVY552YK3iD7eLxHsXPp8gd7qFh2lt7lXHE-bMZR8v7CizuOKA51BHaOcau2XZTwXUkydoJejDzcEC2WdoB-yVBQuw7CVDI1J3W";
        $token = "c0BbhnezQH0:APA91bHe_n-o6VBJ8FFzIOV0IWfWq6mwAMfJpJEEmsbCK-aBQ1tY7xtSifNZnMYJo_NEFfj18Dc-qwtChCEHJRuahZCC1b2am9UleTe_vpvCJW_8FXjCgbmOA2pZLIqO6sC8zN5gOlsud";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        //return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();

        //return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();
        return 'ok';
    }
}
