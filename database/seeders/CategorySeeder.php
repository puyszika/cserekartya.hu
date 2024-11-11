<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Category::insert([
            ['name' => 'Kayou'],
            ['name' => 'Bandai'],
            ['name' => 'Naruto'],
            ['name' => 'Dragon Ball'],
            ['name' => 'One Piece'],
            ['name' => 'Yu-gi-oh'],
            ['name' => 'Pokemon'],
            ['name' => 'Demon Slayer'],
            ['name' => 'Attack On Titan'],
            ['name' => 'Bleach'],
            ['name' => 'Egyéb Anime'],
            ['name' => 'Futball'],
            ['name' => 'Baseball'],
            ['name' => 'Kosárlabda'],
            ['name' => 'Jégkorong'],
            ['name' => 'WWE'],
            ['name' => 'Nascar'],
            ['name' => 'UFC'],
            ['name' => 'F1'],
            ['name' => 'Egyéb Sport'],
            ['name' => 'Star Wars'],
            ['name' => 'Marvel'],

        ]);
    }
}
