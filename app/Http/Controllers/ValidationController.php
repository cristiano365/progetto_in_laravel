<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function validateForm(Request $request) {
        // Validazione del form
        $validatedData =  $request->validate([
            'name' =>'required|string|max:255',
            'email' =>'required|email|max:255',
            'age' =>'required|integer|min:18|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Se la validazione è andata a buon fine, salva i dati nel database
        //...

        return redirect()->route('home')->with('success', 'Dati salvati con successo!');
    }
}
