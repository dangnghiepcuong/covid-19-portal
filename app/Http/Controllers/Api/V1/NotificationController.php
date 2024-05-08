<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ActionStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()
            ->paginate(config('parameters.DEFAULT_LOADED_NOTIFICATIONS_NUMBER'));

        return response()->json($notifications, 200);
    }

    public function countUnread(Request $request)
    {
        $user = $request->user();
        $unread = $user->unreadNotifications()->count();

        return response()->json($unread, 200);
    }

    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
        $user->unreadNotifications->markAsRead();

        return response()->json([
            'status' => ActionStatus::SUCCESS,
            'message' => 'OK',
        ], 200);
    }
}
