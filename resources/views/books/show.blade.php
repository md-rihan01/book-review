@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h1 class="sticky-top mb-2 fs-2">{{ $book->title }}</h1>

        <div class="book-info">
            <div class="book-author mb-3 fw-semibold fs-5">by {{ $book->author }}</div>
            <div class="book-rating d-flex align-items-center">
                <div class="me-2 text-secondary fw-medium">
                    {{-- {{ number_format($book->reviews_avg_rating, 1) }} --}}
                    <x-star-rating :rating="$book->reviews_avg_rating" />
                </div>
                <span class="book-review-count text-muted">
                    {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                </span>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <a href="{{ route('books.reviews.create', $book) }}" class="reset-link">
            Add a review!</a>
    </div>

    <div>
        <h2 class="mb-3 fs-4 fw-semibold">Reviews</h2>
        <ul class="list-unstyled">
            @forelse ($book->reviews as $review)
                <li class="book-item mb-3">
                    <div>
                        <div class="d-flex justify-content-between mb-2">
                            <div class="fw-semibold"><x-star-rating :rating="$review->rating" /></div>
                            <div class="book-review-count">
                                {{ $review->created_at->format('M j, Y') }}
                            </div>
                        </div>
                        <p class="text-secondary mb-0">{{ $review->review }}</p>
                    </div>
                </li>
            @empty
                <li class="mb-3">
                    <div class="empty-book-item">
                        <p class="empty-text fs-5 fw-semibold mb-0">No reviews yet</p>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
@endsection