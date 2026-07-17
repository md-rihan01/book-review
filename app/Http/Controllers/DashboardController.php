<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = request()->user();

        if ($user->isAdmin()) {
            return view('admin.dashboard', [
                'totalUsers' => User::count(),
                'totalAdmins' => User::where('role', 'admin')->count(),
                'totalAuthors' => User::where('role', 'author')->count(),
                'totalSubscribers' => User::where('role', 'subscriber')->count(),
                'totalBooks' => Book::count(),
                'totalReviews' => Review::count(),
                'recentUsers' => User::latest()->take(5)->get(),
                'recentBooks' => Book::with('author')->latest()->take(5)->get(),
                'recentReviews' => Review::with('book', 'user')->latest()->take(5)->get(),
            ]);
        }

        if ($user->isAuthor()) {
            $bookIds = $user->books()->pluck('id');

            return view('admin.dashboard', [
                'myTotalBooks' => $user->books()->count(),
                'totalReviewsReceived' => Review::whereIn('book_id', $bookIds)->count(),
                'recentBooks' => $user->books()->latest()->take(5)->get(),
                'recentReviews' => Review::with('book', 'user')
                    ->whereIn('book_id', $bookIds)
                    ->latest()->take(5)->get(),
            ]);
        }

        return view('admin.dashboard', [
            'totalBooks' => Book::count(),
            'myTotalReviews' => $user->reviews()->count(),
            'recentReviews' => $user->reviews()->with('book')->latest()->take(5)->get(),
            'recentBooks' => Book::latest()->take(5)->get(),
        ]);
    }
}
