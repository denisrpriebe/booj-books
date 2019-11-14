<?php

namespace App\Domain\OpenLibrary;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class Book implements Arrayable
{
    /**
     * The Open Library ID of the book.
     *
     * @var string
     */
    public $olid;

    /**
     * The title of the book.
     *
     * @var string
     */
    public $title;

    /**
     * The author of the book.
     *
     * @var string
     */
    public $author;

    /**
     * The year the book was published.
     *
     * @var string
     */
    public $published;

    /**
     * Defines how to convert the book into an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'olid' => $this->olid,
            'title' => $this->title,
            'author' => $this->author,
            'published' => $this->published,
        ];
    }

    /**
     * Defines how to create a new "Book" with the given raw data from the API.
     *
     * @param array $data
     * @return Book
     */
    public static function createFromApi(array $data)
    {
        $book = new static;

        $book->olid = Arr::get($data, 'key', null);
        $book->title = Arr::get($data, 'title', 'Book title not found');
        $book->author = Arr::get($data, 'author_name.0', 'No author found');
        $book->published = Arr::get($data, 'first_publish_year', 'No publish year found');

        return $book;
    }

    /**
     * Defines how to create a collection of new "Books" with the given
     * raw data from the API.
     *
     * @param array $data
     * @return \Illuminate\Support\Collection
     */
    public static function createManyFromApi(array $data)
    {
        $bookCollection = collect();

        $books = Arr::get($data, 'docs', []);

        foreach ($books as $book) {
            $bookCollection->push(self::createFromApi($book));
        }

        return $bookCollection->take(7);
    }
}
