<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Habit;
use App\Models\StudentHabit;
use App\Models\Reflection;
use Carbon\Carbon;

class SiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        $activeHabits = Habit::where('is_active', true)->get();
        $studentHabitsToday = StudentHabit::where('user_id', $user->id)
                                        ->where('date', $today)
                                        ->get()
                                        ->keyBy('habit_id');

        $reflections = Reflection::where('user_id', $user->id)
                                ->orderBy('week_start_date', 'desc')
                                ->take(5) // Show last 5 reflections
                                ->get();
        
        // --- Daily Habit Statistics for the last 7 days ---
        $dailyHabitStats = collect();
        $totalActiveHabits = $activeHabits->count();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $completedHabitsCount = StudentHabit::where('user_id', $user->id)
                                                ->where('date', $date)
                                                ->where('is_completed', true)
                                                ->count();
            
            $dailyHabitStats->push([
                'date' => $date,
                'total_habits' => $totalActiveHabits,
                'completed_habits' => $completedHabitsCount,
                'percentage' => $totalActiveHabits > 0 ? round(($completedHabitsCount / $totalActiveHabits) * 100) : 0,
            ]);
        }
                                
        return view('siswa.dashboard', compact('user', 'activeHabits', 'studentHabitsToday', 'today', 'reflections', 'dailyHabitStats'));
    }

    public function markHabit(Request $request, Habit $habit)
    {
        $user = Auth::user();
        $today = Carbon::today();

        $studentHabit = StudentHabit::where('user_id', $user->id)
                                    ->where('habit_id', $habit->id)
                                    ->where('date', $today)
                                    ->first();

        if ($studentHabit) {
            // If exists, toggle the status
            $studentHabit->is_completed = !$studentHabit->is_completed;
            $studentHabit->save();
            $message = $studentHabit->is_completed ? 'Habit marked as complete!' : 'Habit unmarked.';
        } else {
            // If not exists, create as completed
            StudentHabit::create([
                'user_id' => $user->id,
                'habit_id' => $habit->id,
                'date' => $today,
                'is_completed' => true,
            ]);
            $message = 'Habit marked as complete for today!';
        }

        return redirect()->route('siswa.dashboard')->with('success', $message);
    }

    public function createReflection()
    {
        // Determine the start date of the current week (e.g., Monday)
        $weekStartDate = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $user = Auth::user();

        // Check if a reflection for this week already exists
        $existingReflection = Reflection::where('user_id', $user->id)
                                        ->where('week_start_date', $weekStartDate)
                                        ->first();

        if ($existingReflection) {
            return redirect()->route('siswa.dashboard')->with('error', 'You have already submitted a reflection for this week.');
        }

        return view('siswa.reflections.create', compact('weekStartDate'));
    }

    public function storeReflection(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:10',
            'week_start_date' => 'required|date',
        ]);

        $user = Auth::user();

        // Prevent duplicate submissions for the same week
        $existingReflection = Reflection::where('user_id', $user->id)
                                        ->where('week_start_date', $request->week_start_date)
                                        ->first();

        if ($existingReflection) {
            return redirect()->route('siswa.dashboard')->with('error', 'You have already submitted a reflection for this week.');
        }

        Reflection::create([
            'user_id' => $user->id,
            'week_start_date' => $request->week_start_date,
            'content' => $request->content,
            'is_reviewed' => false, // Default to false
        ]);
        
        return redirect()->route('siswa.dashboard')->with('success', 'Reflection submitted successfully!');
    }

    public function editReflection(Reflection $reflection)
    {
        // Ensure the authenticated user is the owner of the reflection
        if (Auth::id() !== $reflection->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Optional: Prevent editing if the reflection has been reviewed
        if ($reflection->is_reviewed) {
            return redirect()->route('siswa.dashboard')->with('error', 'This reflection has already been reviewed and cannot be edited.');
        }

        return view('siswa.reflections.edit', compact('reflection'));
    }

    public function updateReflection(Request $request, Reflection $reflection)
    {
        // Ensure the authenticated user is the owner of the reflection
        if (Auth::id() !== $reflection->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Optional: Prevent editing if the reflection has been reviewed
        if ($reflection->is_reviewed) {
            return redirect()->route('siswa.dashboard')->with('error', 'This reflection has already been reviewed and cannot be edited.');
        }

        $request->validate([
            'content' => 'required|string|min:10',
        ]);

        $reflection->update([
            'content' => $request->content,
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Reflection updated successfully!');
    }
}
