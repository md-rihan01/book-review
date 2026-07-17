<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Reviews</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    /* Badge styles for toolbar */
    .badge-role {
      display: inline-block;
      padding: 2px 8px;
      border-radius: 10px;
      font-size: 0.7rem;
      font-weight: 500;
      line-height: 1.4;
    }
    .badge-admin { background: rgba(123, 74, 184, 0.25); color: #c8a8f0; }
    .badge-author { background: rgba(34, 113, 177, 0.25); color: #72aee6; }
    .badge-subscriber { background: rgba(0, 163, 42, 0.25); color: #68de7c; }

    /* ─── Frontend Admin Toolbar ─── */
    .fe-toolbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 44px;
      background: #1d2327;
      color: #f0f0f1;
      z-index: 99999;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      font-size: 0.8125rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.3);
      display: flex;
      align-items: center;
    }

    .fe-toolbar-inner {
      display: flex;
      align-items: center;
      width: 100%;
      max-width: 100%;
      padding: 0 12px;
      height: 100%;
    }

    .fe-toolbar-left {
      display: flex;
      align-items: center;
      gap: 4px;
      flex: 1;
      min-width: 0;
    }

    .fe-toolbar-brand {
      display: flex;
      align-items: center;
      gap: 6px;
      color: #f0f0f1;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.85rem;
      padding: 6px 10px;
      border-radius: 4px;
      white-space: nowrap;
    }
    .fe-toolbar-brand:hover { color: #72aee6; }

    .fe-toolbar-nav {
      display: flex;
      align-items: center;
      gap: 2px;
      flex-wrap: nowrap;
      overflow-x: auto;
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
    .fe-toolbar-nav::-webkit-scrollbar { display: none; }

    .fe-toolbar-nav a {
      display: flex;
      align-items: center;
      gap: 5px;
      color: #c3c4c7;
      text-decoration: none;
      padding: 6px 10px;
      border-radius: 4px;
      white-space: nowrap;
      font-size: 0.8125rem;
      transition: background 0.15s, color 0.15s;
    }
    .fe-toolbar-nav a:hover { background: #2c3338; color: #72aee6; }
    .fe-toolbar-nav a.active { background: #2271b1; color: #fff; }
    .fe-toolbar-nav a.visit-site-link {
      margin-left: 4px;
      border-left: 1px solid #3c434a;
      padding-left: 14px;
      border-radius: 0;
    }
    .fe-toolbar-nav a.visit-site-link:hover { background: transparent; color: #72aee6; }

    .fe-toolbar-nav a i { font-size: 0.9rem; }
    .fe-toolbar-nav a span { line-height: 1; }

    /* Right side */
    .fe-toolbar-right {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-shrink: 0;
      margin-left: auto;
    }

    .fe-toolbar-user {
      display: flex;
      align-items: center;
      gap: 6px;
      position: relative;
      padding: 4px 8px;
      border-radius: 4px;
      cursor: pointer;
    }
    .fe-toolbar-user:hover { background: #2c3338; }

    .fe-toolbar-avatar {
      font-size: 1.1rem;
      line-height: 1;
      color: #c3c4c7;
    }
    .fe-toolbar-name {
      font-weight: 500;
      color: #f0f0f1;
      max-width: 120px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    .fe-toolbar-role {
      display: none;
    }
    .fe-toolbar-dropdown-toggle {
      background: none;
      border: none;
      color: #c3c4c7;
      cursor: pointer;
      padding: 0;
      font-size: 0.75rem;
      line-height: 1;
    }

    /* Dropdown */
    .fe-toolbar-dropdown {
      position: absolute;
      top: 100%;
      right: 0;
      margin-top: 4px;
      background: #fff;
      border: 1px solid #dcdcde;
      border-radius: 4px;
      box-shadow: 0 3px 12px rgba(0,0,0,0.15);
      min-width: 180px;
      display: none;
      z-index: 100000;
      padding: 4px 0;
    }
    .fe-toolbar-dropdown.show { display: block; }

    .fe-toolbar-dropdown a,
    .fe-toolbar-dropdown form button {
      display: block;
      width: 100%;
      padding: 7px 14px;
      color: #3c434a;
      text-decoration: none;
      font-size: 0.8125rem;
      background: none;
      border: none;
      text-align: left;
      cursor: pointer;
    }
    .fe-toolbar-dropdown a:hover,
    .fe-toolbar-dropdown form button:hover {
      background: #f0f0f1;
      color: #1d2327;
    }
    .fe-dropdown-divider {
      height: 1px;
      background: #dcdcde;
      margin: 4px 0;
    }

    /* Hamburger */
    .fe-toolbar-hamburger {
      display: none;
      background: none;
      border: none;
      color: #f0f0f1;
      font-size: 1.3rem;
      cursor: pointer;
      padding: 4px 6px;
      border-radius: 4px;
    }
    .fe-toolbar-hamburger:hover { background: #2c3338; }

    /* Push page content down */
    body.has-toolbar {
      padding-top: calc(44px + 1.5rem) !important;
      margin-top: 0 !important;
    }

    /* ─── Mobile ─── */
    @media (max-width: 768px) {
      .fe-toolbar-nav {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #1d2327;
        flex-direction: column;
        padding: 8px 0;
        border-top: 1px solid #3c434a;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        max-height: calc(100vh - 44px);
        overflow-y: auto;
      }
      .fe-toolbar-nav.mobile-open { display: flex; }

      .fe-toolbar {
        height: 44px;
        position: fixed;
      }
      .fe-toolbar-inner { position: relative; }

      .fe-toolbar-nav a {
        padding: 10px 16px;
        border-radius: 0;
        border-bottom: 1px solid #2c3338;
      }
      .fe-toolbar-nav a.visit-site-link {
        margin-left: 0;
        border-left: none;
        padding-left: 16px;
      }

      .fe-toolbar-hamburger { display: block; }

      .fe-toolbar-name { max-width: 80px; }

      .fe-toolbar-role { display: inline-block; }
    }

    @media (max-width: 480px) {
      .fe-toolbar-brand span { display: none; }
      .fe-toolbar-name { display: none; }
      .fe-toolbar-role { display: inline-block; }
    }

    /* ─── Original app styles ─── */
    .btn-custom {
      background-color: #fff;
      border-radius: .375rem;
      padding: .5rem 1rem;
      font-weight: 500;
      color: #64748b;
      box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .05);
      border: 1px solid rgba(51, 65, 85, .1);
      height: 40px;
    }

    .btn-custom:hover {
      background-color: #f8fafc;
    }

    .input-custom {
      box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .05);
      appearance: none;
      width: 100%;
      padding: .5rem .75rem;
      color: #334155;
      border: 1px solid #cbd5e1;
      border-radius: .375rem;
    }

    .filter-container {
      margin-bottom: 1rem;
      display: flex;
      gap: .5rem;
      border-radius: .375rem;
      background-color: #f1f5f9;
      padding: .5rem;
    }

    .filter-item {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: .375rem;
      padding: .5rem 1rem;
      text-align: center;
      font-size: .875rem;
      font-weight: 500;
      color: #64748b;
      background: transparent;
      border: none;
      width: 20%;
      text-decoration: none;
    }

    .filter-item-active {
      background-color: #fff;
      box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .05);
      color: #1e293b;
      width: 20%;
      border-radius: 10px;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      font-size: .875rem;
      font-weight: 500;
      text-decoration: none;
    }

    .book-item {
      font-size: .875rem;
      border-radius: .375rem;
      background-color: #fff;
      padding: 1rem;
      line-height: 1.5;
      color: #0f172a;
      box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .05);
      border: 1px solid rgba(51, 65, 85, .1);
    }

    .book-title {
      font-size: 1.125rem;
      font-weight: 600;
      color: #1e293b;
      text-decoration: none;
    }

    .book-title:hover {
      color: #475569;
    }

    .book-author {
      display: block;
      color: #475569;
    }

    .book-rating {
      font-size: .875rem;
      font-weight: 500;
      color: #334155;
    }

    .book-review-count {
      font-size: .75rem;
      color: #64748b;
    }

    .empty-book-item {
      font-size: .875rem;
      border-radius: .375rem;
      background-color: #fff;
      padding: 2.5rem 1rem;
      text-align: center;
      line-height: 1.5;
      color: #0f172a;
      box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .05);
      border: 1px solid rgba(51, 65, 85, .1);
    }

    .empty-text {
      font-weight: 500;
      color: #64748b;
    }

    .reset-link {
      color: #64748b;
      text-decoration: underline;
    }
    .books-pagination .pagination .page-item.active .page-link,
    .reviews-pagination .pagination .page-item.active .page-link {
      background-color: #64748b;
      border-color: #64748b;
      color: #ffffff;
    }
    .books-pagination .pagination .page-item .page-link,
    .reviews-pagination .pagination .page-item .page-link {
      color: #64748b;
    }

  </style>
</head>

<body class="container my-5{{ Auth::check() ? ' has-toolbar' : '' }}" style="max-width: 768px;">

  @include('components.admin-toolbar')

  @yield('content')

  <script>
    function toggleFeUserDropdown(e) {
      e.stopPropagation();
      document.getElementById('feUserDropdown').classList.toggle('show');
    }
    function toggleFeMobileNav(e) {
      e.stopPropagation();
      document.getElementById('feToolbarNav').classList.toggle('mobile-open');
    }
    document.addEventListener('click', function() {
      var dd = document.getElementById('feUserDropdown');
      if (dd) dd.classList.remove('show');
      var nav = document.getElementById('feToolbarNav');
      if (nav) nav.classList.remove('mobile-open');
    });
  </script>
</body>

</html>
