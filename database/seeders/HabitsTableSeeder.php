<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habit;

class HabitsTableSeeder extends Seeder
{
    public function run()
    {
        Habit::create([
            'name' => 'Water drinken',
            'description' => 'Minimaal 8 glazen per dag drinken.'
        ]);

        Habit::create([
            'name' => '10.000 stappen zetten',
            'description' => 'Dagelijks bewegen is gezond.'
        ]);

        Habit::create([
            'name' => 'Lezen',
            'description' => 'Minimaal 15 minuten lezen per dag.'
        ]);
    }
}
