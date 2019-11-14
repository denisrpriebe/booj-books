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

        return Book::createManyFromApi($data);
    }
}
