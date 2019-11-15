<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class PageController extends Controller
{
    /**
     * PageController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('list');
    }

    /**
     * Show the "Find Books" page.
     *
     * @return Renderable
     */
    public function books()
    {
        return view('pages.books');
    }

    /**
     * Show the user's list of books.
     *
     * @return Renderable
     */
    public function list()
    {
        return view('pages.list');
    }
}
