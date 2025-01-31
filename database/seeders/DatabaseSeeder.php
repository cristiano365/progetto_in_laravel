<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // - 2 admin
        $admins = User::factory()
            ->admin()
            ->count(2)
            ->create();

        // - 2 gestori
        $gestori = User::factory()
            ->gestore()
            ->count(2)
            ->create();

        // - 5 clienti
        $clienti = User::factory()
            ->cliente()
            ->count(5)
            ->create();


        // Uniamo admin e gestori in una singola collezione
        $possibleEventOwners = $admins->merge($gestori);

        // 3) Creiamo 15 eventi
        Event::factory()->count(15)->create([
            'user_id' => function() use ($possibleEventOwners) {
                return $possibleEventOwners->random()->id;
            },
        ]);
    }
}
