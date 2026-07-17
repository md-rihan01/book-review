@extends('layouts.admin')

@section('title', 'Add Book')

@section('content')
    <div class="page-header">
        <h2>Add New Book</h2>
        <a href="{{ route('author.books.index') }}" class="btn-admin-secondary">
            <i class="bi bi-arrow-left"></i> Back to My Books
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('author.books.store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Author Name</label>
                    <input type="text" name="author_name" class="form-control @error('author_name') is-invalid @enderror"
                        value="{{ old('author_name') }}" required>
                    @error('author_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn-admin-primary">
                    <i class="bi bi-check-lg"></i> Create Book
                </button>
            </div>
        </form>
    </div>
@endsection
