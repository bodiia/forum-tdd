<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;

class UserNotificationController extends Controller
{
    public function destroy(User $user, DatabaseNotification $notification): RedirectResponse
    {
        $notification->markAsRead();

        return redirect($notification->data['link']);
    }
}
