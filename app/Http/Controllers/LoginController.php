<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admins;
use App\Models\Tokens;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $admin = Admins::where('username', $username)->first();

        if ($admin && $admin->password === $password) {
            return response()->json(['message' => 'Login successful']);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function loginWithToken(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $admin = Admins::where('username', $username)->first();

        if ($admin && $admin->password === $password) {
            $token = Tokens::generateToken($admin);
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function checkToken($token)
    {
        $tokenObj = Tokens::where('access_token', $token)->first();

        if ($tokenObj) {
            if ($tokenObj->expired_at < now()) {
                $tokenObj->delete();
                return response()->json(['message' => 'Token expired and deleted'], 401);
            } else {
                $admin = Admins::where('username', $tokenObj->username)->first();
                return response()->json([
                    'message' => 'Token is valid',
                    'username' => $admin->username,
                    'password' => $admin->password
                ]);
            }
        } else {
            return response()->json(['message' => 'Invalid token'], 401);
        }
    }

    public function logout(Request $request)
    {
        $username = $request->input('username');

        if ($username) {
            $tokenObj = Tokens::where('username', $username)->first();

            if ($tokenObj) {
                $tokenObj->delete();
            }
        }

        return response()->json(['message' => 'Logout successful']);
    }
    public function updatePassword(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $newPassword = $request->input('new_password');
        $confirmPassword = $request->input('confirm_password');
    
        $admin = Admins::where('username', $username)->first();
    
        if ($admin && $admin->password === $password) {
            if ($newPassword === $confirmPassword) {
                $admin->password = $newPassword;
                $admin->save();
    
                return response()->json(['message' => 'Password updated successfully']);
            } else {
                return response()->json(['message' => 'New password and confirmation password do not match'], 400);
            }
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
    

    public function updateUsername(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $newUsername = $request->input('new_username');
    
        $admin = Admins::where('username', $username)->first();
    
        if ($admin && $admin->password === $password) {
            // Cek apakah ada token terkait dengan username lama
            $tokenObj = Tokens::where('username', $username)->first();
            if ($tokenObj) {
                $tokenObj->delete(); // Hapus token
            }
    
            $admin->username = $newUsername;
            $admin->save();
    
            return response()->json(['message' => 'Username updated successfully']);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
    
}
