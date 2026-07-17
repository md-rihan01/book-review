@extends('layouts.admin')

@section('title', 'My Books')

@section('content')
    <div class="page-header">
        <h2>My Books</h2>
        <a href="{{ route('author.books.create') }}" class="btn-admin-primary">
            <i class="bi bi-plus-circle"></i> Add New Book
        </a>
    </div>

    <div class="form-card mb-4">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-8">
                <label class="form-label small text-muted">Search</label>
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Search by title or author..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-admin-primary btn-sm w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('author.books.index') }}" class="btn-admin-secondary btn-sm w-100 d-block text-center">Clear</a>
            </div>
            <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
        </form>
    </div>

    <form method="POST" action="{{ route('author.books.bulk') }}" id="bulk-form">
        @csrf
        <x-bulk-actions :actions="['delete' => 'Delete Selected']" />

        <div class="admin-table-wrapper">
            <table class="admin-data-table">
                <thead>
                    <tr>
                        <th class="bulk-checkbox-column"><input type="checkbox" class="bulk-select-all" aria-label="Select all"></th>
                        <th class="sno-column">S.No.</th>
                        <th><x-sortable-header label="Title" sort="title" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                        <th><x-sortable-header label="Author Name" sort="author_name" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                        <th><x-sortable-header label="Reviews" sort="reviews_count" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                        <th><x-sortable-header label="Created" sort="created_at" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                        <th class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td class="bulk-checkbox-column">
                                <input type="checkbox" name="selected_ids[]" value="{{ $book->id }}"
                                    class="bulk-row-checkbox" aria-label="Select {{ $book->title }}">
                            </td>
                            <td class="sno-column">{{ $books->firstItem() + $loop->index }}</td>
                            <td class="fw-medium">{{ $book->title }}</td>
                            <td class="text-muted">{{ $book->author_name }}</td>
                            <td>{{ $book->reviews_count }}</td>
                            <td class="text-muted small">{{ $book->created_at->format('M j, Y') }}</td>
                            <td class="actions-column">
                                <div class="action-group" style="justify-content:flex-end;">
                                    <a href="{{ route('books.show', $book) }}" class="action-view" target="_blank">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('author.books.edit', $book) }}" class="action-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <button type="button" class="action-delete"
                                        onclick="confirmDelete('{{ route('author.books.destroy', $book) }}', 'Are you sure you want to delete &quot;{{ $book->title }}&quot;?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No books found. <a href="{{ route('author.books.create') }}">Create your first book</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($books->hasPages())
            <x-bulk-actions :actions="['delete' => 'Delete Selected']" :below="true" />
        @endif

        <div class="admin-pagination">
            {{ $books->withQueryString()->links() }}
        </div>
    </form>
@endsection
