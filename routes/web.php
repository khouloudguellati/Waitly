<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;


Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);


    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});


Route::post('/logout', [LogoutController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('super-admin')->name('super-admin.')->middleware(['auth', 'super.admin'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/institutions', [App\Http\Controllers\SuperAdmin\InstitutionController::class, 'index'])
        ->name('institutions.index');
    Route::get('/institutions/create', [App\Http\Controllers\SuperAdmin\InstitutionController::class, 'create'])
        ->name('institutions.create');
    Route::post('/institutions', [App\Http\Controllers\SuperAdmin\InstitutionController::class, 'store'])
        ->name('institutions.store');
    Route::get('/institutions/{institution}/edit', [App\Http\Controllers\SuperAdmin\InstitutionController::class, 'edit'])
        ->name('institutions.edit');
    Route::put('/institutions/{institution}', [App\Http\Controllers\SuperAdmin\InstitutionController::class, 'update'])
        ->name('institutions.update');
    Route::delete('/institutions/{institution}', [App\Http\Controllers\SuperAdmin\InstitutionController::class, 'destroy'])
        ->name('institutions.destroy');

    Route::get('/admins', [App\Http\Controllers\SuperAdmin\InstitutionAdminController::class, 'index'])
        ->name('admins.index');
    Route::get('/admins/create', [App\Http\Controllers\SuperAdmin\InstitutionAdminController::class, 'create'])
        ->name('admins.create');
    Route::post('/admins', [App\Http\Controllers\SuperAdmin\InstitutionAdminController::class, 'store'])
        ->name('admins.store');
    Route::get('/admins/{user}/edit', [App\Http\Controllers\SuperAdmin\InstitutionAdminController::class, 'edit'])
        ->name('admins.edit');
    Route::put('/admins/{user}', [App\Http\Controllers\SuperAdmin\InstitutionAdminController::class, 'update'])
        ->name('admins.update');
    Route::delete('/admins/{user}', [App\Http\Controllers\SuperAdmin\InstitutionAdminController::class, 'destroy'])
        ->name('admins.destroy');
});

Route::prefix('institution-admin')->name('institution-admin.')->middleware(['auth', 'institution.admin'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\InstitutionAdmin\DashboardController::class, 'index'])
        ->name('dashboard');


    Route::get('/services', [App\Http\Controllers\InstitutionAdmin\ServiceController::class, 'index'])
        ->name('services.index');
    Route::get('/services/create', [App\Http\Controllers\InstitutionAdmin\ServiceController::class, 'create'])
        ->name('services.create');
    Route::post('/services', [App\Http\Controllers\InstitutionAdmin\ServiceController::class, 'store'])
        ->name('services.store');
    Route::get('/services/{service}/edit', [App\Http\Controllers\InstitutionAdmin\ServiceController::class, 'edit'])
        ->name('services.edit');
    Route::put('/services/{service}', [App\Http\Controllers\InstitutionAdmin\ServiceController::class, 'update'])
        ->name('services.update');
    Route::delete('/services/{service}', [App\Http\Controllers\InstitutionAdmin\ServiceController::class, 'destroy'])
        ->name('services.destroy');


    Route::get('/tickets', [App\Http\Controllers\InstitutionAdmin\TicketController::class, 'index'])
        ->name('tickets.index');
    Route::get('/tickets/service/{service}', [App\Http\Controllers\InstitutionAdmin\TicketController::class, 'byService'])
        ->name('tickets.by-service');
    Route::post('/tickets/{ticket}/call', [App\Http\Controllers\InstitutionAdmin\TicketController::class, 'call'])
        ->name('tickets.call');
    Route::post('/tickets/{ticket}/complete', [App\Http\Controllers\InstitutionAdmin\TicketController::class, 'complete'])
        ->name('tickets.complete');
    Route::post('/tickets/{ticket}/cancel', [App\Http\Controllers\InstitutionAdmin\TicketController::class, 'cancel'])
        ->name('tickets.cancel');
});

Route::prefix('user')->name('user.')->middleware(['auth', 'user'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])
        ->name('dashboard');


    Route::get('/institutions', [App\Http\Controllers\User\InstitutionController::class, 'index'])
        ->name('institutions.index');
    Route::get('/institutions/{institution}', [App\Http\Controllers\User\InstitutionController::class, 'show'])
        ->name('institutions.show');


    Route::get('/tickets/create/{service}', [App\Http\Controllers\User\TicketController::class, 'create'])
        ->name('tickets.create');
    Route::post('/tickets', [App\Http\Controllers\User\TicketController::class, 'store'])
        ->name('tickets.store');
    Route::get('/my-tickets', [App\Http\Controllers\User\TicketController::class, 'myTickets'])
        ->name('tickets.my-tickets');
    Route::get('/tickets/{ticket}', [App\Http\Controllers\User\TicketController::class, 'show'])
        ->name('tickets.show');
});
