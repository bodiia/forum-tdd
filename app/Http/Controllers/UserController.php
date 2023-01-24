<?php

namespace App\Http\Controllers;

use App\Actions\Users\UploadAvatarAction;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function __construct(private readonly UploadAvatarAction $uploadAvatarAction)
    {
    }

    public function update(User $user, UpdateUserRequest $request): RedirectResponse
    {
        $this->uploadAvatarAction->execute(
            $request->user(),
            $request->file('avatar')
        );

        return back()->with('success', __('flash.user.update.image'));
    }
}
