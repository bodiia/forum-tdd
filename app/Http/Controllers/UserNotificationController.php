<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Redirect;

class UserNotificationController extends Controller
{
    public function destroy(User $user, DatabaseNotification $notification): RedirectResponse
    {
        $notification->markAsRead();

        return Redirect::to($notification->data['link']);
    }
}
