<?php

namespace App\Http\Controllers;

use App\Actions\Favorites\DeleteFavoriteAction;
use App\Actions\Favorites\MarkAsFavoriteAction;
use App\Models\Favorite;
use App\Models\Reply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct(
        private readonly MarkAsFavoriteAction $markAsFavoriteAction,
        private readonly DeleteFavoriteAction $deleteFavoriteAction,
    ) {
    }

    public function store(Reply $reply, Request $request): RedirectResponse
    {
        $this->markAsFavoriteAction->execute($reply, $request->user());

        return back()->with('success', __('flash.favorite.created'));
    }

    public function destroy(Reply $reply, Favorite $favorite): RedirectResponse
    {
        $this->authorize('delete', $favorite);

        $this->deleteFavoriteAction->execute($favorite);

        return back()->with('success', __('flash.favorite.deleted'));
    }
}
