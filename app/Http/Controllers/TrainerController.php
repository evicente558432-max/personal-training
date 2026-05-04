<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerController extends Controller {

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->role !== 'trainer') {
                return redirect()->route('login');
            }
            return $next($request);
        });
    }

    public function dashboard() {
        $trainer   = Auth::user()->trainer;
        $schedules = $trainer
            ? $trainer->schedules()->with('booking.user')->get()
            : collect();

        $total     = $schedules->count();
        $available = $schedules->where('status', 'available')->count();
        $booked    = $schedules->where('status', 'booked')->count();

        return view('trainer.dashboard', compact(
            'schedules', 'total', 'available', 'booked'
        ));
    }

    public function scheduleForm() {
        $trainer   = Auth::user()->trainer;
        $schedules = $trainer
            ? $trainer->schedules()->with('booking.user')->get()
            : collect();
        return view('trainer.schedule', compact('schedules'));
    }

    public function saveSchedule(Request $request) {
        $request->validate([
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
            'status'     => 'required|in:available,unavailable',
        ]);

        $user    = Auth::user();
        $trainer = $user->trainer;

        if (!$trainer) {
            $trainer = Trainer::create(['user_id' => $user->id]);
        }

        Schedule::create([
            'trainer_id' => $trainer->id,
            'date'       => $request->date,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'status'     => $request->status === 'available' ? 'available' : 'booked',
        ]);

        return back()->with('success', 'Schedule saved!');
    }

    public function deleteSchedule($id) {
        $trainer  = Auth::user()->trainer;
        $schedule = Schedule::where('id', $id)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();
        $schedule->delete();
        return back()->with('success', 'Schedule deleted.');
    }
}