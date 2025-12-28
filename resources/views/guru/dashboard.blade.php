<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ $user->name }}!</h3>
                    <p class="mb-4">Your assigned class: <strong>{{ $myClass->name ?? 'N/A' }}</strong></p>

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <h4 class="text-md font-semibold mt-6 mb-3">Students in Your Class ({{ $myClass->name ?? 'N/A' }})</h4>
                    @if ($students->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">Name</th>
                                        <th class="py-2 px-4 border-b">Email</th>
                                        <th class="py-2 px-4 border-b">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $student->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $student->email }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <a href="{{ route('guru.students.habits', $student) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs mr-2">View Habits</a>
                                                <a href="{{ route('guru.students.reflections', $student) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs">View Reflections</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No students assigned to your class yet.</p>
                    @endif

                    <div class="mt-6 text-right">
                        <a href="{{ route('guru.report') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-900 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Print Class Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
