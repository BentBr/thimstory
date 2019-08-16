<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent;

class StoryDetails extends Model
{
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
