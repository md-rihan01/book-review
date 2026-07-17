@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h2>Dashboard</h2>
        <span class="text-muted">Welcome, {{ Auth::user()->name }}</span>
    </div>

    @if(Auth::user()->isAdmin())
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="bi bi-people"></i></div>
                    <div>
                        <div class="stat-number">{{ $totalUsers }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon purple"><i class="bi bi-shield-check"></i></div>
                    <div>
                        <div class="stat-number">{{ $totalAdmins }}</div>
                        <div class="stat-label">Admins</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="bi bi-pencil-square"></i></div>
                    <div>
                        <div class="stat-number">{{ $totalAuthors }}</div>
                        <div class="stat-label">Authors</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="bi bi-person-check"></i></div>
                    <div>
                        <div class="stat-number">{{ $totalSubscribers }}</div>
                        <div class="stat-label">Subscribers</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon orange"><i class="bi bi-book"></i></div>
                    <div>
                        <div class="stat-number">{{ $totalBooks }}</div>
                        <div class="stat-label">Total Books</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon teal"><i class="bi bi-star"></i></div>
                    <div>
                        <div class="stat-number">{{ $totalReviews }}</div>
                        <div class="stat-label">Total Reviews</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="form-card">
                    <h5 class="mb-3 fw-semibold">Recent Users</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead>
                        <tbody>
                            @foreach($recentUsers as $u)
                                <tr>
                                    <td>{{ $u->name }}</td>
                                    <td class="text-muted small">{{ $u->email }}</td>
                                    <td><span class="badge-role badge-{{ $u->role }}">{{ ucfirst($u->role) }}</span></td>
                                    <td class="text-muted small">{{ $u->created_at->format('M j, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('admin.users.index') }}" class="text-decoration-none small">View all users &rarr;</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-card">
                    <h5 class="mb-3 fw-semibold">Recent Reviews</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Book</th><th>Reviewer</th><th>Rating</th><th>Date</th></tr></thead>
                        <tbody>
                            @foreach($recentReviews as $r)
                                <tr>
                                    <td class="small">{{ Str::limit($r->book->title, 25) }}</td>
                                    <td class="text-muted small">{{ $r->user?->name ?? 'Unknown' }}</td>
                                    <td><x-star-rating :rating="$r->rating" /></td>
                                    <td class="text-muted small">{{ $r->created_at->format('M j') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('admin.reviews.index') }}" class="text-decoration-none small">View all reviews &rarr;</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-card">
                    <h5 class="mb-3 fw-semibold">Recent Books</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Title</th><th>Author</th><th>By</th><th>Date</th></tr></thead>
                        <tbody>
                            @foreach($recentBooks as $b)
                                <tr>
                                    <td class="small">{{ Str::limit($b->title, 30) }}</td>
                                    <td class="text-muted small">{{ $b->author_name }}</td>
                                    <td class="text-muted small">{{ $b->author?->name ?? 'N/A' }}</td>
                                    <td class="text-muted small">{{ $b->created_at->format('M j, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('admin.books.index') }}" class="text-decoration-none small">View all books &rarr;</a>
                </div>
            </div>
        </div>
    @elseif(Auth::user()->isAuthor())
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="bi bi-book"></i></div>
                    <div>
                        <div class="stat-number">{{ $myTotalBooks }}</div>
                        <div class="stat-label">My Books</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-icon teal"><i class="bi bi-star"></i></div>
                    <div>
                        <div class="stat-number">{{ $totalReviewsReceived }}</div>
                        <div class="stat-label">Reviews Received</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="form-card">
                    <h5 class="mb-3 fw-semibold">My Recent Books</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Title</th><th>Date</th></tr></thead>
                        <tbody>
                            @foreach($recentBooks as $b)
                                <tr>
                                    <td>{{ $b->title }}</td>
                                    <td class="text-muted small">{{ $b->created_at->format('M j, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('author.books.index') }}" class="text-decoration-none small">View my books &rarr;</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-card">
                    <h5 class="mb-3 fw-semibold">Recent Reviews on My Books</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Book</th><th>Rating</th><th>Date</th></tr></thead>
                        <tbody>
                            @foreach($recentReviews as $r)
                                <tr>
                                    <td class="small">{{ Str::limit($r->book->title, 30) }}</td>
                                    <td><x-star-rating :rating="$r->rating" /></td>
                                    <td class="text-muted small">{{ $r->created_at->format('M j') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('author.reviews.index') }}" class="text-decoration-none small">View all reviews &rarr;</a>
                </div>
            </div>
        </div>
    @else
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-icon orange"><i class="bi bi-book"></i></div>
                    <div>
                        <div class="stat-number">{{ $totalBooks }}</div>
                        <div class="stat-label">Available Books</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="bi bi-star"></i></div>
                    <div>
                        <div class="stat-number">{{ $myTotalReviews }}</div>
                        <div class="stat-label">My Reviews</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="form-card">
                    <h5 class="mb-3 fw-semibold">My Recent Reviews</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Book</th><th>Rating</th><th>Date</th></tr></thead>
                        <tbody>
                            @foreach($recentReviews as $r)
                                <tr>
                                    <td class="small">{{ Str::limit($r->book->title, 35) }}</td>
                                    <td><x-star-rating :rating="$r->rating" /></td>
                                    <td class="text-muted small">{{ $r->created_at->format('M j, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('subscriber.reviews.index') }}" class="text-decoration-none small">View my reviews &rarr;</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-card">
                    <h5 class="mb-3 fw-semibold">Recently Added Books</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Title</th><th>Author</th><th>Date</th></tr></thead>
                        <tbody>
                            @foreach($recentBooks as $b)
                                <tr>
                                    <td class="small">{{ Str::limit($b->title, 30) }}</td>
                                    <td class="text-muted small">{{ $b->author_name }}</td>
                                    <td class="text-muted small">{{ $b->created_at->format('M j, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('books.index') }}" class="text-decoration-none small">Browse books &rarr;</a>
                </div>
            </div>
        </div>
    @endif
@endsection
