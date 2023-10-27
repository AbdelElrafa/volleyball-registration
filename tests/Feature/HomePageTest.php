<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_route_is_registered(): void
    {
        $this->get('/')->assertRedirect(route('signups.create'));
    }
}
