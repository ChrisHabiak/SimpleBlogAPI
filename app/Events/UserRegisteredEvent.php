<?php

namespace App\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegisteredEvent implements ShouldQueue
{
    use SerializesModels,
        Dispatchable;

    /**
     * The authenticated user.
     *
     * @var App\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param App\Models\User $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }


}
