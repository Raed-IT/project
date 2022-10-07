<?php

namespace App\Http\Controllers\app\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $validator = \Validator::make($request->all(), [ // <---
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      "pass" => "required",
    ]);

    if ($validator->fails()) {
      return response()->json(['success' => "error", "error" =>  $validator->errors()->first()]);
    }

    $user = User::create([
      "name" => $request->get('name'),
      "password" => bcrypt($request->get('pass')),
      "email" => $request->get('email'),
    ]);
    $token =  $user->createToken('app')->plainTextToken;


    return response()->json(['success' => "success", "user" => $user, "token" => $token]);
  }

  public function login(Request $request)
  {
    $user = User::where('email', $request->email)->first();

    if ($user == null) {
      return \response()->json(['success' => 'error', 'errors' => ['يرجى التحقق من معلومات الدخول']], 422);
    }
    $same = Hash::check($request->pass, $user->password);


    if (!$same) {
      return \response()->json(['success' => 'error', 'errors' => ['يرجى التحقق من معلومات الدخول']], 422);
    }

    $token = $user->createToken($user->email)->plainTextToken;
    return \response()->json(['success' => 'success', 'user' => $user, 'token' => $token]);
  }
}
