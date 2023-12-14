<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', fn() => view('home'));

Route::get('login', [App\Http\Controllers\Authentication::class, 'login_form'])->name('login.form');
Route::post('login', [App\Http\Controllers\Authentication::class, 'login'])->name('login');
Route::post('logout', [App\Http\Controllers\Authentication::class, 'logout'])->name('logout')->middleware('auth');

// Route::get('register', [App\Http\Controllers\RegisterController::class, 'form'])->name('register.form');
// Route::post('register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register');

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth', 'as' => 'dashboard.'], function()
{
    Route::get('', [App\Http\Controllers\Dashboard::class, 'index'])->name('home');

    Route::resource('users', App\Http\Controllers\User::class);

    // * Partners routes
    Route::get('partner', [App\Http\Controllers\PartnerController::class, 'index'])->name('partner.list');
    Route::get('partner/create', [App\Http\Controllers\PartnerController::class, 'createForm'])->name('partner.create');
    Route::get('partner/{id}/show', [App\Http\Controllers\PartnerController::class, 'show'])->name('partner.show');
    Route::post('partner', [App\Http\Controllers\PartnerController::class, 'store'])->name('partner.store');
    Route::put('partner/{id}/update', [App\Http\Controllers\PartnerController::class, 'update'])->name('partner.update');
    // delete....
    // * End partners routes

    Route::get('profile', [App\Http\Controllers\User::class, 'showAuthUserProfile'])->name('user.profile.show');
    Route::put('profile/{user}', [App\Http\Controllers\User::class, 'updateAuthUserProfile'])->name('user.profile.update');
});
