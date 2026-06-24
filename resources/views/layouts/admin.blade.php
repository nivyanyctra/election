<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Voting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .candidate-card { cursor: pointer; transition: 0.3s; border: 4px solid transparent; }
        .candidate-card.selected { border-color: #198754; transform: translateY(-5px); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">E-VOTING</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('admin.candidates') }}">Candidates</a>
                <a class="nav-link" href="{{ route('admin.logs') }}">Logs</a>
            </div>
        </div>
    </nav>
    <div class="container">@yield('content')</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html>
