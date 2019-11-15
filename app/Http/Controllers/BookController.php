<?php

namespace App\Http\Controllers;

use App\Book;
use App\Domain\OpenLibrary\Api;
use Httpful\Exception\ConnectionErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * An instance of our Open Library API.
     *
     * @var Api
     */
    protected $api;

    /**
     * BookController constructor.
     *
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws ConnectionErrorException
     */
    public function index(Request $request)
    {
        $books = $this->api->search($request->search ?? '');

        return $books->isEmpty() ? response('', 204) : response($books, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param string $olid
     * @return Response
     * @throws ConnectionErrorException
     */
    public function show(string $olid)
    {
        $book = $this->api->book($olid);

        return response($book);
    }
}
