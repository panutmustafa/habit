<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Hello, {{ $user->name }}!</h3>
                    <p class="mb-4">Welcome to your habit monitoring dashboard.</p>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <h4 class="text-md font-semibold mt-6 mb-3">Today's Habits ({{ $today->format('d F Y') }})</h4>
                    @if ($activeHabits->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($activeHabits as $habit)
                                <div class="p-4 border rounded-lg shadow-sm {{ $studentHabitsToday->has($habit->id) && $studentHabitsToday[$habit->id]->is_completed ? 'bg-green-50' : 'bg-gray-50' }}">
                                    <h5 class="font-bold">{{ $habit->name }}</h5>
                                    <p class="text-sm text-gray-600">{{ $habit->description }}</p>
                                    <form action="{{ route('siswa.habits.mark', $habit) }}" method="POST" class="mt-2">
                                        @csrf
                                        @if ($studentHabitsToday->has($habit->id) && $studentHabitsToday[$habit->id]->is_completed)
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Unmark Habit</button>
                                            <span class="text-green-600 font-semibold ml-2">Completed Today!</span>
                                        @else
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">Mark as Complete</button>
                                        @endif
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No active habits assigned yet.</p>
                    @endif

                    <h4 class="text-md font-semibold mt-6 mb-3">Daily Habit Summary (Last 7 Days)</h4>
                    @if ($dailyHabitStats->isNotEmpty())
                        <div class="overflow-x-auto mb-6">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">Date</th>
                                        <th class="py-2 px-4 border-b">Total Habits</th>
                                        <th class="py-2 px-4 border-b">Completed</th>
                                        <th class="py-2 px-4 border-b">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dailyHabitStats as $stats)
                                        <tr class="{{ $stats['percentage'] == 100 ? 'bg-green-50' : '' }}">
                                            <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($stats['date'])->format('d M') }}</td>
                                            <td class="py-2 px-4 border-b">{{ $stats['total_habits'] }}</td>
                                            <td class="py-2 px-4 border-b">{{ $stats['completed_habits'] }}</td>
                                            <td class="py-2 px-4 border-b">{{ $stats['percentage'] }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No daily habit statistics available.</p>
                    @endif

                    <h4 class="text-md font-semibold mt-6 mb-3">Your Recent Reflections</h4>
                    @if ($reflections->isNotEmpty())
                        <div class="space-y-4">
                            @foreach ($reflections as $reflection)
                                <div class="p-4 border rounded-lg shadow-sm {{ $reflection->is_reviewed ? 'bg-green-50' : 'bg-yellow-50' }}">
                                    <h5 class="font-bold">Week of {{ \Carbon\Carbon::parse($reflection->week_start_date)->format('d F Y') }}</h5>
                                    <p class="text-sm text-gray-600">{{ Str::limit($reflection->content, 100) }}</p>
                                    <div class="mt-2 text-xs">
                                        Status: 
                                                                                 <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $reflection->is_reviewed ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                                                                    {{ $reflection->is_reviewed ? 'Reviewed' : 'Pending Review' }}
                                                                                </span>
                                        
                                                                                @if (!$reflection->is_reviewed)
                                                                                    <a href="{{ route('siswa.reflections.edit', $reflection) }}" class="ml-2 inline-flex items-center px-2 py-1 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                                                        Edit
                                                                                    </a>
                                                                                @endif
                                                                            </div>                                    @if ($reflection->is_reviewed && $reflection->feedback)
                                        <div class="mt-4 p-3 bg-gray-100 rounded-lg text-sm">
                                            <h5 class="font-semibold">Teacher Feedback:</h5>
                                            <p class="text-gray-800">{{ $reflection->feedback }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No reflections submitted yet.</p>
                    @endif

                    <div class="mt-6 text-right">
                        <a href="{{ route('siswa.reflections.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Submit Weekly Reflection
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
