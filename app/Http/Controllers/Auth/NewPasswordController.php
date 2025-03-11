<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\SendEmailException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Inertia\Response;

class NewPasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate(
            [
                'token' => 'required',
                'email' => 'required|email|exists:users',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ],
            [
                'email' => 'البريد الإلكتروني غير صحيح',
                'password' => 'كلمة المرور يجب ان تتكون من 8 حروف وتحتوي على حرف كبير وحرف صغير ورقم ورمز على الاقل',
            ]
        );

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            User::where('email', $request->email)->first()->tokens()->delete();

            return response()->json(['message' => 'Password reset.'], 200);
        }

        throw new SendEmailException('Password reset failed', 502);
    }
}
