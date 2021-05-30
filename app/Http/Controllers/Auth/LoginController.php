<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errorArray = [];
            foreach ($validator->errors()->all() as $message) {
                $errorArray[] = $message;
            }
            return response()->json([
                'code' => '001',
                'message' => $errorArray,
            ]);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'code' => '002',
                'message' => __('messages.invalid_login_details')
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'code' => '003',
                'message' => __('messages.unverified_email')
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $user_groups = $user->user_groups()->select(['code', 'name'])->get();

        return response()->json([
            'code' => '000',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user_groups' => $user_groups
        ]);
    }
    public function resendEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email'
        ]);

        if ($validator->fails()) {
            $errorArray = [];
            foreach ($validator->errors()->all() as $message) {
                $errorArray[] = $message;
            }
            return response()->json([
                'code' => '001',
                'message' => $errorArray,
            ]);
        }

        try {
            $user = User::where('email', $request['email'])->firstOrFail();
        } catch (\Throwable $th) {

            return response()->json([
                'code' => '002',
                'message' => __('messages.email_not_found')
            ]);
        }
        event(new Registered($user));

        return response()->json([
            'code' => '000',
            'message' => __('messages.resend_email_complete')
        ]);
    }
}
