<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        //check if user exists
        $user = User::where('username', $username)
                    ->where('deleted_at', NULL)
                    ->first();
                
        if (!$user) {
            return redirect()
                ->back()
                ->withErrors(['text_username' => 'User not found'])
                ->withInput();
        }

        //check if password matches
        if (!password_verify($password, $user->password)) {
            return redirect()
                ->back()
                ->withErrors(['text_password' => 'Incorrect password'])
                ->withInput();
        }

        //update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ]
        ]);
        
        echo '<pre>';
        print_r($user);
    }

    public function logout()
    {
        //logout user
        session()->forget('user');
        return redirect()->route('login');
    }
}
