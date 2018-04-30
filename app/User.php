<?php

namespace Zeropingheroes\Lanager;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get the user's linked accounts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function OAuthAccounts()
    {
        return $this->hasMany('Zeropingheroes\Lanager\UserOAuthAccount');
    }

    /**
     * The roles that belong to the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this
            ->belongsToMany('Zeropingheroes\Lanager\Role', 'role_assignments')
            ->withTimestamps();
    }

    /**
     * Check if the user has the specified role(s)
     * 
     * @param array $roles
     * @return bool
     * @internal param $role
     */
    public function hasRole(...$roles)
    {
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }
        return false;
    }

    /**
     * Pseudo-relation: A single user's most recent state
     *
     * @return object Illuminate\Database\Eloquent\Relations\Relation
     */
    public function state()
    {
        $start = Carbon::createFromTimeStamp(time() - (60));
        $end = Carbon::createFromTimeStamp(time() + (60));

        return $this->hasOne('Zeropingheroes\Lanager\SteamUserState')
            ->join(
                DB::raw('(
								SELECT max(created_at) max_created_at, user_id
								FROM steam_user_states
								WHERE created_at
									BETWEEN "'.$start.'"
									AND 	"'.$end.'"
								GROUP BY user_id
								) s2'),
                function ($join) {
                    $join->on('steam_user_states.user_id', '=', 's2.user_id')
                        ->on('steam_user_states.created_at', '=', 's2.max_created_at');
                })
            ->orderBy('steam_user_states.user_id')
            ->withDefault(
                [
                    'online_status' => 0
                ]
            );
    }

}
