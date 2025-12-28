<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Your Notifications</h3>

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

                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-semibold text-md">Unread Notifications ({{ $unreadNotifications->count() }})</h4>
                        @if ($unreadNotifications->isNotEmpty())
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    Mark All As Read
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($unreadNotifications->isNotEmpty())
                        <div class="space-y-4 mb-8">
                            @foreach ($unreadNotifications as $notification)
                                <div class="p-4 border rounded-lg shadow-sm bg-blue-50 relative">
                                    <p class="text-sm font-medium">{{ $notification->data['message'] }}</p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    <div class="absolute top-4 right-4 flex space-x-2">
                                        @if (isset($notification->data['url']))
                                            <a href="{{ $notification->data['url'] }}" class="text-blue-600 hover:underline text-xs">View Details</a>
                                        @endif
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-gray-500 hover:text-gray-700 text-xs">Mark as Read</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mb-8">No unread notifications.</p>
                    @endif

                    <h4 class="font-semibold text-md mb-3">Read Notifications ({{ $readNotifications->count() }})</h4>
                    @if ($readNotifications->isNotEmpty())
                        <div class="space-y-4">
                            @foreach ($readNotifications as $notification)
                                <div class="p-4 border rounded-lg shadow-sm bg-gray-100">
                                    <p class="text-sm">{{ $notification->data['message'] }}</p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    @if (isset($notification->data['url']))
                                        <a href="{{ $notification->data['url'] }}" class="text-blue-600 hover:underline text-xs mt-1 block">View Details</a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No read notifications.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
