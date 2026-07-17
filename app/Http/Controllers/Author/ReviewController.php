<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $allowedSorts = ['book_id', 'user_id', 'rating', 'created_at'];
        $sort = in_array($request->query('sort'), $allowedSorts, true) ? $request->query('sort') : 'created_at';
        $direction = strtolower($request->query('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $bookIds = $request->user()->books()->pluck('id');

        $query = Review::with('book', 'user')
            ->whereIn('book_id', $bookIds);

        if ($search = $request->input('search')) {
            $query->where('review', 'LIKE', "%{$search}%");
        }

        if ($bookId = $request->input('book_id')) {
            $query->where('book_id', $bookId);
        }

        if ($sort === 'book_id') {
            $query->join('books', 'reviews.book_id', '=', 'books.id')
                  ->orderBy('books.title', $direction)
                  ->select('reviews.*');
        } elseif ($sort === 'user_id') {
            $query->join('users', 'reviews.user_id', '=', 'users.id')
                  ->orderBy('users.name', $direction)
                  ->select('reviews.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $reviews = $query->paginate(15);

        $books = $request->user()->books()->select('id', 'title')->get();

        return view('author.reviews.index', compact('reviews', 'books'));
    }
}
