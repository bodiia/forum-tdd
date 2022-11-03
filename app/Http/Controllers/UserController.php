<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request): RedirectResponse
    {
        $attributes = ['avatar_path' => $request->file('avatar')->store('avatars')];

        auth()->user()->update($attributes);

        return back();
    }
}
