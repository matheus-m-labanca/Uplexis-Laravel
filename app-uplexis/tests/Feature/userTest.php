<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class userTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserNotLoginHome()
    {

        $response = $this->get('/home');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function testUserLoginHome()
    {
        $user = factory(User::class)->make();
        $this->actingAs($user)->get('/login');

        $response = $this->get('/home');

        $response->assertStatus(200);
    }

}
