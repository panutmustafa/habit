<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this line
use App\Models\User; // Add this line
use App\Models\Kela;
use App\Models\StudentHabit;
use App\Models\Reflection;
use App\Models\Habit; // Add this line
use Carbon\Carbon;
use PDF; // Import the PDF Facade

class GuruController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $myClass = $user->kela;
        $students = collect([]);
        $habits = Habit::where('is_active', true)->get();

        if ($myClass) {
            $students = $myClass->users()->where('role', User::SISWA_ROLE)->get();
        }
        
        return view('guru.dashboard', compact('user', 'myClass', 'students', 'habits'));
    }

    public function showStudentHabits(User $user)
    {
        // Ensure the student belongs to the teacher's class
        if (Auth::user()->kela_id !== $user->kela_id) {
            return redirect()->back()->with('error', 'You are not authorized to view this student\'s habits.');
        }

        $studentHabits = StudentHabit::where('user_id', $user->id)
                                    ->with('habit')
                                    ->orderBy('date', 'desc')
                                    ->get()
                                    ->groupBy(function($item) {
                                        return Carbon::parse($item->date)->format('Y-m-d');
                                    });

        return view('guru.students.habits', compact('user', 'studentHabits'));
    }

    public function showStudentReflections(User $user)
    {
        // Ensure the student belongs to the teacher's class
        if (Auth::user()->kela_id !== $user->kela_id) {
            return redirect()->back()->with('error', 'You are not authorized to view this student\'s reflections.');
        }

        $reflections = Reflection::where('user_id', $user->id)
                                ->with('reviewedBy') // Eager load the reviewer
                                ->orderBy('week_start_date', 'desc')
                                ->get();

        return view('guru.students.reflections', compact('user', 'reflections'));
    }

    public function reviewReflection(Reflection $reflection)
    {
        // Ensure the teacher is authorized to review this reflection (student is in their class)
        if (Auth::user()->kela_id !== $reflection->user->kela_id) {
            return redirect()->back()->with('error', 'You are not authorized to review this reflection.');
        }
        
        return view('guru.reflections.review', compact('reflection'));
    }

    public function storeReflectionFeedback(Request $request, Reflection $reflection)
    {
        // Ensure the teacher is authorized to review this reflection (student is in their class)
        if (Auth::user()->kela_id !== $reflection->user->kela_id) {
            return redirect()->back()->with('error', 'You are not authorized to review this reflection.');
        }

        $request->validate([
            'feedback' => 'nullable|string',
        ]);

        $reflection->update([
            'feedback' => $request->feedback,
            'is_reviewed' => true,
            'reviewed_by' => Auth::id(),
        ]);

        return redirect()->route('guru.students.reflections', $reflection->user)->with('success', 'Feedback submitted successfully.');
    }

    public function generateReport()
    {
        $teacher = Auth::user();
        $myClass = $teacher->kela;
        $reportData = [];

        if (!$myClass) {
            return redirect()->back()->with('error', 'You are not assigned to any class to generate a report.');
        }

        $students = $myClass->users()->where('role', User::SISWA_ROLE)->get();
        $allActiveHabits = Habit::where('is_active', true)->get();
        $totalActiveHabitsCount = $allActiveHabits->count();

        foreach ($students as $student) {
            $studentReport = [
                'student' => $student,
                'daily_habit_stats' => collect(),
                'reflections' => Reflection::where('user_id', $student->id)
                                    ->with('reviewedBy')
                                    ->orderBy('week_start_date', 'desc')
                                    ->get(),
            ];

            // Calculate daily habit stats for the last 7 days for each student
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $completedHabitsCount = StudentHabit::where('user_id', $student->id)
                                                    ->where('date', $date)
                                                    ->where('is_completed', true)
                                                    ->count();
                
                $studentReport['daily_habit_stats']->push([
                    'date' => $date,
                    'total_habits' => $totalActiveHabitsCount,
                    'completed_habits' => $completedHabitsCount,
                    'percentage' => $totalActiveHabitsCount > 0 ? round(($completedHabitsCount / $totalActiveHabitsCount) * 100) : 0,
                ]);
            }
            $reportData[] = $studentReport;
        }

        $pdf = PDF::loadView('guru.report', compact('teacher', 'myClass', 'reportData'));
        return $pdf->download('Laporan-Kebiasaan-Kelas-' . $myClass->name . '-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }
}
