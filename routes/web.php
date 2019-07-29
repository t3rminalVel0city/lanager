<?php

/**
 * Current LAN
 */
Route::get('/', 'CurrentLanController@show')
    ->name('home');
Route::get('/guides', 'CurrentLanController@guides')
    ->name('guides');
Route::get('/events', 'CurrentLanController@events')
    ->name('events');
Route::get('/schedule', 'CurrentLanController@schedule')
    ->name('schedule');
Route::get('/users', 'CurrentLanController@users')
    ->name('users');
Route::get('/user-achievements', 'CurrentLanController@userAchievements')
    ->name('users');

/**
 * Login
 */
Route::get('login', 'AuthController@showLoginForm')
    ->middleware(['guest'])
    ->name('login');

Route::get('auth/{provider}', 'AuthController@redirectToProvider')
    ->middleware(['guest'])
    ->name('auth');

Route::get('auth/{provider}/callback', 'AuthController@handleProviderCallback')
    ->middleware(['guest'])
    ->name('auth.callback');

/**
 * Logout
 */
Route::post('logout', 'AuthController@logout')
    ->middleware(['auth'])
    ->name('logout');

/**
 * Roles & Role Assignments
 */
Route::resource('role-assignments', 'RoleAssignmentController', ['except' => ['show', 'edit', 'update']]);

/**
 * Logs
 */
Route::resource('logs', 'LogController', ['only' => ['index', 'show']]);
Route::patch('logs', 'LogController@patch')
    ->name('logs.patch');

/**
 * Games
 */
Route::get('/games/in-progress', 'GameController@inProgress')
    ->name('games.in-progress');
Route::get('/games/recent', 'GameController@recent')
    ->name('games.recent');
Route::get('/games/owned', 'GameController@owned')
    ->name('games.owned');
Route::get('/games/fullscreen', function () {
    return view('pages.games.fullscreen');
})->name('games.fullscreen');

/**
 * LANs
 */
Route::resource('lans', 'LanController');

/**
 * LAN Favourite Games
 */
Route::resource('lans.favourite-games', 'LanFavouriteGameController', ['only' => ['index']]);

/**
 * Guides
 */
Route::resource('lans.guides', 'GuideController', ['except' => 'show']);
Route::get('lans/{lan}/guides/{guide}/{slug?}', 'GuideController@show')
    ->name('lans.guides.show');

/**
 * Events
 */
Route::resource('lans.events', 'EventController');
Route::resource('lans.events.signups', 'EventSignupController', ['only' => ['store', 'destroy']]);
Route::get('/events/fullscreen', function () {
    return view('pages.events.fullscreen');
})->name('events.fullscreen');

/**
 * Users & Attendees
 */
Route::resource('users', 'UserController', ['only' => ['show', 'destroy']]);
Route::resource('lans.attendees', 'AttendeeController', ['only' => ['index']]);

/**
 * Achievements
 */
Route::resource('achievements', 'AchievementController');
Route::resource('lans.user-achievements', 'UserAchievementController', ['except' => ['show', 'edit', 'update']]);

/**
 * Navigation Links
 */
Route::resource('navigation-links', 'NavigationLinkController', ['except' => 'show']);

/**
 * Images
 */
Route::resource('images', 'ImageController', ['only' => ['index', 'store', 'edit', 'update', 'destroy']]);

/**
 * Venues
 */
Route::resource('venues', 'VenueController');

/**
 * Slides
 */
Route::get('lans/{lan}/slides/play', function (Zeropingheroes\Lanager\Lan $lan) {
    return view('pages.slides.play', ['lan' => $lan]);
})->name('lans.slides.play');
Route::resource('lans.slides', 'SlideController');

/**
 * Whitelisted IP Ranges
 */
Route::resource('whitelisted-ip-ranges', 'WhitelistedIpRangeController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'destroy']]);

Route::fallback(function () {
    return view('errors.404');
})->name('fallback');