<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizzController;
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

// classes group
Route::group(['prefix' => 'classes'], function () {
    Route::get('/', [ClassController::class, 'index']);
    Route::post('/', [ClassController::class, 'store']);
    Route::get('/{id}', [ClassController::class, 'show']);
    Route::delete('/{id}', [ClassController::class, 'destroy']);
    Route::get('/{id}/join', [ClassController::class, 'join']);
    Route::get('/find/{code}', [ClassController::class, 'findClassByCode']);
    Route::put('/{id}/update', [ClassController::class, 'update']);
    Route::get('/{id}/setting', [ClassController::class, 'setting']);
    Route::get('/{id}/members', [ClassController::class, 'members']);
    Route::get('/{classId}/member/{userId}', [ClassController::class, 'member']);
})->middleware(['auth', 'verified']);

// categories group
Route::group(['prefix' => 'category'], function () {
    Route::get('/all', [CategoryController::class, 'getAll']);
})->middleware(['auth', 'verified']);

// quizz group
Route::group(['prefix' => 'quizz'], function () {
    Route::post('/create', [QuizzController::class, 'create']);
})->middleware(['auth', 'verified']);


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