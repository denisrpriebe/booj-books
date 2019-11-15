<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_a_listing_of_books_from_open_library()
    {
        $response = $this->get('/api/books?search=the hobbit');

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'The Hobbit']);
    }

    /** @test */
    public function it_can_show_additional_details_about_a_book()
    {
        $response = $this->get('/api/books/OL262758W');

        $response->assertStatus(200);
        $response->assertSee('description');
        $response->assertSee('image');
        $response->assertSee('on_list');
        $response->assertDontSee('this_is_not_present');
    }
}
