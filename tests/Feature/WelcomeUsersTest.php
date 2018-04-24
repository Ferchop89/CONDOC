<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{
    public function testBasicTest()
    {
        $response = $this->get('/home');

        $response->assertStatus(302);
    }
}
