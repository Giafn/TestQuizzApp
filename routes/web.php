<?php

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
Route::get('/quizz', function () {
    return view('quizzes');
})->middleware(['auth', 'verified']);
Route::get('/quizz/{id}', function ($id) {
    return view('quizz-preview', ['id' => $id]);
})->middleware(['auth', 'verified']);
Route::get('/quizz/{id}/play', function ($id) {
    return view('quizz-process', ['id' => $id]);
})->middleware(['auth', 'verified']);
Route::get('/classes', function () {
    return view('classes');
})->middleware(['auth', 'verified']);
Route::get('/classes/{id}', function ($id) {
    return view('class-preview', ['id' => $id]);
})->middleware(['auth', 'verified']);
Route::get('/saved', function () {
    return view('saved');
})->middleware(['auth', 'verified']);