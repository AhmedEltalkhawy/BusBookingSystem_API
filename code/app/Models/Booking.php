<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    use HasFactory;

    protected $fillable = ['user_id', 'seat_id', 'start_station_id', 'end_station_id', 'booking_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function startStation()
    {
        return $this->belongsTo(Station::class, 'start_station_id');
    }

    public function endStation()
    {
        return $this->belongsTo(Station::class, 'end_station_id');
    }

}
