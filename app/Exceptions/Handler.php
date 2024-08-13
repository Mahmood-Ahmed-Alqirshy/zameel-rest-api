<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    //Mapping of exception types to their corresponding exception handling methods.
    public static array $handlers = [
        AuthenticationException::class => 'handleAuthenticationException',
        AuthorizationException::class => 'handleAuthorizationException',
        ValidationException::class => 'handleValidationException',
        ModelNotFoundException::class => 'handleModelNotFoundException',
        NotFoundHttpException::class => 'handleModelNotFoundException',
        MethodNotAllowedHttpException::class => 'handleMethodNotAllowedException',
        HttpException::class => 'handleHttpException',
        QueryException::class => 'handleQueryException',
        UniqueConstraintViolationException::class => 'handleUniqueConstraintViolationException',
    ];

    public static function handleGenericException(Throwable $exception, Request $request)
    {
        $status = $exception->getCode() ?: 500;
        //Ensures the HTTP status code is within the valid range of 100-599.
        if ($status < 100 || $status >= 600) {
            $status = 500;
        }

        return response()->json([
            'error' => [
                'type' => basename(get_class($exception)),
                'status' => $status,
                'message' => $exception->getMessage() ?: 'Internal Server Error'
            ]
        ], $status);
    }

    public static function handleAuthenticationException(AuthenticationException $exception, Request  $request)
    {
        return response()->json([
            'error' => [
                'type' => basename(get_class($exception)),
                'status' => 403,
                'message' => $exception->getMessage()
            ]
        ], 403);
    }

    public static function handleAuthorizationException(AuthenticationException $exception, Request  $request)
    {
        return response()->json([
            'error' => [
                'type' => basename(get_class($exception)),
                'status' => 401,
                'message' => $exception->getMessage()
            ]
        ], 401);
    }

    public static function handleValidationException(ValidationException $exception, Request  $request)
    {
        foreach ($exception->errors() as $key => $value) {
            foreach ($value as $message) {
                $errors[] = [
                    'type' => basename(get_class($exception)),
                    'status' => 422,
                    'message' => $message,
                ];
            }
        }

        return response()->json(['errors' => $errors], 422);
    }

    public static function handleModelNotFoundException(ModelNotFoundException|NotFoundHttpException $exception, Request $request)
    {
        return response()->json([
            'error' => [
                'type' => basename(get_class($exception)),
                'status' => 404,
                'message' => 'Not Found: ' . $request->getRequestUri()
            ]
        ], 404);
    }

    public static function handleMethodNotAllowed(MethodNotAllowedHttpException $exception, Request $request)
    {
        return response()->json([
            'error' => [
                'type' => basename(get_class($exception)),
                'status' => 405,
                'message' => 'Method Not Allowed'
            ]
        ], 405);
    }

    public static function handleHttpException(HttpException $exception, Request $request)
    {
        return response()->json([
            'error' => [
                'type' => basename(get_class($exception)),
                'status' => $exception->getStatusCode(),
                'message' => $exception->getMessage() ?: 'HTTP Error'
            ]
        ], $exception->getStatusCode());
    }

    public static function handleQueryException(QueryException $exception, Request $request)
    {
        return response()->json([
            'error' => [
                'type' => basename(get_class($exception)),
                'status' => 500,
                'message' => 'Database Query Error'
            ]
        ], 500);
    }

    public static function handleUniqueConstraintViolationException(UniqueConstraintViolationException $exception, Request $request)
    {
        return response()->json([
            'error' => [
                'type' => basename(get_class($exception)),
                'status' => 500,
                'message' => 'Email address already exists. Please try another one.'
            ]
        ], 500);
    }
}
