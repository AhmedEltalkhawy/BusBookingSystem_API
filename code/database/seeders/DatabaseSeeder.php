<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Station;
use App\Models\Trip;
use App\Models\TripStation;
use App\Models\Bus;
use App\Models\Seat;
use App\Models\Booking;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // Create Stations
       $stations = ["Cairo", "Giza", "Alexandria", "Aswan", "Luxor"];
       $stationIds = [];
       foreach ($stations as $name) {
           $stationIds[] = Station::create(["name" => $name])->id;
       }

       // Create a Trip
       $trip = Trip::create([
           "origin_id" => $stationIds[0], // Cairo
           "destination_id" => $stationIds[2], // Alexandria
       ]);

       // Assign Stations to the Trip (Including Order)
       foreach ($stationIds as $index => $stationId) {
           TripStation::create([
               "trip_id" => $trip->id,
               "station_id" => $stationId,
               "position" => $index + 1,
           ]);
       }

       // Create a Bus
       $bus = Bus::create(["trip_id" => $trip->id, "bus_number" => "BUS-101"]);

       // Create Seats for the Bus
       for ($i = 1; $i <= 12; $i++) {
           Seat::create(["bus_id" => $bus->id, "seat_number" => $i]);
       }

       // Create a Booking (For Testing Seat Availability)
       Booking::create([
           "user_id" => 1,
           "seat_id" => 3, // Seat 3 is booked
           "trip_id" => $trip->id,
           "start_station_id" => $stationIds[0], // Cairo
           "end_station_id" => $stationIds[2], // Alexandria
       ]);
    }
}
