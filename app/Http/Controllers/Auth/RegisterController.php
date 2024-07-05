<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Create user data
        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            //'updated_at' => now(),
        ];

        // Insert data into the database
        $userId = DB::table('users')->insertGetId($user);

        // Fetch the created user (without password)
        $createdUser = DB::table('users')->where('id', $userId)->first();

        // Return the response
        return response()->json([
            'status' => 'success',
            'message' => 'User successfully registered',
            'user' => $createdUser,
        ], 201);
    }
}

