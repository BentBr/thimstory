<?php

return [
    //interval between updates of stories in hours: max ~60 per year | 144h = 6d
    'hours_to_next_story_detail'    =>  env('HOURS_TO_NEXT_STORY_DETAIL', 144),

    //interval between new stories can be created in hours: max 5 per year | 1752h = 73d
    'hours_to_next_story'           =>  env('HOURS_TO_NEXT_STORY', 1752),
];
