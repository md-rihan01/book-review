<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $allowedSorts = ['book_id', 'rating', 'created_at'];
        $sort = in_array($request->query('sort'), $allowedSorts, true) ? $request->query('sort') : 'created_at';
        $direction = strtolower($request->query('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $query = Review::with('book')
            ->where('user_id', $request->user()->id);

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
        } else {
            $query->orderBy($sort, $direction);
        }

        $reviews = $query->paginate(15);

        $books = Book::select('id', 'title')->get();

        return view('subscriber.reviews.index', compact('reviews', 'books'));
    }

    public function edit(Review $review)
    {
        if ($review->user_id !== request()->user()->id) {
            abort(403, 'You can only edit your own reviews.');
        }

        $review->load('book');
        return view('subscriber.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id) {
            abort(403, 'You can only edit your own reviews.');
        }

        $data = $request->validate([
            'review' => 'required|string|min:5',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->update($data);

        return redirect()->route('subscriber.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== request()->user()->id) {
            abort(403, 'You can only delete your own reviews.');
        }

        $review->delete();

        return redirect()->route('subscriber.reviews.index')
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

        $userId = $request->user()->id;
        $count = Review::whereIn('id', $ids)->where('user_id', $userId)->delete();

        return redirect()->route('subscriber.reviews.index')
            ->with('success', "{$count} review(s) deleted successfully.");
    }
}
