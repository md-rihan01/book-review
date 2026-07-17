@extends('layouts.app')

@section('content')

    <h1 class="mb-5 fs-2">Books</h1>

    <form action="{{ route('books.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-4">
        <input type="text" name="title" placeholder="Search by title" value="{{ request('title') }}" class="input-custom"
            style="height: 40px;">
        <input type="hidden" name="filter" value="{{ request('filter') }}">
        <button type="submit" class="btn-custom">Search</button>
        <a href="{{ route('books.index') }}" class="btn-custom">Clear</a>
    </form>

    <div class="filter-container mb-4 d-flex">
    @php
        $filters = [
            '' => 'Latest',
            'popular_last_month' => 'Popular Last Month',
            'popular_last_6months' => 'Popular Last 6 Months',
            'highest_rated_last_month' => 'Highest Rated Last Month',
            'highest_rated_last_6months' => 'Highest Rated Last 6 Months',
        ];
    @endphp

    @foreach ($filters as $key => $label)
        <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}" 
           class="{{ request('filter') === $key || (request('filter') === null && $key === '') 
                ? 'filter-item-active' 
                : 'filter-item' }}">
            {{ $label }}
        </a>
    @endforeach
</div>




    <ul class="list-unstyled">
        @forelse ($books as $book)
            <li class="mb-4">
                <div class="book-item">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
                            <span class="book-author">by {{ $book->author_name }}</span>
                        </div>
                        <div class="text-end">
                            <div class="book-rating">
                                {{-- {{ number_format($book->reviews_avg_rating, 1) }} --}}
                                <x-star-rating :rating="$book->reviews_avg_rating" />
                            </div>
                            <div class="book-review-count">
                                out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text mb-2">No books found</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
    <div class="books-pagination">
        {{ $books->links() }}
    </div>


@endsection