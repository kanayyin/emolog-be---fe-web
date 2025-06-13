<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Registrasi berhasil'], 201);
        } else {
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Username atau password salah'], 401);
            } else {
                return back()->withErrors([
                    'username' => 'Username atau password salah.',
                ])->withInput();
            }
        }

        if ($request->expectsJson()) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        } else {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/home')->with('success', 'Login berhasil!');
        }
    }

    public function logout(Request $request)
    {
        if ($request->expectsJson()) {
            $user = $request->user();
            if ($user) {
                $user->currentAccessToken()->delete();
            }
            return response()->json(['message' => 'Logout berhasil']);
        } else {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('success', 'Logout berhasil.');
        }
    }

    public function checkUser(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'email' => 'required|email',
    ]);

    $user = User::where('username', $request->username)
        ->where('email', $request->email)
        ->first();

    if (!$user) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        } else {
            return redirect()->back()->withErrors(['message' => 'User tidak ditemukan'])->withInput();
        }
    }

    if ($request->expectsJson()) {
        return response()->json(['message' => 'User ditemukan']);
    } else {
        return redirect()->route('password.form', ['username' => $user->username])
            ->with('success', 'User ditemukan. Silakan ganti password.');
    }
}


    public function changePassword(Request $request)
{
    $request->validate([
        'new_password' => 'required|string|min:6|confirmed', // harus kirim juga password_confirmation
    ]);

    $user = $request->user();

    if (!$user) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        } else {
            return redirect()->route('login')->withErrors(['message' => 'Anda belum login']);
        }
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    if ($request->expectsJson()) {
        return response()->json(['message' => 'Password berhasil diubah']);
    } else {
        return redirect()->route('home')->with('success', 'Password berhasil diubah');
    }
}

}
