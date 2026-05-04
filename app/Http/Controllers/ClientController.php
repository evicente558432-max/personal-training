<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller {

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->role !== 'client') {
                return redirect()->route('login');
            }
            return $next($request);
        });
    }

    public function dashboard() {
        $openSlots  = Schedule::where('status', 'available')->count();
        $myBookings = Booking::where('user_id', Auth::id())
            ->where('status', 'booked')
            ->count();
        return view('client.dashboard', compact('openSlots', 'myBookings'));
    }

    public function viewSchedule() {
        $schedules = Schedule::where('status', 'available')
            ->with('trainer.user')
            ->get();
        return view('client.view_schedule', compact('schedules'));
    }

    public function bookSession($id) {
        $schedule = Schedule::findOrFail($id);

        if ($schedule->status !== 'available') {
            return back()->with('error', 'Session is no longer available.');
        }

        $exists = Booking::where('user_id', Auth::id())
            ->whereHas('schedule', fn($q) => $q->where('date', $schedule->date))
            ->where('status', 'booked')
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

    public function myBookings() {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('schedule.trainer.user')
            ->get();
        return view('client.my_bookings', compact('bookings'));
    }

    public function cancelSession($id) {
        $booking  = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $schedule = $booking->schedule;

        $booking->update(['status' => 'cancelled']);
        $schedule->update(['status' => 'available']);

        return back()->with('success', 'Booking cancelled.');
    }
}