<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripStation extends Model
{
    //
    use HasFactory;

    protected $fillable = ['trip_id', 'station_id', 'position'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

}
