<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticationTokensController extends Controller
{
    //create a new token
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'device' => 'required'
        ]);

        $user = User::where('email', '=', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {

            $token = $user->createToken($request->device, ['qustions', 'answers']); //(device , Token Abilities)

            return Response::json([
                'token' => $token->plainTextToken,
                'user' => $user,
            ]);
        }

        return Response::json([
            'message' => 'Invalid email or password',
        ], 401);
    }

    //delete a token
    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();
        if ($token) {
            PersonalAccessToken::findToken($token)->delete();
        } else {
            $user->currentAccessToken()->delete();
        }

        return [];
    }

    //register a new user
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:7',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('postman', ['*']);

        return Response::json([
            'token' => $token->plainTextToken,
            'user' => $user,
        ], 201);
    }
}
