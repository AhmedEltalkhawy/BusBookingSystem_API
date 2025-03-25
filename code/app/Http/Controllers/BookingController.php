<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\Trip;
use App\Models\Booking;
use App\Models\TripStation;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    public function getAvailableSeats(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'start_station_id' => 'required|exists:stations,id',
            'end_station_id' => 'required|exists:stations,id'
        ]);

        $tripId = $request->trip_id;
        $startStationId = $request->start_station_id;
        $endStationId = $request->end_station_id;

        // Get ordered positions of start and end stations in the trip
        $startPosition = TripStation::where('trip_id', $tripId)
                            ->where('station_id', $startStationId)
                            ->value('position');

        $endPosition = TripStation::where('trip_id', $tripId)
                            ->where('station_id', $endStationId)
                            ->value('position');

        if (!$startPosition || !$endPosition || $startPosition >= $endPosition) {
            return response()->json(['error' => 'Invalid trip route.'], 400);
        }

        // Get all available seats for buses on the trip
        $availableSeats = Seat::whereHas('bus', function ($query) use ($tripId) {
            $query->where('trip_id', $tripId);
        })
        ->whereDoesntHave('bookings', function ($query) use ($startPosition, $endPosition) {
            $query->whereBetween('start_station_id', [$startPosition, $endPosition])
                  ->orWhereBetween('end_station_id', [$startPosition, $endPosition]);
        })
        ->get();

        return response()->json(['available_seats' => $availableSeats]);
    }

    public function bookSeat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'seat_id' => 'required|exists:seats,id',
            'start_station_id' => 'required|exists:stations,id',
            'end_station_id' => 'required|exists:stations,id'
        ]);

        $seat = Seat::findOrFail($request->seat_id);

        // Check if the seat is already booked for the requested trip segment
        $conflict = Booking::where('seat_id', $seat->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_station_id', [$request->start_station_id, $request->end_station_id])
                      ->orWhereBetween('end_station_id', [$request->start_station_id, $request->end_station_id]);
            })
            ->exists();

        if ($conflict) {
            return response()->json(['error' => 'Seat is already booked for this trip segment.'], 400);
        }

        // Book the seat
        $booking = Booking::create([
            'user_id' => $request->user_id,
            'seat_id' => $request->seat_id,
            'start_station_id' => $request->start_station_id,
            'end_station_id' => $request->end_station_id
        ]);

        return response()->json(['message' => 'Seat booked successfully!', 'booking' => $booking]);
    }
}
