<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public access routes - can be accessed by anyone
Route::get('questions', [QuestionController::class, 'index']);
Route::get('questions/{id}', [QuestionController::class, 'show']);
Route::get('answers', [AnswerController::class, 'index']);
Route::get('answers/{id}', [AnswerController::class, 'show']);
Route::get('likes', [LikeController::class, 'index']);
Route::get('topics', [TopicController::class, 'index']);
Route::get('topics/{id}', [TopicController::class, 'show']);

// Routes that require authentication - for POST, PUT, DELETE
Route::middleware(['jwt.auth'])->group(function () {
    Route::post('questions', [QuestionController::class, 'store']);
    Route::put('questions/{id}', [QuestionController::class, 'update']);
    Route::delete('questions/{id}', [QuestionController::class, 'destroy']);

    Route::post('answers', [AnswerController::class, 'store']);
    Route::put('answers/{id}', [AnswerController::class, 'update']);
    Route::delete('answers/{id}', [AnswerController::class, 'destroy']);

    Route::post('likes', [LikeController::class, 'store']);
    Route::delete('likes/{id}', [LikeController::class, 'destroy']);

    Route::post('topics', [TopicController::class, 'store']);
    Route::put('topics/{id}', [TopicController::class, 'update']);
    Route::delete('topics/{id}', [TopicController::class, 'destroy']);

    Route::middleware('jwt.auth')->get('/me', [AuthController::class, 'getAuthenticatedUser']);
});

// Routes to view user profile - public access
Route::get('users/{id}', [UserController::class, 'show']);

