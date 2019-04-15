<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;


class postTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testUserNotLoginGetAndSalvePost()
    {
        $response = $this->post('/getPosts', [
            'wordToSearch' => 'aaaaa'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function testGetAndSalvePost()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');

        $response = $this->post('/getPosts', [
            'wordToSearch' => 'UpLexis'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function testWordNotFoundGetAndSalvePost()
    {

        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');

        $response = $this->post('/getPosts', [
            'wordToSearch' => 'bbbbb'
        ]);


        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
        $response->assertSessionHasErrors(['getPostError' => 'Nenhum post encontrado']);

    }

    public function testErrorGetAndSalvePost()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');

        $response = $this->post('/getPosts',[
            'wordToSearch' => ' '
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
        $errors = session('errors');
        $response->assertSessionHasErrors();
        $this->assertEquals($errors->get('wordToSearch')[0],"Digite uma palavra");
    }

    public function testUserNotLoginDeletePost()
    {

        $response = $this->post('/deletePost', [
            'id' => 1
        ]);

        $response->assertStatus(404);

    }

    public function testErrorDeletePost()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');

        $response = $this->post('/deletePost', [
            'id' => 0
        ]);

        $response->assertStatus(404);
    }

}
