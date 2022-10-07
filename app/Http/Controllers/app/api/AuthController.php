<?php

namespace App\Http\Controllers\app\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
}
