@extends('layouts.admin')

@section('title', 'My Reviews')

@section('content')
    <div class="page-header">
        <h2>My Reviews</h2>
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
                    <option value="">All Books</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                            {{ Str::limit($book->title, 40) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn-admin-primary btn-sm flex-fill">Filter</button>
                <a href="{{ route('subscriber.reviews.index') }}" class="btn-admin-secondary btn-sm flex-fill d-flex align-items-center justify-content-center">Clear</a>
            </div>
            <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
        </form>
    </div>

    <form method="POST" action="{{ route('subscriber.reviews.bulk') }}" id="bulk-form">
        @csrf
        <x-bulk-actions :actions="['delete' => 'Delete Selected']" />

        <div class="admin-table-wrapper">
            <table class="admin-data-table">
                <thead>
                    <tr>
                        <th class="bulk-checkbox-column"><input type="checkbox" class="bulk-select-all" aria-label="Select all"></th>
                        <th class="sno-column">S.No.</th>
                        <th><x-sortable-header label="Book" sort="book_id" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                        <th>Review</th>
                        <th><x-sortable-header label="Rating" sort="rating" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                        <th><x-sortable-header label="Date" sort="created_at" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                        <th class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td class="bulk-checkbox-column">
                                <input type="checkbox" name="selected_ids[]" value="{{ $review->id }}"
                                    class="bulk-row-checkbox" aria-label="Select review">
                            </td>
                            <td class="sno-column">{{ $reviews->firstItem() + $loop->index }}</td>
                            <td class="small fw-medium">{{ $review->book->title }}</td>
                            <td class="small text-muted">{{ Str::limit($review->review, 60) }}</td>
                            <td><x-star-rating :rating="$review->rating" /></td>
                            <td class="text-muted small">{{ $review->created_at->format('M j, Y') }}</td>
                            <td class="actions-column">
                                <div class="action-group" style="justify-content:flex-end;">
                                    <a href="{{ route('subscriber.reviews.edit', $review) }}" class="action-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <button type="button" class="action-delete"
                                        onclick="confirmDelete('{{ route('subscriber.reviews.destroy', $review) }}', 'Are you sure you want to delete this review?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">
                            You haven't written any reviews yet.
                            <a href="{{ route('books.index') }}" class="text-decoration-none">Browse books to review</a>.
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
            <x-bulk-actions :actions="['delete' => 'Delete Selected']" :below="true" />
        @endif

        <div class="admin-pagination">
            {{ $reviews->withQueryString()->links() }}
        </div>
    </form>
@endsection
