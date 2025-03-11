<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\SendEmailException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users',
            ],
            ['email' => 'البريد الالكتروني غير صحيح']
        );

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Email sent.'], 200);
        }

        throw new SendEmailException('Password reset failed', 502);
    }
}
