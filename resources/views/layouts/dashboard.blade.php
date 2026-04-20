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
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            color: var(--ink);
            font-size: 1rem;
            line-height: 1.65;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .dashboard-nav {
            background: var(--paper);
            border-bottom: 1.5px solid var(--border);
            padding: 1rem 0;
        }

        .dashboard-nav .navbar-brand {
            font-family: 'DM Sans', sans-serif;
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--ink) !important;
            letter-spacing: -0.03em;
        }

        .dashboard-nav .navbar-brand span { color: var(--accent); }

        .main-content {
            flex: 1;
            padding: 2rem 0;
        }

        footer {
            background: var(--ink);
            color: rgba(255,255,255,0.55);
            padding: 1.5rem 0;
            font-size: 0.85rem;
            margin-top: auto;
        }

        footer a { color: rgba(255,255,255,0.55); text-decoration: none; }
        footer a:hover { color: var(--accent); }
        .footer-brand {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            color: #fff;
        }
        .footer-brand span { color: var(--accent); }

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
        .dropdown-menu-end {
            right: 0;
            left: auto;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg dashboard-nav">
        <div class="container">
            @php
                $dashboardRoute = Auth::user()->role === 'admin' ? 'admin.dashboard' : 'applicant.dashboard';
            @endphp
            <a class="navbar-brand" href="{{ route($dashboardRoute) }}">Akaw<span>nt</span></a>

            <div class="dropdown user-dropdown ms-auto">
                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <span class="dropdown-item-text text-muted small">
                            {{ Auth::user()->email }}
                        </span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ Auth::user()->role === 'admin' ? route('admin.logout') : route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
            <form id="logout-form" action="{{ Auth::user()->role === 'admin' ? route('admin.logout') : route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="footer-brand">Akawnt</div>
                <div>&copy; {{ date('Y') }} Akawnt. All rights reserved.</div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
