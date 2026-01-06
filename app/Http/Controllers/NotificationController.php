<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Fetch notifications for authenticated user (UMKM or Admin)
    public function index(Request $request)
    {
        $userType = session('admin_id') ? 'admin' : 'umkm';
        $userId = session('admin_id') ?? session('umkm_id');

        if (!$userId) {
            return response()->json(['notifications' => [], 'unread_count' => 0]);
        }

        $notifications = Notification::where('user_id', $userId)
            ->where('user_type', $userType)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'link' => $notification->link,
                    'is_read' => $notification->is_read,
                    'time_ago' => $notification->time_ago,
                    'created_at' => $notification->created_at->format('d M Y H:i')
                ];
            });

        $unreadCount = Notification::where('user_id', $userId)
            ->where('user_type', $userType)
            ->unread()
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    // Mark single notification as read
    public function markAsRead($id)
    {
        $userType = session('admin_id') ? 'admin' : 'umkm';
        $userId = session('admin_id') ?? session('umkm_id');

        $notification = Notification::where('id', $id)
            ->where('user_id', $userId)
            ->where('user_type', $userType)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    // Mark all notifications as read
    public function markAllAsRead()
    {
        $userType = session('admin_id') ? 'admin' : 'umkm';
        $userId = session('admin_id') ?? session('umkm_id');

        Notification::where('user_id', $userId)
            ->where('user_type', $userType)
            ->unread()
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    // Delete single notification
    public function destroy($id)
    {
        $userType = session('admin_id') ? 'admin' : 'umkm';
        $userId = session('admin_id') ?? session('umkm_id');

        $notification = Notification::where('id', $id)
            ->where('user_id', $userId)
            ->where('user_type', $userType)
            ->first();

        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    // Delete all read notifications
    public function deleteAllRead()
    {
        $userType = session('admin_id') ? 'admin' : 'umkm';
        $userId = session('admin_id') ?? session('umkm_id');

        Notification::where('user_id', $userId)
            ->where('user_type', $userType)
            ->where('is_read', true)
            ->delete();

        return response()->json(['success' => true]);
    }

    // Get unread count only (for badge update)
    public function getUnreadCount()
    {
        $userType = session('admin_id') ? 'admin' : 'umkm';
        $userId = session('admin_id') ?? session('umkm_id');

        if (!$userId) {
            return response()->json(['unread_count' => 0]);
        }

        $unreadCount = Notification::where('user_id', $userId)
            ->where('user_type', $userType)
            ->unread()
            ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }
}
