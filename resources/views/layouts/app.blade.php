<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Book Reviews</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Custom classes to mimic Tailwind look */
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
  </style>
</head>

<body class="container my-5" style="max-width: 768px;">
  @yield('content')
</body>

</html>
