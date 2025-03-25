<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    //
    use HasFactory;

    protected $fillable = ['origin_id', 'destination_id'];

    public function origin()
    {
        return $this->belongsTo(Station::class, 'origin_id');
    }

    public function destination()
    {
        return $this->belongsTo(Station::class, 'destination_id');
    }

    public function tripStations()
    {
        return $this->hasMany(TripStation::class);
    }

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }

}
