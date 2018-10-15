<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getBookingsPage()
    {
        return view('bookings');
    }

    public function getAllBookings()
    {
        return Booking::with('user','service')->get();
    }

    public function getUserBookings(User $user)
    {
        return $user->load('bookings.service');
    }

    public function createBooking(Request $request)
    {
        $booking = Booking::create($request->all());
        $booking->ref = bin2hex(openssl_random_pseudo_bytes(4)) . $booking->bookingid . $booking->serviceid;
        $booking->save();
    }

    public function deleteBooking(Booking $booking)
    {
        $booking->delete();
    }

    public function setBookingStatus(Booking $booking, Request $request)
    {
        $booking->status = $request->status;
        $booking->save();
    }
}
