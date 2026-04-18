<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', config('app.name'))</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  
    <style>
        :root {
            --ink:     #0d0d0d;
            --paper:   #ffffff;
            --accent:  #3181c8;
            --muted:   #60686b;
            --border:  #ccd7d9;
            --card-bg: #fdfaf5;
            --sidebar-width: 240px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            color: var(--ink);
            font-size: 1rem;
            line-height: 1.65;
            overflow-x: hidden;
        }

        .dashboard-nav {
            background: var(--paper);
            border-bottom: 1.5px solid var(--border);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 100;
        }

        .dashboard-nav .navbar-brand {
            font-family: 'DM Sans', sans-serif;
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--ink) !important;
            letter-spacing: -0.03em;
        }

        .dashboard-nav .navbar-brand span { color: var(--accent); }

        .user-dropdown .dropdown-toggle::after { display: none; }
        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--ink);
            text-decoration: none;
        }
        .user-dropdown .dropdown-toggle:hover { color: var(--accent); }
        .user-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--ink);
            z-index: 101;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 70px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand a {
            font-family: 'DM Sans', sans-serif;
            font-weight: 800;
            font-size: 1.35rem;
            color: #fff !important;
            text-decoration: none;
            letter-spacing: -0.03em;
        }

        .sidebar-brand a span { color: var(--accent); }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav-item {
            margin: 0;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .sidebar-nav-link:hover,
        .sidebar-nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
        }

        .sidebar-nav-link i {
            font-size: 1.1rem;
            width: 20px;
        }

        .main-wrapper {
            margin-left: var(--sidebar-width);
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            display: flex;
            flex-direction: column;
        }

        .main-content {
            padding: 2rem;
            padding-top: 70px;
            flex: 1;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .page-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg dashboard-nav">
        <div class="container-fluid justify-content-end">
            <div class="dropdown user-dropdown">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <span class="d-none d-md-inline ms-2">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <span class="dropdown-item-text text-muted small">
                            {{ Auth::user()->email }}
                        </span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    <aside class="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('applicant.dashboard') }}">Akaw<span>nt</span></a>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ route('applicant.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('applicant.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('applicant.clients') }}" class="sidebar-nav-link {{ request()->routeIs('applicant.clients') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Clients</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('applicant.reports') }}" class="sidebar-nav-link {{ request()->routeIs('applicant.reports') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart"></i>
                    <span>Reports</span>
                </a>
            </li>
        </ul>
    </aside>

    <div class="main-wrapper">
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>