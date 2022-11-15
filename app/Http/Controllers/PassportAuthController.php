<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{
    //index
    public function index()
    {
        return response()->json([
            'message' => 'Welcome to the API'
        ], 200);
    }
    
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // if user exists
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                'message' => 'User already exists'
            ], 409);
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        
        $token = $user->createToken('LaravelAuthApp')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Wrong Email/Password!'], 401);
        }
    }   

    /**
     * Logout
     */
    public function logout()
    {
        auth()->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Me
     */
    public function me()
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }

    /**
     * Refresh Token to new token passport
     */
    public function refresh()
    {
        $refreshToken = auth()->user()->token();
        $refreshToken->revoke();
        $newToken = auth()->user()->createToken('LaravelAuthApp')->accessToken;
        return response()->json(['token' => $newToken], 200);
    }

}
