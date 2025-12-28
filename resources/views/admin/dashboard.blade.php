<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, Admin!</h3>
                    <p class="mb-4">Here's a quick overview of your system:</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <div class="p-4 bg-purple-100 rounded-lg shadow-md text-purple-800 text-center">
                            <h4 class="text-2xl font-bold">{{ $totalUsers }}</h4>
                            <p class="text-sm">Total Users</p>
                        </div>
                        <div class="p-4 bg-blue-100 rounded-lg shadow-md text-blue-800 text-center">
                            <h4 class="text-2xl font-bold">{{ $guruCount }}</h4>
                            <p class="text-sm">Total Guru</p>
                        </div>
                        <div class="p-4 bg-green-100 rounded-lg shadow-md text-green-800 text-center">
                            <h4 class="text-2xl font-bold">{{ $siswaCount }}</h4>
                            <p class="text-sm">Total Siswa</p>
                        </div>
                        <div class="p-4 bg-red-100 rounded-lg shadow-md text-red-800 text-center">
                            <h4 class="text-2xl font-bold">{{ $adminCount }}</h4>
                            <p class="text-sm">Total Admin</p>
                        </div>
                        <div class="p-4 bg-yellow-100 rounded-lg shadow-md text-yellow-800 text-center">
                            <h4 class="text-2xl font-bold">{{ $totalKelas }}</h4>
                            <p class="text-sm">Total Classes</p>
                        </div>
                        <div class="p-4 bg-indigo-100 rounded-lg shadow-md text-indigo-800 text-center">
                            <h4 class="text-2xl font-bold">{{ $totalHabits }}</h4>
                            <p class="text-sm">Total Habits</p>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.users.index') }}" class="block p-6 bg-blue-100 hover:bg-blue-200 rounded-lg shadow-md text-blue-800 font-bold text-center">
                            Manage Users
                        </a>
                        <a href="{{ route('admin.kelas.index') }}" class="block p-6 bg-green-100 hover:bg-green-200 rounded-lg shadow-md text-green-800 font-bold text-center">
                            Manage Classes
                        </a>
                        <a href="{{ route('admin.habits.index') }}" class="block p-6 bg-yellow-100 hover:bg-yellow-200 rounded-lg shadow-md text-yellow-800 font-bold text-center">
                            Manage Habits
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>