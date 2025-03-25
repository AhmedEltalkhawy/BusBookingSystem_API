use App\Http\Controllers\BookingController;

Route::post('/book-seat', [BookingController::class, 'bookSeat']);
Route::get('/available-seats', [BookingController::class, 'getAvailableSeats']);
