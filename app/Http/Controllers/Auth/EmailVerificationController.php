<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EmailVerificationController extends Controller
{
    //
    public function verify(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'di' => 'required|integer',
            'email' => 'required|string|email',
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

            $user = User::where('id', $validatedData['di'])->where('email', $validatedData['email'])->firstOrFail();

            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }

            $message = __('messages.email_verify_complete');

            return view('auth.verify-email-complete', ['message' => $message]);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json([
                'code' => '002',
                'message' => $th->getMessage()
            ]);
        }
    }
}
