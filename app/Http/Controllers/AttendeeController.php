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
     * @param Request $request
     * @param Lan $lan
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Lan $lan)
    {
        $users = $lan->users;

        $users->load('state', 'state.app', 'state.server', 'OAuthAccounts', 'SteamApps', 'SteamMetadata', 'lans');

        return View::make('pages.users.index')
            ->with('lan', $lan)
            ->with('users', $users);
    }

}