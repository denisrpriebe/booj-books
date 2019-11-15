<?php

namespace Tests\Feature\Controllers;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_a_listing_of_books_for_a_user()
    {
        $user = factory(User::class)->create();
        $bookA = factory(Book::class)->create(['user_id' => $user->id]);
        $bookB = factory(Book::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/api/list');

        $response->assertStatus(200);
        $response->assertJsonFragment($bookA->toArray());
        $response->assertJsonFragment($bookB->toArray());
    }

    /** @test */
    public function it_can_store_a_new_book_on_a_users_list()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->make(['user_id' => $user->id]);

        $this->assertDatabaseMissing('books', $book->toArray());

        $response = $this->actingAs($user)->post('/api/list', $book->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', $book->toArray());
    }

    /** @test */
    public function it_can_update_the_position_of_a_book_in_a_list()
    {
        $user = factory(User::class)->create();
        $bookA = factory(Book::class)->create(['user_id' => $user->id, 'position' => 1]);
        $bookB = factory(Book::class)->create(['user_id' => $user->id, 'position' => 2]);

        $response = $this->actingAs($user)->put('/api/list/' . $bookA->olid, [
            'position' => 3
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', [
            'user_id' => $user->id,
            'olid' => $bookA->olid,
            'position' => 3
        ]);
        $this->assertDatabaseHas('books', [
            'user_id' => $user->id,
            'olid' => $bookB->olid,
            'position' => 2
        ]);
    }

    /** @test */
    public function it_can_delete_a_book_from_a_users_list()
    {
        $user = factory(User::class)->create();
        $bookA = factory(Book::class)->create(['user_id' => $user->id]);
        $bookB = factory(Book::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete('/api/list/' . $bookA->olid);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', $bookA->toArray());
        $this->assertDatabaseHas('books', $bookB->toArray());
    }
}
