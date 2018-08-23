<?php

namespace Zeropingheroes\Lanager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Zeropingheroes\Lanager\Lan;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Lan $lan
     * @return \Illuminate\Contracts\View\View
     * @internal param Request $request
     */
    public function index(Lan $lan)
    {
        $users = $lan->users()->orderBy('username')->get();

        $users->load('steamAppSessions.app', 'OAuthAccounts', 'SteamApps', 'SteamMetadata', 'lans');

        return View::make('pages.users.index')
            ->with('lan', $lan)
            ->with('users', $users);
    }

}
