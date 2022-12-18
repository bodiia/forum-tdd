<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class UploadAvatarAction
{
    public static function execute(User $user, UploadedFile $file): void
    {
        if ($user->avatar_path != User::DEFAULT_AVATAR) {
            Storage::delete($user->avatar_path);
        }

        $user->update([
            'avatar_path' => $file->store('avatars'),
        ]);
    }
}
