<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');
Route::get('/quizz', function () {
    return view('quizzes');
})->middleware('auth'); 
Route::get('/quizz/{id}', function ($id) {
    return view('quizz-preview', ['id' => $id]);
})->middleware('auth');
Route::get('/quizz/{id}/play', function ($id) {
    return view('quizz-process', ['id' => $id]);
})->middleware('auth');