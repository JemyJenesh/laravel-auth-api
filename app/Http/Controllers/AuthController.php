<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
  public function register(Request $request) {
    $credentials = $request->validate([
      'name' => 'required|min:3',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:8',
    ]);
    $credentials['password'] = Hash::make($credentials['password']);
    $user = User::create($credentials);
    return response(['user' => $user, 'message' => 'User has been created']);
  }

  public function login(Request $request) {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);
    if (!auth()->attempt($credentials)) {
      return response(['message' => 'Invalid email or password'], 422);
    }
    $token = auth()->user()->createToken('auth-token')->plainTextToken;
    return response(['user' => auth()->user(), 'token' => $token]);
  }

  public function logout(Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response(['message' => 'User has been logged out']);
  }
}
