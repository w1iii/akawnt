<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', config('app.name'))</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
 
    <style>
        /* CSS Variables */
        :root {
            --ink:     #0d0d0d;
            --paper:   #ffffff;
            --accent:  #3181c8;
            --muted:   #60686b;
            --border:  #ccd7d9;
            --card-bg: #fdfaf5;
        }
 
        /* Base*/
        *, *::before, *::after { box-sizing: border-box; }
 
        html { scroll-behavior: smooth; }
 
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
            margin: 0;
            padding: 0;
        }

        main { flex: 1; }
 
        h1, h2, h3, h4, .display-font {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
        }

        /* Auth Layout */
        .auth-container {
            display: flex;
            min-height: 100vh;
            align-items: stretch;
        }

        .auth-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 4rem;
            background: linear-gradient(135deg, rgba(49, 129, 200, 0.05) 0%, rgba(182, 49, 200, 0.05) 100%);
        }

        .auth-left h1 {
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            line-height: 1.1;
            letter-spacing: -0.03em;
            margin-bottom: 1.5rem;
            color: var(--ink);
        }

        .auth-left p {
            font-size: 1.1rem;
            color: var(--muted);
            max-width: 480px;
            line-height: 1.7;
            margin: 0;
        }

        .auth-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            background: var(--paper);
        }

        .auth-form-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .auth-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        }

        .auth-card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--ink);
        }

        .auth-card .subtitle {
            font-size: 0.9rem;
            color: var(--muted);
            margin-bottom: 2rem;
        }

        .form-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 0.4rem;
        }

        .form-control {
            background: var(--paper);
            border: 1.5px solid var(--border);
            border-radius: 6px;
            color: var(--ink);
            font-size: 0.95rem;
            padding: 0.7rem 1rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            background: var(--paper);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(49, 129, 200, 0.1);
            color: var(--ink);
        }

        .form-control::placeholder { 
            color: var(--border); 
        }

        .btn-submit {
            width: 100%;
            background: var(--ink);
            color: var(--paper);
            border: none;
            padding: 0.85rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border-radius: 6px;
            transition: background 0.2s, transform 0.2s;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: var(--accent);
            color: #fff;
            transform: translateY(-2px);
        }

        .auth-divider {
            text-align: center;
            margin: 1.5rem 0;
            font-size: 0.85rem;
            color: var(--muted);
            position: relative;
        }

        .auth-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border);
            z-index: 1;
        }

        .auth-divider span {
            background: var(--card-bg);
            padding: 0 0.5rem;
            position: relative;
            z-index: 2;
        }

        .auth-footer {
            text-align: center;
            font-size: 0.9rem;
            margin-top: 1.5rem;
        }

        .auth-footer a {
            color: var(--accent);
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .auth-footer a:hover {
            opacity: 0.8;
        }

        .alert {
            border-radius: 8px;
            border: 1.5px solid;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.05);
            border-color: #dc3545;
            color: #721c24;
        }

        .alert ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .alert li {
            margin-bottom: 0.3rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .auth-container {
                flex-direction: column;
            }

            .auth-left {
                padding: 3rem 2rem;
                min-height: auto;
                border-bottom: 1.5px solid var(--border);
            }

            .auth-left h1 {
                font-size: clamp(2rem, 4vw, 3rem);
            }

            .auth-right {
                padding: 3rem 2rem;
            }
        }

        @media (max-width: 576px) {
            .auth-left,
            .auth-right {
                padding: 2rem 1.5rem;
            }

            .auth-card {
                padding: 1.75rem;
            }

            .auth-form-wrapper {
                max-width: 100%;
            }

            .auth-left h1 {
                font-size: clamp(1.75rem, 3vw, 2.5rem);
                margin-bottom: 1rem;
            }

            .auth-left p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
