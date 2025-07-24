<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Exception;

class UserService
{
    public function getall()
    {
        $users = User::all();
        return response()->json($users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->format('Y-m-d'),
                'updated_at' => $user->updated_at->format('Y-m-d'),
                'password' => $user->password, 
            ];
        }));
    }

    public function register(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    try {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $mailRequest = new Request([
            'messagebody' => 'Hello ' . $user->name . ', your registration was successful!'
        ]);

        $this->sendMailTo($user->email, $user->name, $mailRequest);

        return response()->json([
            'message' => 'User registered and mail sent successfully.'
        ], 201);

    } catch (Exception $e) {
        return response()->json([
            'error' => 'User registration failed',
            'details' => $e->getMessage()
        ], 500);
    }
    }



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth()->user();
        $token = $this->token($user);
        return response()->json([
            'user' => $user, 
            'token' => $token
    ], 200);
    }
    public function token(User $user)
    {
        return $user->createToken('auth_token')->plainTextToken;
    }



    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|string|min:8|confirmed',
       ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password reset successful'
        ]);
    }



    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $request->id,
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::findOrFail($request->id);
        $user->update($request->only('name', 'email'));
        return response()->json(['user' => $user], 200);
    }



    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::findOrFail($request->id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }



    public function getbyid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::findOrFail($request->id);
        return response()->json(['user' => $user], 200);
    }



public function sendMailTo($email,$name, Request $request)
{
    $validator = Validator::make($request->all(), [
        'messagebody' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    try {
        $mail = new TestMail($email, $name);
        Mail::to($email)->send($mail);
    } catch (Exception $e) {
        return response()->json(['error' => 'Failed to send email', 'details' => $e->getMessage()], 500);
    }
}

    
}
