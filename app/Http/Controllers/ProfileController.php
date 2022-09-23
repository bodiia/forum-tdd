<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $threads = $user->threads()->withCount('replies')->latest()->paginate(10);

        return view('profiles.show', compact('user', 'threads'));
    }
}
