<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\Model;
use thimstory\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent;

class UserSubscriptions extends Model
{
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subscribed_user_id',
        'user_id',
        'update',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'update'            => 'boolean',
    ];

    /**
     * Describes user which subscribed to another one

     * @return Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\thimstory\Models\User');
    }

    /**
     * Describes user to which has been subscribed
     *
     * @return Eloquent\Relations\BelongsTo
     */
    public function subscribedUser()
    {
        return $this->belongsTo('\thimstory\Models\User', 'subscribed_user_id');
    }
}
