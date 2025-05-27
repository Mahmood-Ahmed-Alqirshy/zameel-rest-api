<?php

use App\Http\Controllers\ApplyController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssistantChatController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\TeachingController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('verified')->group(function () {

        Route::post('/users/{user}/roles/{role}', PromotionController::class);

        Route::post('/users/update-password', UpdatePasswordController::class);

        Orion::resource('users', UserController::class)->except(UserController::EXCLUDE_METHODS)->withoutBatch();

        Route::get('/users/me', function () {
            return response()->json(Auth::user());
        });

        Route::get('/posts/deleted', [PostController::class, 'deleted']);
        Orion::resource('posts', PostController::class)->except(PostController::EXCLUDE_METHODS)->withoutBatch();

        Orion::resource('colleges', CollegeController::class)->withSoftDeletes()->withoutBatch();

        Orion::resource('majors', MajorController::class)->withSoftDeletes()->withoutBatch();

        Orion::resource('subjects', SubjectController::class)->withSoftDeletes()->withoutBatch();

        Orion::resource('groups', GroupController::class)->except(GroupController::EXCLUDE_METHODS);

        Orion::resource('members', MemberController::class)->except(MemberController::EXCLUDE_METHODS)->withoutBatch();

        Orion::resource('applies', ApplyController::class)->except(ApplyController::EXCLUDE_METHODS)->withoutBatch();

        Orion::resource('teaching', TeachingController::class)->except(TeachingController::EXCLUDE_METHODS);

        Route::get('/books/deleted', [BookController::class, 'deleted']);
        Route::get('/books/{book}/summary', SummaryController::class);
        Route::get('/books/{book}/quiz', QuizController::class);
        Orion::resource('books', BookController::class)->withoutBatch();

        Route::get('/assignments/deleted', [AssignmentController::class, 'deleted']);
        Orion::resource('assignments', AssignmentController::class)->withoutBatch();

        Orion::resource('deliveries', DeliveryController::class)->except(DeliveryController::EXCLUDE_METHODS)->withoutBatch();

        Route::post('/chat/create', [AssistantChatController::class, 'store']);

        Route::post('/chat/{chat}', [AssistantChatController::class, 'update']);
    });

    Route::post('verify-email', VerifyEmailController::class)
        ->name('verification.verify');

    Route::post('email/verification-notification', EmailVerificationNotificationController::class)
        ->middleware(['throttle:1,1'])
        ->name('verification.send');
});

Route::post('forgot-password', PasswordResetLinkController::class)
    ->middleware(['throttle:1,1'])
    ->name('password.email');

Route::post('reset-password', NewPasswordController::class)
    ->name('password.store');
