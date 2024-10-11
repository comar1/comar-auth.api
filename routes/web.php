<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordAuth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [PasswordAuth::class, 'test']);
Route::get('/getHash', [PasswordAuth::class, 'getHash']);
Route::post('/getSaltedPassword', [PasswordAuth::class, 'getSaltedPassword']);
Route::post('/getHashedPassword', [PasswordAuth::class, 'getHashedPassword']);
Route::get('/generateUserID', [PasswordAuth::class, 'generateUserID']);
Route::post('/account', [PasswordAuth::class, 'account']);
Route::post('/register', [PasswordAuth::class, 'register']);