<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\SendEmailException;
use App\Http\Controllers\Controller;
use App\Mail\ConfirmationMail;
use Exception;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailVerificationNotificationController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 400);
        }

        try {
            $userEmail = Auth::user()->email;
            $otp = (new Otp)->generate($userEmail, 'numeric', 4, 30);
            if (! $otp->status) {
                throw new SendEmailException($otp->message, 502);
            }
            Mail::to($userEmail)->send(new ConfirmationMail($otp->token));
        } catch (Exception $e) {
            report($e);
            throw new SendEmailException('Failed To Send Email.', 502);
        }

        return response()->json(['message' => 'Email sent.'], 200);
    }
}
