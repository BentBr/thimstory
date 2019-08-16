<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\Model;
use thimstory\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent;

class Subscriptions extends Model
{
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'storyId',
        'userId',
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
     * @return Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\thimstory\Models\User');
    }

    /**
     * @return Eloquent\Relations\BelongsTo
     */
    public function stories()
    {
        return $this->belongsTo('\thimstory\Models\Stories');
    }
}
