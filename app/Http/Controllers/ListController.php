<?php

namespace App\Http\Controllers;

use App\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListController extends Controller
{
    /**
     * ListController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $books = $request->user()->books()->ordered()->get();

        return $books->isEmpty() ? response([], 204) : response($books, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $book = $request->user()->books()->create($request->all());

        return response($book, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Book $book
     * @return Response
     */
    public function update(Request $request, Book $book)
    {
        $book->update(['position' => $request->position]);

        return response($book, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return Response
     * @throws Exception
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response([], 200);
    }
}
