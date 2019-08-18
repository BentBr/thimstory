<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent;
use Ramsey\Uuid\Uuid;
use thimstory\Models\Concerns\UsesUuid;
use thimstory\Models\Stories;

class StoryDetails extends Model
{
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'story_counter',
        'story_id,'
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

    /**
     * Retrieves Story Details (singular) for given story id and story counter
     *
     * @param $storyId
     * @param $storyCounter
     * @return mixed
     */
    public static function getStoryDetailsByStoryIdAndCounter($storyId, $storyCounter)
    {
        return StoryDetails::where('stories_id', $storyId)
            ->where('story_counter', $storyCounter)
            ->firstOrFail();
    }

    /**
     * Creates new story details with attachment to story. Adds mime type
     *
     * @param \thimstory\Models\Stories $story
     * @param $mimeType
     * @return bool
     */
    public function create(Stories $story, $mimeType)
    {
        //counting so later on correct storyDetail can be retrieved again
        $count = StoryDetails::where('stories_id', $story->id)->count();

        //create new storyDetails
        $this->stories_id = $story->id;
        $this->story_counter = $count;
        $this->mime_type = $mimeType;

        return $this->save();
    }

    public function updateStoryDetails()
    {

    }

    public function deleteStoryDetails()
    {

    }
}
