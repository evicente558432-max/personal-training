<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller {

    // Dashboard
    public function dashboard() {
        $openSlots  = Schedule::where('status', 'available')->count();
        $myBookings = Booking::where('user_id', Auth::id())->count();
        return view('client.dashboard', compact('openSlots', 'myBookings'));
    }

    // View available sessions
    public function viewSchedule() {
        $schedules = Schedule::where('status', 'available')
            ->with('trainer.user')
            ->get();
        return view('client.view_schedule', compact('schedules'));
    }

    // Book a session
    public function bookSession($id) {
        $schedule = Schedule::findOrFail($id);

        if ($schedule->status !== 'available') {
            return back()->with('error', 'Session is no longer available.');
        }

        // Prevent double booking
        $exists = Booking::where('user_id', Auth::id())
            ->whereHas('schedule', fn($q) => $q->where('date', $schedule->date))
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have a booking on this date.');
        }

        $schedule->update(['status' => 'booked']);

        Booking::create([
            'schedule_id' => $schedule->id,
            'user_id'     => Auth::id(),
            'status'      => 'booked',
        ]);

        return back()->with('success', 'Session booked successfully!');
    }

    // View my bookings
    public function myBookings() {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('schedule.trainer.user')
            ->get();
        return view('client.my_bookings', compact('bookings'));
    }

    // Cancel a booking
    public function cancelSession($id) {
        $booking  = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $schedule = $booking->schedule;

        $booking->update(['status' => 'cancelled']);
        $schedule->update(['status' => 'available']);

        return back()->with('success', 'Booking cancelled.');
    }
}