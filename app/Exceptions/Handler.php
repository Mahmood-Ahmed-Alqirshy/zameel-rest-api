<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    //Mapping of exception types to their corresponding exception handling methods.
    public static array $handlers = [
        AuthenticationException::class => 'handleAuthenticationException',
        AuthorizationException::class => 'handleAuthorizationException',
        AccessDeniedHttpException::class => 'handleAuthorizationException',
        ValidationException::class => 'handleValidationException',
        ModelNotFoundException::class => 'handleNotFoundException',
        NotFoundHttpException::class => 'handleNotFoundException',
    ];

    public static function handleGenericException(Throwable $exception, Request $request, $uuid)
    {
        return response()->json([
            'error' => [
                'id' => $uuid,
                'status' => 500,
                'title' => 'Internal Server Error',
            ],
        ], 500);
    }

    public static function handleAuthenticationException(Throwable $exception, Request $request, $uuid)
    {
        return response()->json([
            'error' => [
                'id' => $uuid,
                'status' => 401,
                'title' => 'Unauthenticated',
            ],
        ], 401);
    }

    public static function handleAuthorizationException(Throwable $exception, Request $request, $uuid)
    {
        return response()->json([
            'error' => [
                'id' => $uuid,
                'status' => 403,
                'title' => 'Forbidden',
            ],
        ], 403);
    }

    public static function handleValidationException(ValidationException $exception, Request $request, $uuid)
    {
        foreach ($exception->errors() as $key => $value) {
            foreach ($value as $message) {
                $errors[] = [
                    $key => $message,
                ];
            }
        }

        return response()->json([
            'id' => $uuid,
            'status' => 422,
            'title' => 'Unprocessable Entity',
            'errors' => $errors,
        ], 422);
    }

    public static function handleNotFoundException(Throwable $exception, Request $request, $uuid)
    {
        return response()->json([
            'error' => [
                'id' => $uuid,
                'status' => 404,
                'title' => 'Not Found',
            ],
        ], 404);
    }
}
