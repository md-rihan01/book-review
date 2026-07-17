@extends('layouts.app')

@section('content')

    <h1 class="mb-5 fs-2">Add Review for {{ $book->title }}</h1>

    <form method="POST" action="{{ route('books.reviews.store', $book) }}">
        @csrf

        <div class="mb-3">
            <label for="review" class="form-label fw-semibold">Review</label>
            <textarea name="review" id="review" class="form-control @error('review') is-invalid @enderror" rows="4"
                placeholder="Write your review here..." required>{{ old('review') }}</textarea>
            @error('review')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="rating" class="form-label fw-semibold">Rating</label>
            <select name="rating" id="rating" class="form-select @error('rating') is-invalid @enderror" required>
                <option value="">Select a Rating</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            @error('rating')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn-custom">
                Add Review
            </button>
        </div>
    </form>


@endsection