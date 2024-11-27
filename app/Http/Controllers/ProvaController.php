<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProvaController extends Controller
{
    public function provaFunction() {
        $calcolo = 5 +5 ;
        return $calcolo;
    }

    public function provaData(Request $request) {
        return 'Dati ricevuti: '. $request->input('data');
    }
}
