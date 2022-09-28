<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $activities = Activity::feed($user);

        return view('profiles.show', compact('user', 'activities'));
    }
}
