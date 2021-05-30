<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    //
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
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
        $validatedData = $validator->validated();
        try {
            //code...
            DB::beginTransaction();
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            event(new Registered($user));

            // $token = $user->createToken('auth_token')->plainTextToken;
            DB::commit();
            // return response()->json([
            //     'code' => '000',
            //     'access_token' => $token,
            //     'token_type' => 'Bearer',
            // ]);
            return response()->json([
                'code' => '000',
                'message' => __('messages.registration_success')
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'code' => '002',
                'message' => $th->getMessage()
            ]);
        }
    }
}
