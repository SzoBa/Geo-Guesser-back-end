<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    /**
     * Validate and check user information in database.
     * Validation approved -> create token for user.
     * Validation failed -> return error message.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request) {
        $rules = [
            'email' => 'required|string|email|max:255|exists:users,email',
            'password' => 'required|string|min:6',
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

    /**
     * Delete user token on Logout request.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response(["message" => "Logout successful"], 204);
    }
}
