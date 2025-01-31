<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QueryController;


class DashboardController extends Controller
{

    public function __construct(protected QueryController $queryController){}
    
    /*
    * INDEX TO DASHBOARD 
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
                abort(403, 'Ruolo non riconosciuto.');
        }
    }
    public function adminDashboard()
    {
        $events = $this->queryController->getAllEvents();
        return view('dashboard.admin', compact('events'));
    }
    public function gestoreDashboard()
    {
        $events = $this->queryController->getAllEvents();
        return view('dashboard.gestore', compact('events'));
    }
    public function clienteDashboard()
    {
        $events = $this->queryController->getAllEvents();
        return view('dashboard.cliente', compact('events'));
    }
}

