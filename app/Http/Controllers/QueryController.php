<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    /*
    * EVENTS QUERY
    */
    public function getAllEvents()
    {
        $sql = '
            SELECT events.*, users.name as userName, users.email as userMail
            FROM events
            LEFT JOIN users ON events.user_id = users.id
            ORDER BY events.date ASC
        ';
        $events = DB::select($sql);
        return collect($events);
    }
    public function getEventById($id)
    {
        $sql = '
            SELECT events.*, users.name as userName, users.email as userMail
            FROM events
            LEFT JOIN users ON events.user_id = users.id
            WHERE events.id = ?
        ';
        $event = DB::select($sql, [$id]);
        return collect($event);
    }
    public function getGestori()
    {
        $sql = '
                SELECT * FROM users 
                WHERE role = ?
            '; //prepared statement
        $gestori = DB::select($sql, ['gestore']);
        return collect($gestori);
    }
    public function saveEvent($data, $id = null)
    {
        //per aggiornare
        if ($id) {
            $sql = '
                    UPDATE events 
                    SET title = ?, description = ?, date = ?, location = ?, user_id = ?, updated_at = ?
                    WHERE id = ?
                ';
            $params = [...array_values($data), now(), $id];
            return DB::update($sql, $params);
        }
        //per creare
        $sql = '
                    INSERT INTO events (title, description, date, location, user_id, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ';
                $params = [...array_values($data),now(), now()];
                return DB::insert($sql, $params);
    }
    public function deleteEvent($id)
    {
        $sql = '
                DELETE FROM events 
                WHERE id = ?
            ';
        return DB::delete($sql, [$id]);
    }


    /*
    * USERS QUERY
    */
    public function getAllUsers() {
        $sql = '
                SELECT users.id, users.name, users.email, users.role
                FROM users
                LEFT JOIN events ON users.id = events.user_id 
                GROUP BY users.id, users.name, users.email, users.role
            ';

            $users = DB::select($sql);
            return collect($users);
    }

    public function saveUser($data)
    {
        $sql = '
                INSERT INTO users (
                    name, email, password, role,
                    remember_token, created_at, updated_at
                ) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ';
    
            $params = [...array_values($data),null, now(),now()];
    
            return DB::insert($sql, $params);
    }       
}










/*
 * il ? dice a Laravel:
 * "Tutto quello che metto qui DEVE essere trattato come dato, MAI come comando SQL"
 * // SCENARIO PERICOLOSO:
$titolo = "Festa'; DROP TABLE events; --";  // input malevolo

// Senza ?
$sql = "INSERT INTO events (title) VALUES ('$titolo')";
// Diventa: INSERT INTO events (title) VALUES ('Festa'; DROP TABLE events; --')
// Questo CANCELLEREBBE la tabella events!

// Con ?
$sql = "INSERT INTO events (title) VALUES (?)";
DB::insert($sql, [$titolo]);
// Il ? fa sì che Laravel "pulisca" l'input, quindi:
// - Le virgolette vengono escapate
// - I punti e virgola vengono trattati come testo
// - Il -- viene trattato come testo
// Risultato: viene davvero inserito un evento con titolo "Festa'; DROP TABLE events; --"
 * 
 */