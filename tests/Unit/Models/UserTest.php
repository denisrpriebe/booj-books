<?php

namespace Tests\Unit\Models;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_have_many_books_on_their_list()
    {
        $user = factory(User::class)->create();
        $bookA = factory(Book::class)->create(['user_id' => $user->id]);
        $bookB = factory(Book::class)->create(['user_id' => $user->id]);
        $bookC = factory(Book::class)->create();

        $this->assertSame(2, $user->books->count());
        $this->assertTrue($user->books->contains($bookA));
        $this->assertTrue($user->books->contains($bookB));
        $this->assertFalse($user->books->contains($bookC));
    }
}
