<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Reflection') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Review Reflection for {{ $reflection->user->name }}</h3>
                    <p class="mb-4">Week of: {{ \Carbon\Carbon::parse($reflection->week_start_date)->format('d F Y') }}</p>
                    <div class="p-4 border rounded-lg bg-gray-50 mb-6">
                        <h4 class="font-bold">Student's Reflection:</h4>
                        <p>{{ $reflection->content }}</p>
                    </div>

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

                    <form method="POST" action="{{ route('guru.reflections.feedback', $reflection) }}">
                        @csrf
                        @method('PUT')

                        <!-- Teacher Feedback -->
                        <div>
                            <x-input-label for="feedback" :value="__('Teacher Feedback')" />
                            <textarea id="feedback" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="feedback" rows="7">{{ old('feedback', $reflection->feedback) }}</textarea>
                            <x-input-error :messages="$errors->get('feedback')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Submit Feedback') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <div class="mt-6">
                        <a href="{{ route('guru.students.reflections', $reflection->user) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Back to Student Reflections
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
