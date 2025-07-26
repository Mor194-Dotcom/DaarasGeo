<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();

        $notifications = \App\Models\Notification::where('utilisateur_id', $user->id)
            ->orderByDesc('date_envoi')
            ->paginate(4);

        return view('notifications.index', compact('notifications'));
    }

    //valider
    public function valider(\App\Models\Notification $notification)
    {
        $user = auth()->user();

        if ($notification->utilisateur_id !== $user->id) {
            abort(403);
        }

        $notification->vue = true;
        $notification->save();



        return back()->with('success', 'Notification validée.');
    }
}
