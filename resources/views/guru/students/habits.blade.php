<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Habits for ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Habit Completion for {{ $user->name }}</h3>

                    @if ($studentHabits->isEmpty())
                        <p>No habit data available for this student.</p>
                    @else
                        @foreach ($studentHabits as $date => $habitsByDate)
                            <div class="mb-6 p-4 border rounded-lg shadow-sm bg-gray-50">
                                <h4 class="text-md font-semibold mb-2">Date: {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</h4>
                                <ul class="list-disc pl-5">
                                    @foreach ($habitsByDate as $studentHabit)
                                        <li class="mb-1">
                                            <strong>{{ $studentHabit->habit->name }}:</strong> 
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $studentHabit->is_completed ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                {{ $studentHabit->is_completed ? 'Completed' : 'Not Completed' }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
