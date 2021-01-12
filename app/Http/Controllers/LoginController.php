<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //

    public function login(Request $request) {
        $rules = [
            'email' => 'required|string|email|max:255|exists:users,email',
            'password' => 'required|string|min:8',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response($validation->errors(), 400);
        }
        $credentials = request()->only(['email', 'password']);
        if(auth()->attempt($credentials)) {
            $token = $request->user()->createToken("GeoJunkies");
            return response(['token' => $token->plainTextToken, 'username' => $request->user()->name], 201);
        }
        return response(['message' => ['Wrong password!']], 401);
    }
}
