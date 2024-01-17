<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// general routes
Route::prefix('general')->group(function () {
    // views
    Route::view('/page/register', 'auth.Register')->name('/page/register');
    Route::view('/', 'auth.Login')->name('/page/login');

    // emdpoints
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    

});

// auth routes
Route::prefix('auth')->middleware(['auth'])->group(function () {
    // views
    // Route::view('/page/profile', 'user.Profile')->name('/page/profile');
    Route::view('/page/profile/update', 'user.Update')->name('/page/profile/update');
    Route::view('/page/password/update', 'user.Password')->name('/page/password/update');
    Route::view('/dash', 'user.Dashboard')->name('/page/dashboard');
    Route::view('/page/create/contact', 'user.contact/CreateContact')
        ->name('page/create/contact');
    Route::view('/page/edit/contact', 'user.contact.EditContact')
        ->name('page/edit/contact');

    // endpoints
    Route::post('/update_user', [UserController::class, 'update_user'])
        ->name('update_user');
    Route::post('/update_password', [UserController::class, 'update_password'])
        ->name('update_password');
    Route::get('/get_user', [UserController::class, 'get_user'])
        ->name('get_user');
    Route::get('/logout', [UserController::class, 'logout'])
        ->name('logout');
    Route::get('/delete_user', [UserController::class, 'delete_user'])
        ->name('delete_user');
    Route::post('/contact/create', [UserController::class, 'create_contact'])
        ->name('create_contact');
    Route::post('/contact/edit', [UserController::class, 'update_contact'])
        ->name('update_contact');
    Route::get('/contact/{id}', [UserController::class, 'get_contact'])
        ->name('get_contact');
    // Route::post('/contacts', [UserController::class, 'get_contacts'])
    //     ->name('get_contacts');
    Route::match(['get', 'post'], '/contacts', [UserController::class, 'get_contacts'])
        ->name('get_contacts');
    Route::get('/contact/delete/{id}', [UserController::class, 'delete_contact'])
        ->name('delete_contact');

});