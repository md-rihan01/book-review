@extends('layouts.admin')

@section('title', 'Reviews on My Books')

@section('content')
    <div class="page-header">
        <h2>Reviews on My Books</h2>
    </div>

    <div class="form-card mb-4">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small text-muted">Search</label>
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Search review content..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Book</label>
                <select name="book_id" class="form-select form-select-sm">
                    <option value="">All My Books</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                            {{ Str::limit($book->title, 40) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn-admin-primary btn-sm flex-fill">Filter</button>
                <a href="{{ route('author.reviews.index') }}" class="btn-admin-secondary btn-sm flex-fill d-flex align-items-center justify-content-center">Clear</a>
            </div>
            <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
        </form>
    </div>

    <div class="admin-table-wrapper">
        <table class="admin-data-table">
            <thead>
                <tr>
                    <th class="sno-column">S.No.</th>
                    <th><x-sortable-header label="Book" sort="book_id" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                    <th><x-sortable-header label="Reviewer" sort="user_id" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                    <th>Review</th>
                    <th><x-sortable-header label="Rating" sort="rating" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                    <th><x-sortable-header label="Date" sort="created_at" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td class="sno-column">{{ $reviews->firstItem() + $loop->index }}</td>
                        <td class="small fw-medium">{{ Str::limit($review->book->title, 30) }}</td>
                        <td class="text-muted small">{{ $review->user?->name ?? 'Unknown' }}</td>
                        <td class="small text-muted">{{ Str::limit($review->review, 60) }}</td>
                        <td><x-star-rating :rating="$review->rating" /></td>
                        <td class="text-muted small">{{ $review->created_at->format('M j, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No reviews found for your books.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-pagination">
        {{ $reviews->withQueryString()->links() }}
    </div>
@endsection
