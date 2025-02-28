<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\QueryController;


class UserController extends Controller
{

    public function __construct(
        protected QueryController $queryController
    ) {}

    /*
    * AUTH
    */
    public function showRegistrationForm(){
        return view('register');
    }
    public function showLoginForm(){
        return view('login');
    }
    public function login(Request $request){
        // Validation
        $credentials = $request->validate([
            'email' =>'required|string|email',
            'password' => 'required',
        ]);

        // Attempt to login
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Login eseguito con successo!');
        }

        return back()->withErrors(['email' => 'Email o password non validi.',])->onlyInput('email');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout eseguito con successo!');
    }

    /*
    * CRUD USERS
    */
    public function index(){
        $users = $this->queryController->getAllUsers();
        return view('users.index', compact('users'));
    }
    public function register(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create user
        $userData  = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($request->password),
            'role' => 'cliente',
        ];

        $this->queryController->saveUser($userData);


        // Login user
        $user = User::where('email', $validatedData['email'])->first();
        Auth::login($user);

        return redirect()->route('dashboard')
        ->with('success', 'Registrazione completata! Sei loggato come cliente.');
    
    }





}
