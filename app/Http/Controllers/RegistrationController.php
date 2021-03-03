<?php

namespace App\Http\Controllers;

//use Illuminate\Contracts\Validation\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{

    /**
     * Store a newly created user with email, name, and password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * Returns newly registered user information.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|max:20|same:password'
        ]);

        if($validator->fails()){
            return response($validator->errors(), 400);
        }

        $user = User::create(array_merge(
            $request->all(),
            ['password' => bcrypt($request->password)]
        ));

        return response([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
}
