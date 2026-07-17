<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $allowedSorts = ['title', 'author_name', 'reviews_count', 'created_at'];
        $sort = in_array($request->query('sort'), $allowedSorts, true) ? $request->query('sort') : 'created_at';
        $direction = strtolower($request->query('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $query = Book::where('author_id', $request->user()->id)->withCount('reviews');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author_name', 'LIKE', "%{$search}%");
            });
        }

        $query->orderBy($sort, $direction);

        $books = $query->paginate(15);

        return view('author.books.index', compact('books'));
    }

    public function create()
    {
        return view('author.books.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
        ]);

        $data['author_id'] = $request->user()->id;

        Book::create($data);

        return redirect()->route('author.books.index')
            ->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        if ($book->author_id !== request()->user()->id) {
            abort(403, 'You can only edit your own books.');
        }

        return view('author.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        if ($book->author_id !== $request->user()->id) {
            abort(403, 'You can only edit your own books.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
        ]);

        $book->update($data);

        return redirect()->route('author.books.index')
            ->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->author_id !== request()->user()->id) {
            abort(403, 'You can only delete your own books.');
        }

        $book->delete();

        return redirect()->route('author.books.index')
            ->with('success', 'Book deleted successfully.');
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
        $count = Book::whereIn('id', $ids)->where('author_id', $userId)->delete();

        return redirect()->route('author.books.index')
            ->with('success', "{$count} book(s) deleted successfully.");
    }
}
