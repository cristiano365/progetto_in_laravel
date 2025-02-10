<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QueryController;


class EventController extends Controller
{
    public function __construct(
        protected QueryController $queryController
    ) {}

    /*
    * CRUD EVENTS
    */
    public function index(Request $request)
    {
        $cat = $request->query('category');
        if ($cat) {
            $events = $this->queryController->getEventsByCategory($cat);
        } else {
            $events = $this->queryController->getAllEvents();
        }
        return view('events.index', compact('events'));
    }
    public function show($id)
    {
        $event = $this->queryController->getEventById($id);
        if($event->isEmpty()){
            abort(404, 'Evento non trovato!');
        }
        return view('events.show', ['event' => $event[0]]);
    }
    public function create()
    {
        $user = Auth::user();
        $editMode = false;
        $event = null;

        if ($user->role === 'admin') {
            $gestori = $this->queryController->getGestori();
            return view('events.form', [
                'event'     => $event,
                'gestori'   => $gestori,
                'editMode'  => $editMode,
            ]);
        } elseif ($user->role === 'gestore') {
            return view('events.form', [
                'event'     => $event,
                'gestori'   => null,
                'editMode'  => $editMode,
            ]);
        }

        abort(403, 'Non sei autorizzato a creare eventi.');
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'gestore_id' => 'nullable|exists:users,id',
            'category'    => 'nullable|string|in:cultura,turismo,sport,esperienza,convegni'

        ]);

        if ($user->role === 'admin') {
            $data['user_id'] = $data['gestore_id'];
        } elseif ($user->role === 'gestore') {
            $data['user_id'] = $user->id;
        } else {
            abort(403, 'Non sei autorizzato a creare eventi.');
        }

        unset($data['gestore_id']);
        $this->queryController->saveEvent($data);       //per creare
        return redirect()->route($user->role.'.dashboard')
            ->with('success', 'Evento creato con successo');
    }
    public function edit(Event $event)
    {
        $user = Auth::user();
        $editMode = true;

        if ($user->role === 'admin') {
            $gestori = $this->queryController->getGestori();
            return view('events.form', [
                'event'    => $event,
                'gestori'  => $gestori,
                'editMode' => $editMode,
            ]);
        } elseif ($user->role === 'gestore' && $event->user_id == $user->id) {
            return view('events.form', [
                'event'    => $event,
                'gestori'  => null,
                'editMode' => $editMode,
            ]);
        }
        
        abort(403, 'Non sei autorizzato a modificare questo evento.');
    }
    public function update(Request $request, Event $event)
    {
        $user = Auth::user();
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'gestore_id' => 'nullable|exists:users,id',
            'category'    => 'nullable|string|in:cultura,turismo,sport,esperienza,convegni'

        ]);

        if ($user->role === 'admin') {
            $data['user_id'] = $data['gestore_id'] ?? $event->user_id;
            unset($data['gestore_id']);
        }
        elseif ($user->role === 'gestore'){
            if ($event->user_id != $user->id) {
                abort(403, 'Non autorizzato a modificare questo evento.');
            }
            $data['user_id'] = $event->user_id;
        }
                

        $this->queryController->saveEvent($data, $event->id);       //per aggiornare
        return redirect()->route($user->role.'.dashboard')
            ->with('success', 'Evento aggiornato con successo');
    }
    public function destroy(Event $event)
    {
        $user = Auth::user();
        if ($user->role === 'admin' || 
            ($user->role === 'gestore' && $event->user_id == $user->id)) {
            $this->queryController->deleteEvent($event->id);
            return redirect()->route($user->role.'.dashboard')
                ->with('success', 'Evento eliminato con successo');
        }
        abort(403, 'Non sei autorizzato a eliminare questo evento.');
    }
}


/*
LOGICA DI UPDATE
Caso A: L’evento è attualmente di “Gestore Mario” (user_id=7). L’admin apre la pagina di edit. Nel form, c’è un select gestori.

Se l’admin sceglie “Gestore Luigi” (id=9), allora gestore_id=9 e $data['user_id'] = 9. L’evento passa a Luigi.
Se non sceglie nulla (gestore_id = null), $data['user_id'] = $event->user_id = 7, resta a Mario.

*/