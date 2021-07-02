<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){

        $status = 200;
        $msg = 'User create';
        $token = null;

        $input = $request->all();

        $validator = Validator::make($input,[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password2' => 'required|same:password'
        ]);

        if($validator->fails()){
            $status = 500;
            $msg = 'Parameters incomplete';
        }else{
            $checkEmail = User::where('email',$input['email'])->first();
            if($checkEmail){
                $status = 500;
                $msg = 'Email already registred';
            }else{
                $input['password'] = bcrypt($input['password']);
                $user = User::create($input);
                $token = $user->createToken('access_personal')->plainTextToken;
            }
        }

        return response()->json([
            'status' => $status,
            'msg' => $msg,
            'token' => $token
        ]);

    }

    public function login(Request $request){
        $status = 200;
        $msg = 'Login';
        $token_access = null;

        if(Auth::attempt([
            'email' => $request->email,
            'password'=> $request->password
        ])){
            $user = Auth::user();
            $token_access = $user->createToken('Login')->plainTextToken;
        }else{
            $status = 500;
            $msg = 'Your email or password is not valid';
        }

        return response()->json([
            "status" => $status,
            "msg" => $msg,
            "token_access" => $token_access
        ]);
    }
}
