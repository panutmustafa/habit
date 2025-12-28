<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse; // Import RedirectResponse
use Illuminate\View\View; // Import View

class NotificationController extends Controller
{
    /**
     * Display all notifications for the authenticated user.
     */
    public function index(): View
    {
        $user = Auth::user();
        return view('notifications.index', [
            'unreadNotifications' => $user->unreadNotifications,
            'readNotifications' => $user->readNotifications,
        ]);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(string $id): RedirectResponse
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return back()->with('success', 'Notification marked as read.');
        }

        return back()->with('error', 'Notification not found.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(): RedirectResponse
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    }
}
