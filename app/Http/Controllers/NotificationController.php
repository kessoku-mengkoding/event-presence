<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notifications', [
            'title' => 'Notification'
        ]);
    }

    public static function create($user_id, $title, $message, $type, $key)
    {
        $notification = new Notification();
        $notification->user_id = $user_id;
        $notification->title = $title;
        $notification->message = $message;
        $notification->type = $type;
        $notification->key = $key;
        $notification->save();
    }
}
