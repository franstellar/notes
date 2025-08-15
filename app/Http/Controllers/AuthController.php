<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view ('login');
    }

    public function authenticate (Request $request)
    {
        //form validation
        $request->validate([
            'text_username' => 'required|email',
            'text_password' => 'required|min:6|max:16'
        ],[
            //custom error messages
            'text_username.required' => 'The username field is required',
            'text_username.email' => 'The username must be a valid email address',
            'text_password.required' => 'The password field is required',
            'text_password.min' => 'The password must be at least :min characters',
            'text_password.max' => 'The password may not be greater than :max characters',
        ]);

        //get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        echo $request->input('text_username');
        echo '<br>';
        echo $request->input('text_password');
    }

    public function logout()
    {
        echo 'logout';
    }
}
