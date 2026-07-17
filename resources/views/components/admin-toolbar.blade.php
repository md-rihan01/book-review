@auth
<header class="fe-toolbar" id="feToolbar">
    <div class="fe-toolbar-inner">
        <div class="fe-toolbar-left">
            <a href="{{ route('books.index') }}" class="fe-toolbar-brand">
                <i class="bi bi-book-half"></i>
                <span>Book Review</span>
            </a>

            <div class="fe-toolbar-nav" id="feToolbarNav">
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>

                @if(Auth::user()->isAdmin())
                <a href="{{ route('books.index') }}"
                   class="{{ request()->routeIs('books.index') ? 'active' : '' }}">
                    <i class="bi bi-house"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('admin.books.index') }}"
                   class="{{ request()->routeIs('admin.books.*') && !request()->routeIs('admin.books.create') ? 'active' : '' }}">
                    <i class="bi bi-book"></i>
                    <span>Books</span>
                </a>
                <a href="{{ route('admin.reviews.index') }}"
                   class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    <span>Reviews</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                </a>
                @endif

                @if(Auth::user()->isAuthor())
                <a href="{{ route('books.index') }}"
                   class="{{ request()->routeIs('books.index') ? 'active' : '' }}">
                    <i class="bi bi-house"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('author.books.index') }}"
                   class="{{ request()->routeIs('author.books.*') && !request()->routeIs('author.books.create') ? 'active' : '' }}">
                    <i class="bi bi-book"></i>
                    <span>My Books</span>
                </a>
                <a href="{{ route('author.books.create') }}"
                   class="{{ request()->routeIs('author.books.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span>Add New Book</span>
                </a>
                <a href="{{ route('author.reviews.index') }}"
                   class="{{ request()->routeIs('author.reviews.*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    <span>Reviews</span>
                </a>
                @endif

                @if(Auth::user()->isSubscriber())
                <a href="{{ route('books.index') }}"
                   class="{{ request()->routeIs('books.index') ? 'active' : '' }}">
                    <i class="bi bi-house"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('books.index') }}"
                   class="{{ request()->routeIs('books.index') ? 'active' : '' }}">
                    <i class="bi bi-book"></i>
                    <span>Books</span>
                </a>
                <a href="{{ route('subscriber.reviews.index') }}"
                   class="{{ request()->routeIs('subscriber.reviews.*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    <span>My Reviews</span>
                </a>
                @endif

                <a href="{{ route('books.index') }}" class="visit-site-link">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>Visit Site</span>
                </a>
            </div>
        </div>

        <div class="fe-toolbar-right">
            <div class="fe-toolbar-user">
                <span class="fe-toolbar-avatar">
                    <i class="bi bi-person-circle"></i>
                </span>
                <span class="fe-toolbar-name">{{ Auth::user()->name }}</span>
                <span class="fe-toolbar-role badge-role badge-{{ Auth::user()->role }}">{{ ucfirst(Auth::user()->role) }}</span>
                <button class="fe-toolbar-dropdown-toggle" id="feUserDropdownBtn" onclick="toggleFeUserDropdown(event)">
                    <i class="bi bi-chevron-down small"></i>
                </button>
                <div class="fe-toolbar-dropdown" id="feUserDropdown">
                    <a href="{{ route('profile.show') }}"><i class="bi bi-person me-2"></i>Profile</a>
                    <div class="fe-dropdown-divider"></div>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                    </form>
                </div>
            </div>
            <button class="fe-toolbar-hamburger" id="feHamburger" onclick="toggleFeMobileNav(event)" aria-label="Menu">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>
</header>
@endauth
