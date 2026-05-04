<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trainer;
use App\Models\Schedule;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {

    // Dashboard
    public function dashboard() {
        $totalTrainers  = User::where('role', 'trainer')->count();
        $totalClients   = User::where('role', 'client')->count();
        $totalSessions  = Schedule::count();
        $totalBooked    = Schedule::where('status', 'booked')->count();

        return view('admin.dashboard', compact(
            'totalTrainers', 'totalClients', 'totalSessions', 'totalBooked'
        ));
    }

    // Show all trainers
    public function trainers() {
        $trainers = User::where('role', 'trainer')->with('trainer')->get();
        return view('admin.trainers', compact('trainers'));
    }

    // Add trainer
    public function addTrainer(Request $request) {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users',
            'specialty' => 'nullable|string|max:100',
            'password'  => 'required|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'trainer',
        ]);

        Trainer::create([
            'user_id'   => $user->id,
            'specialty' => $request->specialty,
        ]);

        return back()->with('success', 'Trainer added successfully.');
    }

    // Delete trainer
    public function deleteTrainer($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Trainer deleted.');
    }

    // Show all schedules
    public function schedules() {
        $schedules = Schedule::with('trainer.user', 'booking.user')->get();
        return view('admin.schedules', compact('schedules'));
    }

    // Delete schedule
    public function deleteSchedule($id) {
        Schedule::findOrFail($id)->delete();
        return back()->with('success', 'Schedule deleted.');
    }

    // Reports
    public function reports(Request $request) {
        $query = Schedule::with('trainer.user', 'booking.user');

        if ($request->from) $query->where('date', '>=', $request->from);
        if ($request->to)   $query->where('date', '<=', $request->to);
        if ($request->type === 'bookings') $query->where('status', 'booked');

        $schedules = $query->get();
        return view('admin.reports', compact('schedules'));
    }
}