<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Ichtrojan\Otp\Otp;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'otp' => 'numeric|digits:4',
        ]);

        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 400);
        }

        $otpValidation = (new Otp)->validate(Auth::user()->email, $request->otp);

        if (! $otpValidation->status) {
            return response()->json(['message' => $otpValidation->message], 400);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return response()->json(['message' => 'Email verified.'], 200);
    }
}
