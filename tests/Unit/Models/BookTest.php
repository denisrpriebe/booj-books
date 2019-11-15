<?php

namespace Tests\Unit\Models;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_belongs_to_one_user()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create(['user_id' => $user->id]);

        $this->assertTrue($book->user->is($user));
    }
}
