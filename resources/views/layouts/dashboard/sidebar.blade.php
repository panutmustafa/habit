<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden"></div>

<div :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
    class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto bg-gray-800 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-200" />
            <span class="text-white text-2xl mx-2 font-semibold">{{ config('app.name', 'Laravel') }}</span>
        </div>
    </div>

    <nav class="flex flex-col mt-10">
        <!-- Admin Links -->
        @if (Auth::user()->role === \App\Models\User::ADMIN_ROLE)
            <a class="flex items-center px-6 py-2 mt-4 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('admin.dashboard') }}">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7ZM12 14C15.3137 14 18 16.6863 18 20V21H6V20C6 16.6863 8.68629 14 12 14Z"
                        fill="currentColor"></path>
                </svg>
                <span class="mx-3">Dashboard Admin</span>
            </a>
            <a class="flex items-center px-6 py-2 mt-4 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('admin.users.index') }}">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 20H7C4.79086 20 3 18.2091 3 16V8C3 5.79086 4.79086 4 7 4H17C19.2091 4 21 5.79086 21 8V16C21 18.2091 19.2091 20 17 20ZM7 6C5.89543 6 5 6.89543 5 8V16C5 17.1046 5.89543 18 7 18H17C18.1046 18 19 17.1046 19 16V8C19 6.89543 18.1046 6 17 6H7Z" fill="currentColor"></path>
                    <path d="M12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9Z" fill="currentColor"></path>
                </svg>
                <span class="mx-3">Manage Users</span>
            </a>
            <a class="flex items-center px-6 py-2 mt-4 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('admin.kelas.index') }}">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" fill="currentColor"></path>
                    <path d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12C20 16.4183 16.4183 20 12 20Z" fill="currentColor"></path>
                </svg>
                <span class="mx-3">Manage Classes</span>
            </a>
            <a class="flex items-center px-6 py-2 mt-4 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('admin.habits.index') }}">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12C10.8954 12 10 12.8954 10 14C10 15.1046 10.8954 16 12 16C13.1046 16 14 15.1046 14 14C14 12.8954 13.1046 12 12 12Z" fill="currentColor"></path>
                    <path d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM12 20C7.58172 20 4 16.4183 4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12C20 16.4183 16.4183 20 12 20Z" fill="currentColor"></path>
                </svg>
                <span class="mx-3">Manage Habits</span>
            </a>
        @endif

        <!-- Guru Links -->
        @if (Auth::user()->role === \App\Models\User::GURU_ROLE)
            <a class="flex items-center px-6 py-2 mt-4 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('guru.dashboard') }}">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7ZM12 14C15.3137 14 18 16.6863 18 20V21H6V20C6 16.6863 8.68629 14 12 14Z" fill="currentColor"></path>
                </svg>
                <span class="mx-3">Dashboard Guru</span>
            </a>
            <a class="flex items-center px-6 py-2 mt-4 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('guru.report') }}">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 14H11V9H13V14Z" fill="currentColor"></path>
                    <path d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM4 12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12C20 16.4183 16.4183 20 12 20C7.58172 20 4 16.4183 4 12Z" fill="currentColor"></path>
                    <path d="M12 16H12.01V16.01H12V16Z" fill="currentColor"></path>
                </svg>
                <span class="mx-3">Cetak Laporan</span>
            </a>
        @endif

        <!-- Siswa Links -->
        @if (Auth::user()->role === \App\Models\User::SISWA_ROLE)
            <a class="flex items-center px-6 py-2 mt-4 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('siswa.dashboard') }}">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7ZM12 14C15.3137 14 18 16.6863 18 20V21H6V20C6 16.6863 8.68629 14 12 14Z" fill="currentColor"></path>
                </svg>
                <span class="mx-3">Dashboard Siswa</span>
            </a>
            <a class="flex items-center px-6 py-2 mt-4 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('siswa.reflections.create') }}">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7ZM12 14C15.3137 14 18 16.6863 18 20V21H6V20C6 16.6863 8.68629 14 12 14Z" fill="currentColor"></path>
                </svg>
                <span class="mx-3">Isi Refleksi</span>
            </a>
        @endif

        <!-- Profile/Logout for all roles in sidebar -->
        <div class="absolute bottom-0 w-full">
            <a class="flex items-center px-6 py-2 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                href="{{ route('profile.edit') }}">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4C14.2091 4 16 5.79086 16 8C16 10.2091 14.2091 12 12 12C9.79086 12 8 10.2091 8 8C8 5.79086 9.79086 4 12 4ZM12 14C16.4183 14 20 17.5817 20 22H4C4 17.5817 7.58172 14 12 14Z" fill="currentColor"></path>
                </svg>
                <span class="mx-3">Profile</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="flex items-center px-6 py-2 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 16L21 12L17 8M21 12H9M13 18V20C13 20.5523 12.5523 21 12 21H5C4.44772 21 4 20.5523 4 20V4C4 3.44772 4.44772 3 5 3H12C12.5523 3 13 3.44772 13 4V6" fill="currentColor"></path>
                    </svg>
                    <span class="mx-3">Log Out</span>
                </a>
            </form>
        </div>
    </nav>
</div>
