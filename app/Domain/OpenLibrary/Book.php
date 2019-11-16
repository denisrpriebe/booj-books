<?php

namespace App\Domain\OpenLibrary;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
     * Defines how to create a new "Book" with the given raw data
     * from the API.
     *
     * @param array $data
     * @return Book
     */
    public static function createFromApi(array $data)
    {
        $olid = Arr::get($data, 'key', '');

        $book = new static;

        $book->olid = substr($olid, strpos($olid, 'OL'));
        $book->title = Arr::get($data, 'title', 'Book title not found');
        $book->author = Arr::get($data, 'author_name.0', null);
        $book->published = Arr::get($data, 'first_publish_year', null);

        return $book;
    }

    /**
     * Defines how to create a collection of new "Books" with raw
     * data from the API.
     *
     * @param array $data
     * @return Collection
     */
    public static function createManyFromApi(array $data)
    {
        $bookCollection = collect();

        $books = Arr::get($data, 'docs', []);

        foreach ($books as $book) {
            $bookCollection->push(self::createFromApi($book));
        }

        /*
         * Remove any books that do not have an author or publish
         * date and return only the top 7 books.
         */
        return $bookCollection->filter(function (Book $book) {
            return !is_null($book->author) && !is_null($book->published);
        })->take(7);
    }

    /**
     * Defines how to parse out additional details about a book with the
     * given raw data from the API.
     *
     * @param string $olid
     * @param array $data
     * @return array
     */
    public static function details(string $olid, array $data)
    {
        $rawCover = Arr::get($data, 'covers.0', null);
        $rawDescription = Arr::get($data, 'description', 'No description available.');
        $onList = Auth::check() ? Auth::user()->books()->where('olid', $olid)->exists() : false;

        $image = is_null($rawCover)
            ? asset('images/booj-logo.png')
            : 'http://covers.openlibrary.org/b/id/' . $rawCover . '-M.jpg';

        $description = Str::limit(is_array($rawDescription)
            ? array_pop($description)
            : $rawDescription, 550);

        return [
            'on_list' => $onList,
            'description' => $description,
            'image' => $image
        ];
    }
}
