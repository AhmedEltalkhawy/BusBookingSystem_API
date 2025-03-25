# Bus Booking System API

## Overview
This project is a Bus Booking System API built using Laravel. 
It allows users to book available seats on a bus and retrieve available seats based on their selected start and end stations.

##  Tech Stack
- **Backend:** Laravel  
- **Database:** MySQL  
- **ORM:** Eloquent  
- **Authentication:** Laravel Sanctum (Optional for user authentication)  
- **API Format:** RESTful JSON API  

##  Features

- **User Seat Booking**
- **Fetch Available Seats for a Trip**

---
##  Database Schema

### **Entities & Relationships**
| **Entity**      | **Relationships** |
|---------------- |------------------|
| **Trip**        | Has many **TripStations**, **Buses** |
| **Station**     | Many-to-Many with **Trips** |
| **Bus**         | Belongs to **Trip**, Has many **Seats** |
| **Seat**        | Belongs to **Bus**, Has many **Bookings** |
| **Booking**     | Belongs to **User**, **Seat** |
| **User**        | Has many **Bookings**|


---




---
##  API Endpoints

###  Get Available Seats
**GET** `/api/available-seats?start_station={id}&end_station={id}`
#### Response:
```json
{
    "trip_id": 1,
    "available_seats": [1, 2, 3, 5, 6]
}
```

### Book a Seat**
**POST** `/api/book-seat`
#### Request Body:
```json
{
    "user_id": 1,
    "seat_id": 5,
    "trip_id": 1,
    "start_station_id": 2,
    "end_station_id": 5
}
```
#### Response:
```json
{
    "message": "Seat booked successfully",
    "booking_id": 12
}
```



