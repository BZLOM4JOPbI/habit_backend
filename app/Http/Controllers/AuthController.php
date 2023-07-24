<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function sign_up (Request $request) {
        $data = $request->validate([
            'name' => 'required|string|min:4|max:20',
            'email' => 'required|string|unique:users,email|min:6|max:100',
            'phone' => 'required|string|unique:users,phone|min:18|max:18',
            'password' => 'required|string|confirmed|min:6|max:20',
        ]);
        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        $token = $user->createToken('apiToken')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token
        ];
        return response($res, 201);
    }
}
