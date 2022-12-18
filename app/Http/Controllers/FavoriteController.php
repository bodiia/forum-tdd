<?php

namespace App\Http\Controllers;

use App\Actions\Favorites\DeleteFavoriteAction;
use App\Actions\Favorites\MarkAsFavoriteAction;
use App\Models\Favorite;
use App\Models\Reply;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class FavoriteController extends Controller
{
    public function store(Reply $reply, Request $request): RedirectResponse
    {
        MarkAsFavoriteAction::execute($reply, $request->user());

        return Redirect::back()->with('success', __('flash.favorite.created'));
    }

    public function destroy(Reply $reply, Favorite $favorite): RedirectResponse
    {
        Gate::authorize('delete', $favorite);

        DeleteFavoriteAction::execute($favorite);

        return Redirect::back()->with('success', __('flash.favorite.deleted'));
    }
}
