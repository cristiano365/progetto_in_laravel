<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * CONTROLLA SE IL RUOLO DELL'UTENTE è INCLUSO IN $roles.
     * $next passa al prossimo middleware
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }
        return redirect('/')
            ->withErrors('Accesso negato: non hai il ruolo necessario.');
    }
}
