<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class PrioritySeeder extends Seeder
{

    public function run(): void
    {
        // Utilitzem DB::table per inserir les dades directament
        DB::table('priorities')->insert([
            [
                'name' => 'Baixa',
                'color_hex' => '#51FF00', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mitjana',
                'color_hex' => '#FFDD00', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alta',
                'color_hex' => '#FF2B00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
