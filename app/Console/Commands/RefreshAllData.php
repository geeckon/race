<?php

namespace App\Console\Commands;

use App\Models\DataPoint;
use App\Models\Item;
use App\Models\Player;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Console\Command;

class RefreshAllData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-all-data';

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
        Item::truncate();
        DataPoint::truncate();

        $players = Player::all();
        foreach ($players as $player) {
            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', $player->url);
            $content = json_decode($response->getBody(), true);

            foreach ($content['collectionLog']['tabs'] as $tabName => $tab) {
                foreach ($tab as $bossName => $boss) {
                    foreach ($boss['items'] as $item) {
                        if ($item['obtainedAt'] && !$player->items()->where('item_id', $item['id'])->exists()) {
                            $newItem = new Item();
                            $newItem->player_id = $player->id;
                            $newItem->created_at = Carbon::parse($item['obtainedAt']);
                            $newItem->item_id = $item['id'];
                            $newItem->save();
                        }
                    }
                }
            }

            $raceDate = Carbon::parse('2023-12-12T23:30:00.000Z');

            while ($raceDate < Carbon::now()) {
                $count = $player->items()->whereDate('created_at', '<=', $raceDate)->count();

                $dataPoint = new DataPoint();
                $dataPoint->player_id = $player->id;
                $dataPoint->created_at = $raceDate;
                $dataPoint->count = $count;
                $dataPoint->save();

                $raceDate->addDay();
            }
        }
    }
}
