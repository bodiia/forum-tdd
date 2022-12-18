<?php

namespace App\Http\Controllers;

use App\Actions\Users\UploadAvatarAction;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function update(User $user, UpdateUserRequest $request): RedirectResponse
    {
        UploadAvatarAction::execute($request->user(), $request->file('avatar'));

        return Redirect::back()->with('success', __('flash.user.update.image'));
    }
}
