<?php

// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\ProvaController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
// use App\Http\Middleware\AddCustomHeader;
use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

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


// Rotta home pubblica
Route::get('/', function () {
    return view('welcome'); 
})->name('home');

//Form di registrazione
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('registerUser');

//Form di autenticazione
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('loginUser');

// Rotta per il logout (richiede l'utente loggato)
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth')
    ->name('logoutUser');


//Insieme di rotte che funzionano con l'utente loggato
Route::middleware(['auth'])->group(function () {

//Rotte di indicizzazione in base al ruolo
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])
        ->middleware('role:admin')
        ->name('admin.dashboard');
    Route::get('/dashboard/gestore', [DashboardController::class, 'gestoreDashboard'])
        ->middleware('role:gestore')
        ->name('gestore.dashboard');
    Route::get('/dashboard/cliente', [DashboardController::class, 'clienteDashboard'])
        ->middleware('role:cliente')
        ->name('cliente.dashboard');


//Rotta accessibili a TUTTI gli utenti autenticati per visualizzare gli eventi
    Route::get('/events', [EventController::class, 'index'])
    ->name('events.index');

// Rotte accessibili solo ad admin o gestore
    Route::middleware('role:admin,gestore')->group(function () {

        // Crea evento (mostra form)
        Route::get('/events/create', [EventController::class, 'create'])
            ->name('events.create');

        // Salva evento (submit form)
        Route::post('/events', [EventController::class, 'store'])
            ->name('events.store');

        // Modifica evento (mostra form)
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])
            ->name('events.edit');

        // Aggiorna evento (submit form edit)
        Route::put('/events/{event}', [EventController::class, 'update'])
            ->name('events.update');

        // Elimina evento
        Route::delete('/events/{event}', [EventController::class, 'destroy'])
            ->name('events.destroy');
    });

//Rotta accessibile a tutti per visualizare l'evento nel dettaglio
    Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show');






    // //tutti gli utenti autenticati possono vedere lista eventi e dettaglio eventi
    // Route::resource('events', EventController::class)   
    //     ->only(['index', 'show']);

        
    // //solo gestore e admin possono anche creare, modificare, eliminare
    // Route::middleware('role:admin,gestore')->group(function () {
    //     Route::resource('events', EventController::class)
    //         ->only(['create','store','edit','update','destroy']);
    // });
});

/*
*
*IMPORTANTE*
Quando si usa Rouute::resource, Laravel si aspetta dei nomi spcifici per le funzioni nel controller. Se cambi nomi, va in errore.
I nomi standard/specifici sono:
    - index (lista);
    - create (form craezione);
    - store (salvataggio);
    - show (dettaglio);
    - edit (form modifica);
    - update (aggiornamento);
    - destroy (eliminazione);

// Nome Rotta        Metodo HTTP   URL                   Funzione Controller    Vista Tipica
'events.index'    -> GET          /events              index()              -> events/index.blade.php
'events.create'   -> GET          /events/create       create()            -> events/create.blade.php
'events.store'    -> POST         /events              store()             -> (nessuna vista, solo processo)
'events.show'     -> GET          /events/{id}         show()              -> events/show.blade.php
'events.edit'     -> GET          /events/{id}/edit    edit()             -> events/edit.blade.php
'events.update'   -> PUT/PATCH    /events/{id}         update()            -> (nessuna vista, solo processo)
'events.destroy'  -> DELETE       /events/{id}         destroy()           -> (nessuna vista, solo processo)

*/
