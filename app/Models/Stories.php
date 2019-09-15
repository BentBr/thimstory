<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use thimstory\Events\NewStoryOrDetail;
use thimstory\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent;

class Stories extends Model
{
    use SoftDeletes;
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId',
        'name',
        'url_name',
        'views',
        'follower',
    ];

    /**
     * @return Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\thimstory\Models\User');
    }

    /**
     * @return Eloquent\Relations\HasMany
     */
    public function storyDetails()
    {
        return $this->HasMany('\thimstory\Models\StoryDetails');
    }

    public static function getStoryByUrlName($userId, $story)
    {
        return Stories::where('user_id', $userId)
            ->where('name', $story)
            ->firstOrFail();
    }

    /**
     * Creates a new story based on given name and User
     *
     * @param $name
     * @param User $user
     * @return bool
     */
    public function create($name, User $user)
    {
        //create new story
        $this->name     = $name;
        $this->user_id  = $user->id;
        $this->url_name = rawurlencode($name);

        if ($this->save()) {

            //adding new update event
            event(new NewStoryOrDetail( $user, $this,'newStory'));

            return true;

        } else {
            return false;
        }
    }

    /**
     * Updates story according to new data
     *
     * @param $name
     * @param User $user
     * @return bool
     */
    public function updateStory($name)
    {
        //update story
        return $this->update([
            'name'      => $name,
            'url_name'  => rawurlencode($name),
        ]);
    }

    /**
     * Deletes story according to new data
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deleteStory()
    {
        //delete story
        return $this->delete();
    }

    /**
     * Adding +1 to view counter of respected story
     *
     * @return bool
     */
    public function addViewCounterPlusOne()
    {
        $this->views++;
        $this->timestamps = false;

        return $this->update([
                'view'  => $this->views,
            ]);
    }
}
