<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class FollowController extends Controller
{
    public function store(User $user): RedirectResponse
    {
        Auth::user()->followings()->attach($user->id);
        
        return back();
    }

    public function delete(User $user): RedirectResponse
    {
        Auth::user()->followings()->detach($user->id);
        return back();
    }
}
