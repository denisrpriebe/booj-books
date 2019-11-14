<?php

namespace Tests\Feature;

use Httpful\Request;
use Tests\TestCase;

class OpenLibraryTest extends TestCase
{
    /** @test */
    public function can_search_for_books_by_their_title()
    {
        $endpoint = 'https://openlibrary.org/search.json?title=the+lord+of+the+rings';

        $response = Request::get($endpoint)->send();

        $data = json_decode($response->body, true);

        $this->assertSame(200, $response->code);
        $this->assertSame('the lord of the rings', strtolower($data['docs'][0]['title']));
    }
}
