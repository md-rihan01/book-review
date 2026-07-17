<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Book Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-bg: #1d2327;
            --sidebar-hover: #2c3338;
            --sidebar-active: #2271b1;
            --sidebar-width: 260px;
            --sidebar-collapsed: 60px;
            --topbar-height: 54px;
            --content-bg: #f0f0f1;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: var(--content-bg);
            overflow-x: hidden;
        }

        /* Top Admin Bar */
        .admin-topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--topbar-height);
            background: #2c3338;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid #3c434a;
        }

        .admin-topbar .topbar-brand {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-topbar .topbar-brand:hover { color: #72aee6; }

        .admin-topbar .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar-user-dropdown {
            position: relative;
        }

        .topbar-user-dropdown .dropdown-toggle {
            color: #c3c4c7;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 0.9rem;
        }

        .topbar-user-dropdown .dropdown-toggle:hover {
            background: #3c434a;
            color: #fff;
        }

        .topbar-user-dropdown .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background: #fff;
            border: 1px solid #dcdcde;
            border-radius: 4px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.15);
            min-width: 200px;
            display: none;
            z-index: 1001;
            padding: 4px 0;
        }

        .topbar-user-dropdown .dropdown-menu.show { display: block; }

        .topbar-user-dropdown .dropdown-menu a,
        .topbar-user-dropdown .dropdown-menu form button {
            display: block;
            width: 100%;
            padding: 8px 16px;
            color: #3c434a;
            text-decoration: none;
            font-size: 0.875rem;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
        }

        .topbar-user-dropdown .dropdown-menu a:hover,
        .topbar-user-dropdown .dropdown-menu form button:hover {
            background: #f0f0f1;
            color: #1d2327;
        }

        .topbar-user-dropdown .dropdown-menu .dropdown-divider {
            height: 1px;
            background: #dcdcde;
            margin: 4px 0;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: var(--topbar-height);
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            z-index: 999;
            overflow-y: auto;
            overflow-x: hidden;
            transition: width 0.25s ease;
        }

        .admin-sidebar.collapsed { width: var(--sidebar-collapsed); }

        .admin-sidebar .sidebar-menu {
            list-style: none;
            padding: 8px 0;
        }

        .admin-sidebar .sidebar-menu li { position: relative; }

        .admin-sidebar .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: #c3c4c7;
            text-decoration: none;
            font-size: 0.875rem;
            transition: background 0.15s;
            white-space: nowrap;
        }

        .admin-sidebar .sidebar-menu a:hover { background: var(--sidebar-hover); color: #72aee6; }
        .admin-sidebar .sidebar-menu a.active { background: var(--sidebar-active); color: #fff; }

        .admin-sidebar .sidebar-menu a i {
            font-size: 1.1rem;
            min-width: 20px;
            text-align: center;
        }

        .admin-sidebar .sidebar-menu .menu-label { transition: opacity 0.2s; }

        .admin-sidebar.collapsed .sidebar-menu .menu-label { opacity: 0; visibility: hidden; }

        .admin-sidebar .sidebar-section-title {
            padding: 16px 16px 4px;
            color: #787c82;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .admin-sidebar.collapsed .sidebar-section-title { display: none; }

        /* Main Content */
        .admin-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 24px;
            min-height: calc(100vh - var(--topbar-height));
            transition: margin-left 0.25s ease;
        }

        .admin-sidebar.collapsed + .admin-content { margin-left: var(--sidebar-collapsed); }

        .admin-content .page-header {
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .admin-content .page-header h2 {
            font-size: 1.4rem;
            font-weight: 600;
            color: #1d2327;
            margin: 0;
        }

        /* Toggle button */
        .sidebar-toggle {
            background: none;
            border: none;
            color: #c3c4c7;
            font-size: 1.3rem;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .sidebar-toggle:hover { color: #fff; background: #3c434a; }

        /* Dashboard Cards */
        .stat-card {
            background: #fff;
            border: 1px solid #dcdcde;
            border-radius: 6px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: box-shadow 0.2s;
        }

        .stat-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.08); }

        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-card .stat-icon.blue { background: #e5f0ff; color: #2271b1; }
        .stat-card .stat-icon.green { background: #e0f5e0; color: #00a32a; }
        .stat-card .stat-icon.orange { background: #fef0d9; color: #dba617; }
        .stat-card .stat-icon.purple { background: #f0e6ff; color: #7b4ab8; }
        .stat-card .stat-icon.red { background: #fce8e8; color: #d63638; }
        .stat-card .stat-icon.teal { background: #e0f5f0; color: #00a0d2; }

        .stat-card .stat-number {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1d2327;
            line-height: 1.2;
        }

        .stat-card .stat-label {
            font-size: 0.85rem;
            color: #787c82;
        }

        /* Notices */
        .notice {
            padding: 12px 16px;
            border-radius: 4px;
            margin-bottom: 16px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notice-success { background: #edfaef; border: 1px solid #68de7c; color: #00450a; }
        .notice-error { background: #fcf0f1; border: 1px solid #fab7b7; color: #8a2424; }
        .notice-info { background: #f0f6fc; border: 1px solid #c5d9ed; color: #043959; }

        /* Tables */
        /* ─── Full-width table wrapper ─── */
        .admin-table-wrapper {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            background: #fff;
            border: 1px solid #dcdcde;
            border-radius: 6px;
        }

        .admin-data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            min-width: 700px;
        }

        .admin-data-table th {
            background: #f6f7f7;
            border-bottom: 1px solid #dcdcde;
            font-size: 0.8rem;
            font-weight: 600;
            color: #3c434a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            white-space: nowrap;
        }

        .admin-data-table td {
            padding: 12px 16px;
            font-size: 0.875rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f1;
        }

        .admin-data-table tr:last-child td { border-bottom: none; }

        .admin-data-table tr:hover td { background: #fafafa; }

        /* S.No. column */
        .admin-data-table .sno-column {
            width: 50px;
            text-align: center;
            color: #787c82;
            font-size: 0.8rem;
        }

        /* Actions column */
        .admin-data-table .actions-column {
            white-space: nowrap;
            text-align: right;
        }

        /* Sortable headers */
        .sortable-header {
            color: #3c434a;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            user-select: none;
        }
        .sortable-header:hover { color: #2271b1; }
        .sortable-header.active { color: #2271b1; }
        .sort-icon {
            font-size: 0.75rem;
            line-height: 1;
            opacity: 0.5;
        }
        .sortable-header.active .sort-icon,
        .sortable-header:hover .sort-icon { opacity: 1; }

        /* Badges */
        .badge-role {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-admin { background: #f0e6ff; color: #7b4ab8; }
        .badge-author { background: #e5f0ff; color: #2271b1; }
        .badge-subscriber { background: #e0f5e0; color: #00a32a; }

        .badge-status {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-published { background: #e0f5e0; color: #00a32a; }
        .badge-draft { background: #fef0d9; color: #dba617; }
        .badge-trash { background: #fce8e8; color: #d63638; }

        /* Forms */
        .form-card {
            background: #fff;
            border: 1px solid #dcdcde;
            border-radius: 6px;
            padding: 24px;
        }

        .form-card .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            color: #3c434a;
        }

        /* Pagination */
        .admin-pagination { margin-top: 20px; }
        .admin-pagination .pagination { margin-bottom: 0; }

        /* Buttons */
        .btn-admin-primary {
            background: #2271b1;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .btn-admin-primary:hover { background: #135e96; color: #fff; }

        .btn-admin-danger {
            background: #d63638;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .btn-admin-danger:hover { background: #b32d2e; color: #fff; }

        .btn-admin-secondary {
            background: #f0f0f1;
            color: #3c434a;
            border: 1px solid #dcdcde;
            padding: 8px 18px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .btn-admin-secondary:hover { background: #e5e5e5; color: #1d2327; }

        /* Search */
        .search-box {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .search-box input {
            padding: 8px 12px;
            border: 1px solid #dcdcde;
            border-radius: 4px;
            font-size: 0.875rem;
            min-width: 250px;
        }

        .search-box input:focus { border-color: #2271b1; outline: none; box-shadow: 0 0 0 1px #2271b1; }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show { display: flex; }

        .modal-box {
            background: #fff;
            border-radius: 6px;
            padding: 24px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }

        .modal-box h3 { margin-bottom: 12px; font-size: 1.1rem; }
        .modal-box p { color: #787c82; font-size: 0.9rem; margin-bottom: 20px; }
        .modal-box .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                width: var(--sidebar-collapsed);
            }

            .admin-sidebar .sidebar-menu .menu-label { opacity: 0; visibility: hidden; }

            .admin-content { margin-left: var(--sidebar-collapsed); }

            .admin-sidebar.mobile-open {
                width: var(--sidebar-width);
                box-shadow: 4px 0 12px rgba(0,0,0,0.15);
            }

            .admin-sidebar.mobile-open .sidebar-menu .menu-label {
                opacity: 1;
                visibility: visible;
            }

            .admin-sidebar.mobile-open + .sidebar-overlay {
                display: block;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: var(--topbar-height);
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.3);
                z-index: 998;
            }

            .admin-content .page-header { flex-direction: column; align-items: flex-start; }
            .search-box { width: 100%; }
            .search-box input { min-width: 0; flex: 1; }
        }

        @media (max-width: 576px) {
            .admin-content { padding: 16px; }
            .stat-card { padding: 16px; }
            .stat-card .stat-number { font-size: 1.3rem; }
            .table-container { overflow-x: auto; }
        }

        /* Quick action buttons in table */
        .action-group { display: flex; gap: 6px; flex-wrap: nowrap; }
        .action-group a, .action-group button {
            padding: 4px 10px;
            font-size: 0.8rem;
            border-radius: 3px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .action-edit { color: #2271b1; background: #f0f6fc; border: 1px solid #c5d9ed; }
        .action-edit:hover { background: #d4e4f7; }
        .action-delete { color: #d63638; background: #fcf0f1; border: 1px solid #fab7b7; cursor: pointer; }
        .action-delete:hover { background: #f8d7d8; }
        .action-view { color: #00a32a; background: #edfaef; border: 1px solid #68de7c; }
        .action-view:hover { background: #d8f0dc; }

        .filter-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-form select {
            padding: 6px 10px;
            border: 1px solid #dcdcde;
            border-radius: 4px;
            font-size: 0.85rem;
        }

        .img-thumb-preview {
            max-width: 60px;
            max-height: 60px;
            border-radius: 4px;
            object-fit: cover;
        }
        .pagination .page-item.active .page-link {
            background-color: #64748b;
            border-color: #64748b;
            color: #ffffff;
        }
        .pagination .page-item .page-link {
            color: #64748b;
        }

        /* ─── Bulk Actions ─── */
        .bulk-actions-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: #f6f7f7;
            border: 1px solid #dcdcde;
            border-bottom: none;
            border-radius: 6px 6px 0 0;
        }
        .bulk-actions-bar.below {
            border-top: none;
            border-bottom: 1px solid #dcdcde;
            border-radius: 0 0 6px 6px;
        }
        .bulk-actions-bar select {
            padding: 4px 28px 4px 8px;
            border: 1px solid #dcdcde;
            border-radius: 4px;
            font-size: 0.8125rem;
            color: #3c434a;
            background: #fff;
            min-width: 160px;
            cursor: pointer;
            appearance: auto;
        }
        .bulk-actions-bar .bulk-apply-btn {
            padding: 4px 14px;
            background: #2271b1;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 0.8125rem;
            cursor: pointer;
            font-weight: 500;
        }
        .bulk-actions-bar .bulk-apply-btn:hover { background: #135e96; }
        .bulk-actions-bar .bulk-apply-btn:disabled { opacity: 0.5; cursor: default; }

        .bulk-checkbox-column {
            width: 42px;
            text-align: center;
        }
        .bulk-row-checkbox,
        .bulk-select-all {
            cursor: pointer;
            width: 16px;
            height: 16px;
            margin: 0;
        }
    </style>
</head>
<body>

    <!-- Top Bar -->
    <header class="admin-topbar">
        <button class="sidebar-toggle d-md-none" onclick="toggleMobileSidebar()" aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>
        <button class="sidebar-toggle d-none d-md-block" onclick="toggleSidebar()" aria-label="Toggle sidebar">
            <i class="bi bi-layout-sidebar"></i>
        </button>
        <a href="{{ route('admin.dashboard') }}" class="topbar-brand ms-2">
            <i class="bi bi-book-half"></i> Book Reviews
        </a>

        <div class="topbar-right">
            <a href="{{ route('books.index') }}" class="text-decoration-none text-muted small" style="color:#c3c4c7!important;" title="View Site">
                <i class="bi bi-box-arrow-up-right"></i>
            </a>
            <div class="topbar-user-dropdown">
                <button class="dropdown-toggle" onclick="toggleDropdown(event)">
                    <i class="bi bi-person-circle"></i>
                    <span>{{ Auth::user()->name }}</span>
                    <i class="bi bi-chevron-down small"></i>
                </button>
                <div class="dropdown-menu">
                    <a href="{{ route('profile.show') }}"><i class="bi bi-person me-2"></i>Profile</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <ul class="sidebar-menu">

            @if(Auth::user()->isAdmin() || Auth::user()->isAuthor() || Auth::user()->isSubscriber())
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span class="menu-label">Dashboard</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->isAdmin())
            <li class="sidebar-section-title">Books</li>
            <li>
                <a href="{{ route('admin.books.index') }}" class="{{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                    <i class="bi bi-book"></i>
                    <span class="menu-label">All Books</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.books.create') }}" class="{{ request()->routeIs('admin.books.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span class="menu-label">Add New Book</span>
                </a>
            </li>
            <li class="sidebar-section-title">Reviews</li>
            <li>
                <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    <span class="menu-label">All Reviews</span>
                </a>
            </li>
            <li class="sidebar-section-title">Users</li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') && !request()->routeIs('admin.users.create') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span class="menu-label">All Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.create') }}" class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                    <i class="bi bi-person-plus"></i>
                    <span class="menu-label">Add New User</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->isAuthor())
            <li class="sidebar-section-title">Books</li>
            <li>
                <a href="{{ route('author.books.index') }}" class="{{ request()->routeIs('author.books.*') && !request()->routeIs('author.books.create') ? 'active' : '' }}">
                    <i class="bi bi-book"></i>
                    <span class="menu-label">My Books</span>
                </a>
            </li>
            <li>
                <a href="{{ route('author.books.create') }}" class="{{ request()->routeIs('author.books.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span class="menu-label">Add New Book</span>
                </a>
            </li>
            <li class="sidebar-section-title">Reviews</li>
            <li>
                <a href="{{ route('author.reviews.index') }}" class="{{ request()->routeIs('author.reviews.*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    <span class="menu-label">My Book Reviews</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->isSubscriber())
            <li class="sidebar-section-title">Books</li>
            <li>
                <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.index') ? 'active' : '' }}">
                    <i class="bi bi-book"></i>
                    <span class="menu-label">Browse Books</span>
                </a>
            </li>
            <li class="sidebar-section-title">Reviews</li>
            <li>
                <a href="{{ route('subscriber.reviews.index') }}" class="{{ request()->routeIs('subscriber.reviews.*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    <span class="menu-label">My Reviews</span>
                </a>
            </li>
            @endif

            <li class="sidebar-section-title">Profile</li>
            <li>
                <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person"></i>
                    <span class="menu-label">Profile</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="menu-label">Logout</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('auth.logout') }}" style="display:none;">@csrf</form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="admin-content" id="adminContent">
        @if(session('success'))
            <div class="notice notice-success">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="notice notice-error">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="notice notice-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <h3>Confirm Deletion</h3>
            <p id="deleteModalMessage">Are you sure you want to delete this item? This action cannot be undone.</p>
            <div class="modal-actions">
                <button type="button" class="btn-admin-secondary" onclick="closeDeleteModal()">Cancel</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-admin-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('collapsed');
        }

        function toggleMobileSidebar() {
            document.getElementById('adminSidebar').classList.toggle('mobile-open');
        }

        function toggleDropdown(event) {
            event.stopPropagation();
            const menu = event.currentTarget.nextElementSibling;
            menu.classList.toggle('show');
        }

        document.addEventListener('click', function() {
            document.querySelectorAll('.topbar-user-dropdown .dropdown-menu').forEach(m => m.classList.remove('show'));
        });

        function confirmDelete(url, message) {
            document.getElementById('deleteForm').action = url;
            if (message) document.getElementById('deleteModalMessage').textContent = message;
            document.getElementById('deleteModal').classList.add('show');
            return false;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        function handleBulkAction(btn) {
            var form = btn.closest('form');
            var action = form.querySelector('select[name="bulk_action"]').value;
            var checked = form.querySelectorAll('input[name="selected_ids[]"]:checked');

            if (!action) {
                alert('Please select a bulk action.');
                return false;
            }

            if (checked.length === 0) {
                alert('Please select at least one item.');
                return false;
            }

            var message = 'Are you sure you want to apply "' + action + '" to ' + checked.length + ' item(s)?';
            return confirm(message);
        }

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('bulk-select-all')) {
                var form = e.target.closest('form');
                var checkboxes = form.querySelectorAll('input[name="selected_ids[]"]');
                checkboxes.forEach(function(cb) { cb.checked = e.target.checked; });
            }
            if (e.target.matches('select[name="bulk_action"]')) {
                var form = e.target.closest('form');
                if (form) {
                    form.querySelectorAll('select[name="bulk_action"]').forEach(function(s) { s.value = e.target.value; });
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
