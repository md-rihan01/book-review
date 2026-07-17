<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $allowedSorts = ['book_id', 'user_id', 'rating', 'created_at'];
        $sort = in_array($request->query('sort'), $allowedSorts, true) ? $request->query('sort') : 'created_at';
        $direction = strtolower($request->query('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $query = Review::with('book', 'user');

        if ($search = $request->input('search')) {
            $query->where('review', 'LIKE', "%{$search}%");
        }

        if ($bookId = $request->input('book_id')) {
            $query->where('book_id', $bookId);
        }

        if ($rating = $request->input('rating')) {
            $query->where('rating', $rating);
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

        $books = Book::select('id', 'title')->get();

        return view('admin.reviews.index', compact('reviews', 'books'));
    }

    public function edit(Review $review)
    {
        $review->load('book', 'user');
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'review' => 'required|string|min:5',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->update($data);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }

    public function bulk(Request $request)
    {
        $action = $request->input('bulk_action');
        $ids = $request->input('selected_ids', []);

        if (!$action || !in_array($action, ['delete'])) {
            return back()->with('error', 'Invalid action selected.');
        }

        if (empty($ids)) {
            return back()->with('error', 'No items selected.');
        }

        $count = Review::whereIn('id', $ids)->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', "{$count} review(s) deleted successfully.");
    }
}
