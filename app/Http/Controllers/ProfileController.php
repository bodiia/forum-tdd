<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ActivityService;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private readonly ActivityService $activityService)
    {
    }

    public function show(User $user): View
    {
        $activities = $this->activityService->getFeedForUser($user);

        return view('profiles.show', compact('user', 'activities'));
    }
}
