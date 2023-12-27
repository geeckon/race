<?php

namespace App\Http\Controllers;

use App\Models\DataPoint;
use App\Models\Player;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $players = Player::all();
        $dataPoints = DataPoint::all();
        return view('race', compact('players', 'dataPoints'));
    }
}
