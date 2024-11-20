<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes(['verify' => true]);

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified']);

Route::get('/profile', [ProfileController::class, 'index'])->middleware(['auth']);
Route::put('/profile/update', [ProfileController::class, 'update'])->middleware(['auth']);

Route::get('/classes', [ClassController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/classes/find/{code}', [ClassController::class, 'findClassByCode'])->middleware(['auth', 'verified']);
Route::get('/classes/{id}/join', [ClassController::class, 'join'])->middleware(['auth', 'verified']);
Route::post('/classes', [ClassController::class, 'store'])->middleware(['auth', 'verified']);
Route::get('/classes/{id}', [ClassController::class, 'show'])->middleware(['auth', 'verified']);
Route::get('/classes/{id}/setting', [ClassController::class, 'setting'])->middleware(['auth', 'verified']);
Route::put('/classes/{id}/update', [ClassController::class, 'update'])->middleware(['auth', 'verified']);
Route::delete('/classes/{id}', [ClassController::class, 'destroy'])->middleware(['auth', 'verified']);
Route::get('/classes/{id}/members', [ClassController::class, 'members'])->middleware(['auth', 'verified']);
Route::get('/classes/{classId}/member/{userId}', [ClassController::class, 'member'])->middleware(['auth', 'verified']);

Route::get('/quizz', function () {
    return view('quizzes');
})->middleware(['auth', 'verified']);
Route::get('/quizz/{id}', function ($id) {
    return view('quizz-preview', ['id' => $id]);
})->middleware(['auth', 'verified']);
Route::get('/quizz/{id}/play', function ($id) {
    return view('quizz-process', ['id' => $id]);
})->middleware(['auth', 'verified']);
Route::get('/saved', function () {
    return view('saved');
})->middleware(['auth', 'verified']);