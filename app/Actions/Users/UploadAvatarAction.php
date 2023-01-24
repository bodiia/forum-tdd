<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

final class UploadAvatarAction
{
    public function __construct(private readonly Filesystem $filesystem)
    {
    }

    public function execute(User $user, UploadedFile $file): void
    {
        if ($user->avatar_path != User::DEFAULT_AVATAR) {
            $this->filesystem->delete($user->avatar_path);
        }

        $user->avatar_path = $file->store('avatars');
        $user->save();
    }
}
