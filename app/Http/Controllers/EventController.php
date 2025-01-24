<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Lista di tutti gli eventi (potrebbe essere usata da admin o gestore)
    public function index()
    {
        $events = Event::with('user')->orderBy('date')->get();
        return view('events.index', compact('events'));
    }

    // Mostra un singolo evento
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }


    //Per creazione, modifica ed eliminazione l'admin può fare tutto ma il gestore può gestire solo i propri eventi
    // Form di creazione
    public function create()
    {
        // Se l'utente è admin, dobbiamo permettergli di scegliere a quale gestore assegnare l'evento
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Carichiamo solo i gestori
            $gestori = User::where('role', 'gestore')->get();
            return view('events.create-admin', compact('gestori'));
        } elseif ($user->role === 'gestore') {
            return view('events.create-gestore');
        } 
        // Se è cliente, non può creare
        abort(403, 'Non sei autorizzato a creare eventi.');
    }

    // Salvataggio dell'evento
    public function store(Request $request)
    {
        $user = Auth::user();

        // Valida i dati
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'gestore_id'  => 'nullable|exists:users,id' // Questo campo serve solo se admin
        ]);

        if ($user->role === 'admin') {
            // L'admin assegna l'evento al gestore selezionato
            $data['user_id'] = $data['gestore_id'];
            unset($data['gestore_id']);
        } elseif ($user->role === 'gestore') {
            // Il gestore assegna l'evento a sé stesso
            $data['user_id'] = $user->id;
        } else {
            abort(403, 'Non sei autorizzato a creare eventi.');
        }

        Event::create($data);

        return redirect()->route($user->role.'.dashboard')->with('success', 'Evento creato con successo');
    }

    // Form di modifica (solo admin o il gestore che l'ha creato)
    public function edit(Event $event)
    {
        $user = Auth::user();

        // Se admin, può modificare qualsiasi evento
        // Se gestore, può modificare solo i propri
        if ($user->role === 'admin') {
            $gestori = User::where('role', 'gestore')->get();
            return view('events.edit-admin', compact('event', 'gestori'));
        } elseif ($user->role === 'gestore' && $event->user_id == $user->id) {
            return view('events.edit-gestore', compact('event'));
        } else {
            abort(403, 'Non sei autorizzato a modificare questo evento.');
        }
    }

    // Aggiorna l'evento
    public function update(Request $request, Event $event)
    {
        $user = Auth::user();

        // Valida i dati
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'gestore_id'  => 'nullable|exists:users,id'
        ]);

        // Controllo ruoli
        if ($user->role === 'admin') {
            // L'admin può riassegnare l'evento
            if (isset($data['gestore_id'])) {
                $data['user_id'] = $data['gestore_id'];
                unset($data['gestore_id']);
            }
        } elseif ($user->role === 'gestore') {
            // Il gestore può aggiornare solo i propri eventi
            if ($event->user_id != $user->id) {
                abort(403, 'Non autorizzato a modificare questo evento.');
            }
        } else {
            abort(403, 'Non sei autorizzato a modificare eventi.');
        }

        $event->update($data);

        return redirect()->route($user->role.'.dashboard')->with('success', 'Evento aggiornato con successo');
    }

    // Cancellazione di un evento
    public function destroy(Event $event)
    {
        $user = Auth::user();

        // admin cancella tutto, gestore solo i propri
        if ($user->role === 'admin' || ($user->role === 'gestore' && $event->user_id == $user->id)) {
            $event->delete();
            return redirect()->route($user->role.'.dashboard')->with('success', 'Evento eliminato con successo');
        }

        abort(403, 'Non sei autorizzato a eliminare questo evento.');
    }
}
