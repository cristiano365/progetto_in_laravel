<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Gestisce la verifica dei ruoli: es. ->middleware('role:admin')
     * o ->middleware('role:admin,gestore').
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        
        // Se il ruolo dell'utente è in quelli ammessi, OK
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Altrimenti, accesso negato
        return redirect('/')
            ->withErrors('Accesso negato: non hai il ruolo necessario.');
    }
}
