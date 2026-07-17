@extends('layouts.admin')

@section('title', 'Edit Review')

@section('content')
    <div class="page-header">
        <h2>Edit Review</h2>
        <a href="{{ route('admin.reviews.index') }}" class="btn-admin-secondary">
            <i class="bi bi-arrow-left"></i> Back to Reviews
        </a>
    </div>

    <div class="form-card">
        <div class="mb-4 p-3 bg-light rounded">
            <div class="row g-3">
                <div class="col-md-6">
                    <strong>Book:</strong> {{ $review->book->title }}
                </div>
                <div class="col-md-6">
                    <strong>User:</strong> {{ $review->user?->name ?? 'Unknown' }}
                </div>
                <div class="col-md-6">
                    <strong>Current Rating:</strong> <x-star-rating :rating="$review->rating" />
                </div>
                <div class="col-md-6">
                    <strong>Date:</strong> {{ $review->created_at->format('M j, Y g:i A') }}
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.reviews.update', $review) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Review</label>
                <textarea name="review" rows="4" class="form-control @error('review') is-invalid @enderror" required>{{ old('review', $review->review) }}</textarea>
                @error('review') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Rating</label>
                <select name="rating" class="form-select @error('rating') is-invalid @enderror" required>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>
                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor
                </select>
                @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-admin-primary">
                <i class="bi bi-check-lg"></i> Update Review
            </button>
        </form>
    </div>
@endsection
