<?php

namespace Tests\Feature\Auth;

use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_unauthenticated_user_can_access_login_page(): void
    {
        $this->withoutVite();
        $this->get(route('login'))
            ->assertInertia(fn (Assert $page) => $page->component('Auth/Login'));
    }

    public function test_unauthenticated_user_cannot_visit_dashboard_route(): void
    {
        $response = $this->get('/');

        if (! auth()->check()) {
            $response->assertRedirect(route('dashboard'));
        }
    }
}
