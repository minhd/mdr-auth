<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserUITest extends TestCase
{
    /** @test */
    function the_user_can_see_the_login_page()
    {
        $this->get('/login')->assertStatus(200);
    }

    /** @test */
    function it_allows_anonymous_to_see_the_register_page()
    {
        $this->get('/register')->assertStatus(200);
    }

    // it_redirects_the_user_correctly_after_logging_in

}
