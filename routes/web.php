<?php

use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ChirpHeartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class, 'index']);

Route::middleware('auth')->group(function() {
	Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']);
	Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
	Route::post('/chirps', [ChirpController::class, 'store']);
	Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);
	// Heart / unheart chirps
	Route::post('/chirps/{chirp}/heart', [ChirpHeartController::class, 'store']);
	Route::delete('/chirps/{chirp}/heart', [ChirpHeartController::class, 'destroy']);
});

//REGISTER ROUTES
Route::view('/register', 'auth.register')
	->middleware('guest')
	->name('register');

Route::post('/register', Register::class)
	->middleware('guest');

//LOGOUT
Route::post('/logout', Logout::class)
	->middleware('auth')
	->name('logout');

//LOGIN
Route::view('/login', 'auth.login')
	->middleware('guest')
	->name('login');

Route::post('login', Login::class)
	->middleware('guest');

//USER PROFILE
Route::get('/user', [ChirpController::class, 'show'])
	->middleware('auth')
	->name('user');
