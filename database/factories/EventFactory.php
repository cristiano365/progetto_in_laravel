<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class EventFactory extends Factory
{
    
        private const CATEGORIES = [
            'cultura',
            'turismo',
            'sport',
            'esperienza',
            'convegni'
        ];

        public function definition(): array {
            return [
                'title'       => $this->faker->sentence(),
                'description' => $this->faker->paragraph(),
                'date'        => $this->faker->dateTimeBetween('+1 week', '+3 months'),
                'location'    => $this->faker->city(),
                'category'    => $this->faker->randomElement(self::CATEGORIES),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        } 
    
}
