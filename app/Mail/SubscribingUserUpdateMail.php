<?php

namespace thimstory\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use thimstory\Models\Stories;
use thimstory\Models\User;

class SubscribingUserUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscribingUser, $updatedUser, $content, $story;

    /**
     * Create a new message instance.
     *
     * SubscribingUserUpdateMail constructor.
     * @param User $subscribingUser
     * @param User $updatedUser
     * @param $content
     * @param Stories $story
     */
    public function __construct(User $subscribingUser, User $updatedUser, $content, Stories $story)
    {
        $this->subscribingUser  = $subscribingUser;
        $this->updatedUser      = $updatedUser;
        $this->content          = $content;
        $this->story            = $story;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user-subscription-update');
    }
}
