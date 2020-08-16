<?php

namespace App\Http\Controllers;

use App\Notifications\PasswordResetNotification;
use App\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller {
  public function sendEmail(Request $request) {
    $request->validate([
      'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
      return response()->json([
        'message' => 'We can\'t find a user with that e-mail address.',
      ], 404);
    }

    $passwordReset = PasswordReset::updateOrCreate(
      ['email' => $user->email],
      [
        'email' => $user->email,
        'token' => Str::random(60),
      ]
    );

    if ($user && $passwordReset) {
      $user->notify(
        new PasswordResetNotification($passwordReset->token, $passwordReset->otp)
      );
    }

    return response()->json([
      'message' => 'We have e-mailed your password reset link!',
    ]);
  }

  public function reset(Request $request) {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:8|confirmed',
      'token' => 'required',
    ]);

    $passwordReset = PasswordReset::where([
      ['token', $request->token],
      ['email', $request->email],
    ])->first();

    if (!$passwordReset) {
      return response()->json([
        'message' => 'The password reset token is either invalid or expired.',
      ], 404);
    }

    if (Carbon::parse($passwordReset->updated_at)->addMinutes(1)->isPast()) {
      $passwordReset->delete();
      return response()->json([
        'message' => 'The password reset token has expired.',
      ], 404);
    }

    $user = User::where('email', $passwordReset->email)->first();
    if (!$user) {
      return response()->json([
        'message' => 'We can\'t find a user with that e-mail address.',
      ], 404);
    }

    $user->password = Hash::make($request->password);
    $user->save();
    $passwordReset->delete();
    return response()->json($user);
  }
}
