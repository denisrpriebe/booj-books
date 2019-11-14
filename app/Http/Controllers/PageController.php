<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class PageController extends Controller
{
    /**
     * Show the home page.
     *
     * @return Renderable
     */
    public function books()
    {
        return view('pages.books');
    }
}
