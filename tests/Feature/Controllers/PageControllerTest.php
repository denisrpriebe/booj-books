<?php

namespace Tests\Feature\Controllers;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_books_page()
    {
        $response = $this->get('/books');

        $response->assertStatus(200);
        $response->assertSee('Booj Books');
    }

    /** @test */
    public function it_shows_the_list_page()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/list');

        $response->assertStatus(200);
        $response->assertSee('Booj Books');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_access_the_list_page()
    {
        $response = $this->get('/list');

        $response->assertStatus(302);
    }
}
