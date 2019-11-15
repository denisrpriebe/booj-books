<?php

namespace App\Domain\OpenLibrary;

use Httpful\Exception\ConnectionErrorException;
use Httpful\Request;
use Illuminate\Support\Collection;

class Api
{
    /**
     * Search Open Library for a book that matches the given text.
     *
     * @param string $text
     * @return Collection
     * @throws ConnectionErrorException
     */
    public function search(string $text = '')
    {
        $query = str_replace(' ', '+', $text);

        $endpoint = 'https://openlibrary.org/search.json?q=' . $query;

        $response = Request::get($endpoint)->send();

        $data = json_decode($response->body, true);

        return Book::createManyFromApi($data ?? []);
    }

    /**
     * Get additional details about the book with the given Open
     * Library ID.
     *
     * @param string $olid
     * @return array
     * @throws ConnectionErrorException
     */
    public function book(string $olid)
    {
        $endpoint = 'https://openlibrary.org/works/' . $olid . '.json';

        $response = Request::get($endpoint)->send();

        $data = json_decode($response->raw_body, true);

        return Book::details($olid, $data);
    }
}
