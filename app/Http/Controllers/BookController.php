<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    private $url;

    public function __construct()
    {
        $this->url = config('app.book_api');
    }

    public function newBooks()
    {
        $url = $this->url. '/new';
        $response = makeRequest([], $url, 'GET');

        if($response['error'] != '0') {
            return errorResponse(404, 'No books found');
        }
        return bookResourceResponse($response, 'Books returned successfully', 200);
    }

    public function searchBooks(BookRequest $request)
    {
        $url = $this->url. "/search/{$request->keyword}/{$request->page}";
        $response = makeRequest([], $url, 'GET');

        if($response['error'] != '0') {
            return errorResponse(404, 'No books found');
        }
        return bookResourceResponse($response, 'Books returned successfully', 200);
    }
}
