<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

/**
 * WELCOME
 */
Route::get('/', function () {return view('welcome');})->name('home');


/**
 * SIGN-IN, SIGN-UP, SIGN-OUT(puoi farlo solo se autenticato)
 */
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('registerUser');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('loginUser');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logoutUser');


Route::middleware(['auth'])->group(function () {
    /**
     * INDICIZZA IN BASE AL RUOLO
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->middleware('role:admin')->name('admin.dashboard');
    Route::get('/dashboard/gestore', [DashboardController::class, 'gestoreDashboard'])->middleware('role:gestore')->name('gestore.dashboard');
    Route::get('/dashboard/cliente', [DashboardController::class, 'clienteDashboard'])->middleware('role:cliente')->name('cliente.dashboard');

    /*
    * CRUD EVENTI ACCESSIBILE SOLO A GESTORE E ADMIN
    */
    Route::middleware('role:admin,gestore')->group(function () {

        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });

    Route::get('/users', [UserController::class, 'index'])->middleware('role:admin')->name('users.index');

    /**
     * ROTTE ACCESSIBILI A TUTTI I RUOLI DI UTENZA PER VISUALIZZARE GLI EVENTI E L'EVENTO NEL DETTAGLIO
     */
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
});
