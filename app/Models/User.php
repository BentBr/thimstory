<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use thimstory\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return Eloquent\Relations\HasMany
     */
    public function stories()
    {
        return $this->HasMany('\thimstory\Models\Stories');
    }

    /**
     * @return Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->HasMany('\thimstory\Models\Subscriptions');
    }

    public static function getUserByUsername($userName)
    {
        return User::where('name', $userName)
                ->firstOrFail();
    }
}
