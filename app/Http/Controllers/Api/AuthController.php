<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request){

        // validation
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required | email',
            'phoneno' => 'required',
            'password' => 'required',
            'cpassword' =>'required |same:password'

        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response,400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User registered successfully'
        ];

        return response()->json($response,200);
    }

    public function login(Request $request){
        if(Auth::attempt(['email'=> $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            
            $cookie = cookie('jwt', $token, minutes:60*24);
            $success['name'] = $user->name;
            $success['userId'] = $user->id;

            return response([
                'success' => true,
                'data' => $success,
                'message' => 'User Login Successfully'
            ])->withCookie($cookie);

        }else{
            $response = [
                'success' => false,
                'message' => 'Invalid Credentials'

            ];
            return response()->json($response,status: Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(){
        $cookie = Cookie::forget('jwt');
        return response(['success' => true,'message' => 'Successfully logged out'])->withCookie($cookie);
    }

    public function user(){
        return Auth::user();
    }
}
