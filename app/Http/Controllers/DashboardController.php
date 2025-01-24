<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class DashboardController extends Controller
{
    /**
     * Indicizza in base al ruolo dell'utente.
     */
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'gestore':
                return redirect()->route('gestore.dashboard');
            case 'cliente':
                return redirect()->route('cliente.dashboard');
            default:
                // Ruolo non previsto
                abort(403, 'Ruolo non riconosciuto.');
        }
    }

    /**
     * Dashboard Admin
     * L'admin può vedere TUTTI gli eventi, e potrà crearli/assegnarli a un gestore
     * 
     * il compact events passa alla view l'array di events
     */
    public function adminDashboard()
    {
        // Carichiamo tutti gli eventi
        $events = Event::with('user')->orderBy('date')->get();
        return view('dashboard.admin', compact('events'));
    }

    /**
     * Dashboard Gestore
     * Il gestore vede TUTTI gli eventi, ma può modificare solo i suoi
     */
    public function gestoreDashboard()
    {
        // Carichiamo tutti gli eventi
        $events = Event::with('user')->orderBy('date')->get();
        return view('dashboard.gestore', compact('events'));
    }

    /**
     * Dashboard Cliente
     * Il cliente vede TUTTI gli eventi (non può crearli, modificarli, ecc.)
     */
    public function clienteDashboard()
    {
        $events = Event::with('user')->orderBy('date')->get();
        return view('dashboard.cliente', compact('events'));
    }
}

