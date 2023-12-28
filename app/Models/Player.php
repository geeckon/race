<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    public function dataPoints()
    {
        return $this->hasMany(DataPoint::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
