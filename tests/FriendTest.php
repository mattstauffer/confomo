<?php

use App\Conference;
use App\Friend;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FriendTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    public function test_it_can_be_marked_met()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->make();
        $user->conferences()->save($conference);

        $friend = factory(Friend::class)->make();
        $conference->onlineFriends()->save($friend);

        $this->assertFalse($friend->met);

        $friend->markMet();

        $pulledFriend = Friend::find($friend->id);

        $this->assertTrue($pulledFriend->met);
    }
}
