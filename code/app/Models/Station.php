<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name'];

    public function trips()
    {
        return $this->hasMany(Trip::class, 'origin_id')
                    ->orWhere('destination_id', $this->id);
    }

    public function tripStations()
    {
        return $this->hasMany(TripStation::class);
    }
}
