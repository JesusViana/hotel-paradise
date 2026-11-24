<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            TipoHabitacionSeeder::class,
            HabitacionSeeder::class,
            AdminSeeder::class,
        ]);
    }
}