<?php

namespace Tests\Feature;

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('profile.edit'))->assertInertia(
            fn (Assert $page) => $page->
                component('Profile/Edit')->has('mustVerifyEmail')
        );
    }
}
