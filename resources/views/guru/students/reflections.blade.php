<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Reflections for ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Reflections for {{ $user->name }}</h3>

                    @if ($reflections->isEmpty())
                        <p>No reflections available for this student.</p>
                    @else
                        @foreach ($reflections as $reflection)
                            <div class="mb-6 p-4 border rounded-lg shadow-sm {{ $reflection->is_reviewed ? 'bg-green-50' : 'bg-red-50' }}">
                                <h4 class="text-md font-semibold mb-2">Week of {{ \Carbon\Carbon::parse($reflection->week_start_date)->format('d F Y') }}</h4>
                                <p class="text-gray-700">{{ $reflection->content }}</p>
                                <div class="mt-2 text-sm">
                                    Status: 
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $reflection->is_reviewed ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                        {{ $reflection->is_reviewed ? 'Reviewed by ' . ($reflection->reviewedBy->name ?? 'N/A') : 'Pending Review' }}
                                    </span>
                                </div>
                                @if ($reflection->feedback)
                                    <div class="mt-4 p-3 bg-gray-100 rounded-lg text-sm">
                                        <h5 class="font-semibold">Teacher Feedback:</h5>
                                        <p class="text-gray-800">{{ $reflection->feedback }}</p>
                                    </div>
                                @endif
                                <div class="mt-4">
                                    <a href="{{ route('guru.reflections.review', $reflection) }}" class="inline-flex items-center px-3 py-1 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-800 uppercase tracking-widest hover:bg-indigo-200 focus:outline-none focus:border-indigo-500 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        {{ $reflection->is_reviewed ? 'Edit Feedback' : 'Add Feedback' }}
                                    </a>
                                </div>
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
