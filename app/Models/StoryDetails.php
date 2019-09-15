<?php

namespace thimstory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use thimstory\Events\NewStoryOrDetail;
use thimstory\Models\Concerns\UsesUuid;

class StoryDetails extends Model
{
    use UsesUuid;
    use SoftDeletes;

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
        $count = StoryDetails::where('stories_id', $story->id)->withTrashed()->count();

        //create new storyDetails
        $this->stories_id = $story->id;
        $this->story_counter = $count;
        $this->mime_type = $mimeType;

        if ($this->save()) {

            //adding new update event
            event(new NewStoryOrDetail( $story->user, $story,'newStoryDetail'));

            return true;

        } else {
            return false;
        }
    }

    /**
     * updates given story details mime type due to non-changing uuid.
     * updated_at is being changed anyways (even if mime type is same)
     *
     * @param $mimeType
     * @return bool
     */
    public function updateStoryDetails($mimeType)
    {
        $this->touch();

        return $this->update([
                'mime_type' => $mimeType,
            ]);
    }

    /**
     * (soft) deleted story details
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deleteStoryDetails()
    {
        //deletes this detail
        return $this->delete();
    }

    /**
     * Adding +1 to view counter of respected story detail
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
