<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Player;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $players = [
            [
                'name' => 'Geks',
                'url' => 'https://api.collectionlog.net/collectionlog/user/Geks',
            ],
            [
                'name' => 'Lv Camo',
                'url' => 'https://api.collectionlog.net/collectionlog/user/Lv%20Camo',
            ],
            [
                'name' => 'Gembird',
                'url' => 'https://api.collectionlog.net/collectionlog/user/Gembird',
            ]
        ];

        foreach ($players as $player) {
            $newPlayer = new Player();
            $newPlayer->name = $player['name'];
            $newPlayer->url = $player['url'];
            $newPlayer->save();
        }
    }
}
