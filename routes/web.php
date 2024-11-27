<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvaController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AddCustomHeader;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
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

Route::get('/', function () {
    return view('home');
})->name('home')->middleware(AddCustomHeader::class . ':abbiamoquasifinito');


Route::post('/form', [ValidationController::class, 'ValidateForm'])->name('validateForm');



//CRUD operations
Route::get('/prova', [ProvaController::class, 'provaFunction']);
Route::post('/prova', [ProvaController::class, 'provaData']);






Route::get('/about', function () {
    return view('about');
})->middleware('auth');


Route::get('/post/{id}', function ($id) {
    $post = Post::findOrFail($id);
    return view('posts.show', ['post' => $post]);
})->where('id', '[0-9]+')->name('post.show');

Route::put('/post/{id}', function (Request $request, $id) {
    $post = Post::findOrFail($id);

    $post -> title = $request->input('title');
    $post -> content = $request->input('content');
    $post -> save();

    return redirect()->route('post.show', ['id' => $post->id])->with('success', 'Post modificato con successo');
})->name('post.update');

Route::delete('/post/{id}', function ($id) {
    $post = Post::findOrFail($id);

    $post -> delete();

    return redirect()->route('post.index')->with('success', 'Post eliminato con successo');
})->name('post.delete');






Route::get('/posts', function () {

    // $posts = Post::all();

    // return view('posts.index', ['posts' => $posts]);

    $user = User::factory()->count(10)->unverified()->create();
    return $user;
})-> name('posts.index');

Route::get('/posts/create', function () {

    $post = Post::create([
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return view('posts.create', ['post' => $post] );
})->name('posts.create');


Route::get('/posts/delete/{id}', function ($id) {
    $post = Post::find($id);

    if ($post) {
        $post -> delete();
        $message = "il post con ID $id è stato cancellato con successo";
    } else {
        $message = "il post con ID $id non è stato trovato";
    }

    return view('posts.delete', ['message' => $message]);
})->name('posts.delete');













// Route::post('/prova', function () {
//     return "form inviato con successo";
// });

// Route::put('/prova', function () {
//     return "elemento modificato con successo";
// });

// Route::patch('/prova', function () {
//     return "elemento parzialmente modificato con successo";
// });

// Route::delete('/prova', function () {
//     return "elemento cancellato con successo";
// });

// Route::match(['get', 'post'],'/prova', function () {
//     return "route sia get che post";
// });

// Route::any('/prova', function () {
//     return "route qualsiasi metodo";
// });


// //Route con parametri; rotte da poter raggiungere solo se si è admin
// Route:: prefix('admin')->group(function () {
//     Route::get('/users', function () {
//         return "gstione utenti";
//     });

//     Route::get('/prova', function () {
//         return "impostazioni di amministrazione";
//     });
// });

// //Route nominate
// Route::get('/profile', [ProfileController::class, 'show'])->name('profile');













Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




//----------------------------------------------------------------

//Route per la registrazione
Route::post('/register', [UserController::class, 'register'])->name('registerUser');
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('showRegisterForm');

//Route per la login
Route::post('/login', [UserController::class, 'login'])->name('loginUser');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');

//Route per il logout
Route::post('/logout', [UserController::class, 'logout'])->name('logoutUser');


/* gruppo di rotte con uno o più middleware, addirittura posso escluderne uno per una rotta specifica
Route::middleware([EnsureTokenIsValid::class, 1 , 2, 3, ....])->group(function () {
    Route::get('/', function () {
        return "pagina protetta";
    });

    Route::get('/profile', function () {
        return "";
    })->withoutMiddleware(EnsureTokenIsValid::class);


*/