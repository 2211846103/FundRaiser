<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markRead(Notification $notification)
    {
        $notification->update([
            'read' => true
        ]);

        return redirect()->back();
    }
    public function clear(Notification $notification)
    {
        $notification->delete();

        return redirect()->back();
    }
    public function markAllRead()
    {
        foreach (auth()->user()->notifications as $notification) {
            $notification->update([
                'read' => true
            ]);
        }

        return redirect()->back();
    }
    public function clearAll()
    {
        foreach (auth()->user()->notifications as $notification) {
            $notification->delete();
        }

        return redirect()->back();
    }
}
