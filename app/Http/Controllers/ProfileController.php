<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(User $user): View
    {
        $activities = Activity::feed($user);

        return view('profiles.show', compact('user', 'activities'));
    }
}
