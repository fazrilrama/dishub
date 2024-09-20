<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function login(Request $request) {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:8',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      return response()->json([
        'status' => true,
        'message' => 'Login berhasil!',
        'redirect_url' => url('/'),
      ]); 
    }

    return response()->json([
      'success' => false,
      'message' => 'Email atau password salah!',
    ]);
  }

  public function logout(Request $request)
  {
    Auth::logout();
    return response()->json([
      'status' => true,
      'message' => 'SUCCESS_LOGIN'
    ]);
  }
}
