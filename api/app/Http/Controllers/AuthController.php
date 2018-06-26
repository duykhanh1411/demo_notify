<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use JWTAuth;
use Mockery\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends BaseController
{

    public function createAuthenticate(Request $request)
    {
        try{
            // lấy thông tin từ các request gửi lên
            $credentials = $request->only('name', 'password');
            /* $infoUser = array('name' => $request->id, 'password' => $request->password);*/
            // xác nhận thông tin người dùng gửi lên có hợp lệ hay không
            /*\Log::debug(JWTAuth::attempt($credentials));*/

            if (!$token = JWTAuth::attempt($credentials)) {
                $result = array(
                    'token'=> "",
                    'error'=>"401",
                );
                /*  return response()->json(['error' => 'Email or password invalid'], 401);*/
                return response()->json($result,401);
            }
            // Trả về Token đã đăng ký
            //echo response()->json(compact('token'));
            $infoUser =JWTAuth::toUser($token);
            $imageUrl= 'api\public\uploads'.'\\'.$infoUser->image;
            $result = array(
                'token'=> $token,
                'error'=>"0",
                'userName'=>$infoUser->name,
                'imageUrl'=>$imageUrl
            );
            return response()->json($result);
        }
        catch (Exception $ex){
            \Log::error($ex);
            $result = array(
                'token'=> "",
                'error'=>"500",
            );
            return response()->json($result, 500);
        }
    }

    public function getAuthenticate(Request $request)
    {
        try {
            if (!$infoUser = JWTAuth::parseToken()->authenticate()) {
                $result = array(
                    'check'=> false,
                    'error'=>"401",
                );
                return response()->json($result);
            }
            //echo $token = JWTAuth::getToken(); // Lay nguyen chuoi Token
            $result = array(
                'check'=> true,
                'error'=>"0",
                'infoUser'=> compact('infoUser'),
            );
          /*  echo response()->json(compact('infoUser'));*/
            return response()->json($result);
        }catch (Exception $ex){
            \Log::error($ex);
            $result = array(
                'check'=> false,
                'error'=>"500",
            );
            return response()->json($result);
        }
    }
}
