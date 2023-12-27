<?php

namespace App\Console\Commands;

use App\Models\DataPoint;
use App\Models\Player;
use Illuminate\Console\Command;

class GetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $players = Player::all();
        foreach ($players as $player) {
            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', $player->url);
            $content = json_decode($response->getBody(), true);

            $count = $content['collectionLog']['uniqueObtained'];

            $dataPoint = new DataPoint();
            $dataPoint->player_id = $player->id;
            $dataPoint->count = $count;
            $dataPoint->save();
        }
    }
}
