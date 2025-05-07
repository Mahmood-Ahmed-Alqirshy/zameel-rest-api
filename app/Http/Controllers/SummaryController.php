<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Book $book)
    {
        return response()->json(
            [
                'data' => $book->summaries()->first(),
            ]
        );
    }
}
