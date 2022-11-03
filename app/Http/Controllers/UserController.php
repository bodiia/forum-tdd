<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update(User $user, UpdateUserRequest $request): RedirectResponse
    {
        if ($user->avatar_path != User::DEFAULT_AVATAR) {
            Storage::delete($user->avatar_path);
        }

        $user->update([
            'avatar_path' => $request->file('avatar')->store('avatars'),
        ]);

        return back()->with('success', __('flash.user.update.image'));
    }
}
