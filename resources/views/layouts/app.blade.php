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
        }

        main { flex: 1; }
 
        h1, h2, h3, h4, .display-font {
            font-family: 'DM Sans', sans-serif;
        }
 
/*  Navbar*/
        #mainNav {
            background: var(--paper);
            border-bottom: 1.5px solid var(--border);
            padding: 1rem 0;
            transition: box-shadow 0.3s;
        }
        #mainNav.scrolled {
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
        }
        .navbar-brand {
            font-family: 'DM Sans', sans-serif;
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--ink) !important;
            letter-spacing: -0.03em;
        }
        .navbar-brand span { color: var(--accent); }
  
        .nav-link {
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--muted) !important;
            padding: 0.4rem 1rem !important;
            transition: color 0.2s;
        }
        .nav-link:hover, .nav-link.active { color: var(--ink) !important; }
 
        .nav-cta {
            background: var(--accent);
            color: #fff !important;
            border-radius: 4px;
            padding: 0.4rem 1.2rem !important;
            transition: opacity 0.2s;
        }
        .nav-cta:hover { opacity: 0.88; color: #fff !important; }
 
        /*Sections */
        section { padding: 100px 0; }
 
        .section-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 1rem;
        }
 
        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.03em;
            margin-bottom: 1.5rem;
        }
 
        .section-divider {
            width: 48px;
            height: 3px;
            background: var(--accent);
            margin: 0 0 2rem;
        }
 
        /* Hero*/
        #home {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 80px;
            overflow: hidden;
        }
 
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
 
        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--accent);
            border: 1.5px solid var(--accent);
            border-radius: 100px;
            padding: 0.3rem 0.9rem;
            margin-bottom: 1.5rem;
        }
        .hero-eyebrow::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--accent);
        }
 
        .hero-title {
            font-size: clamp(3rem, 6vw, 5rem);
            font-weight: 800;
            line-height: 1.0;
            letter-spacing: -0.04em;
            margin-bottom: 1.5rem;
        }
        .hero-title em {
            font-style: normal;
            color: var(--accent);
        }
 
        .hero-sub {
            font-size: 1.1rem;
            color: var(--muted);
            max-width: 440px;
            margin-bottom: 2.5rem;
        }
 
        .btn-primary-custom {
            background: var(--ink);
            color: var(--paper);
            border: none;
            padding: 0.85rem 2rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border-radius: 4px;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s;
            display: inline-block;
        }
        .btn-primary-custom:hover {
            background: var(--accent);
            color: #fff;
            transform: translateY(-2px);
        }
 
        .btn-outline-custom {
            background: transparent;
            color: var(--ink);
            border: 1.5px solid var(--ink);
            padding: 0.85rem 2rem;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }
        .btn-outline-custom:hover {
            background: var(--ink);
            color: var(--paper);
            transform: translateY(-2px);
        }
 
        /* Hero Visual */
        .hero-visual {
            position: relative;
            height: 480px;
        }
        .hero-card {
            position: absolute;
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
        }
        .hero-card-main {
            width: 300px;
            top: 40px;
            right: 0;
            animation: float 5s ease-in-out infinite;
        }
        .hero-card-stat {
            width: 180px;
            bottom: 60px;
            left: 0;
            animation: float 5s ease-in-out infinite 1.5s;
        }
        .hero-card-badge {
            width: 160px;
            top: 200px;
            left: 40px;
            animation: float 4s ease-in-out infinite 0.8s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-12px); }
        }
        .stat-num {
            font-family: 'Syne', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--ink);
        }
        .stat-label { font-size: 0.78rem; color: var(--muted); }
        .avatar-stack { display: flex; margin-bottom: 0.75rem; }
        .avatar-stack img, .avatar-stack span {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 2px solid var(--paper);
            margin-right: -10px;
            object-fit: cover;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            background: var(--border);
            color: var(--ink);
        }
 
        /* Background blob */
        .blob {
            position: absolute;
            width: 420px; height: 420px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(182, 49, 200, 0.08) 0%, transparent 70%);
            right: -80px; top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }
 
        /* Stats bar */
        .stats-bar {
            background: var(--ink);
            padding: 2.5rem 0;
        }
        .stat-item { text-align: center; }
        .stat-item .num {
            font-family: 'Syne', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: #fff;
        }
        .stat-item .num span { color: var(--accent); }
        .stat-item .desc {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
 
        /*  About */
        #about { background: var(--paper); }
        .about-img-wrap {
            position: relative;
            height: 460px;
        }
        .about-img-main {
            position: absolute;
            inset: 0;
            background: var(--border);
            border-radius: 12px;
            overflow: hidden;
        }
        .about-img-main img {
            width: 100%; height: 100%;
            object-fit: cover;
        }
        .about-accent-box {
            position: absolute;
            bottom: -24px; right: -24px;
            width: 160px; height: 160px;
            background: var(--accent);
            border-radius: 8px;
            z-index: -1;
        }
 
        .feature-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.75rem;
        }
        .feature-icon {
            flex-shrink: 0;
            width: 44px; height: 44px;
            background: rgba(200,75,49,0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 1.1rem;
        }
        .feature-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }
        .feature-desc { font-size: 0.9rem; color: var(--muted); }
 
        /* Careers */
        #careers { background: #e3e7f0; }
        .job-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 1.75rem;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
            height: 100%;
        }
        .job-card:hover {
            transform: translateY(-4px);
            border-color: var(--accent);
            box-shadow: 0 8px 32px rgba(200,75,49,0.12);
        }
        .job-tag {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.25rem 0.65rem;
            border-radius: 100px;
            border: 1.5px solid var(--border);
            color: var(--muted);
            margin-bottom: 1rem;
        }
        .job-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .job-dept { font-size: 0.85rem; color: var(--muted); margin-bottom: 1.25rem; }
        .job-apply {
            font-family: 'Syne', sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--accent);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .job-apply i { transition: transform 0.2s; }
        .job-apply:hover i { transform: translateX(4px); }
 
        /*  Contact */
        #contact { background: var(--paper); }
        .contact-form-wrap {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 2.5rem;
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
        .form-control, .form-select {
            background: var(--paper);
            border: 1.5px solid var(--border);
            border-radius: 6px;
            color: var(--ink);
            font-size: 0.95rem;
            padding: 0.7rem 1rem;
            transition: border-color 0.2s;
        }
        .form-control:focus, .form-select:focus {
            background: var(--paper);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(200,75,49,0.1);
            color: var(--ink);
        }
        .form-control::placeholder { color: var(--border); }
 
        .contact-info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .contact-info-icon {
            flex-shrink: 0;
            width: 44px; height: 44px;
            background: rgba(200,75,49,0.1);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--accent);
            font-size: 1.1rem;
        }
        .contact-info-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
        }
        .contact-info-value { font-size: 0.95rem; color: var(--ink); }
 
        /* Footer */
        footer {
            background: var(--ink);
            color: rgba(255,255,255,0.55);
            padding: 2rem 0;
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
 
        /* Util */
        @media (max-width: 767px) {
            .hero-grid { grid-template-columns: 1fr; }
            .hero-visual { display: none; }
            section { padding: 70px 0; }
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
        // Navbar shadow on scroll
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 20);
        });
  
        // Active nav link on scroll (Scrollspy-lite)
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(l => l.classList.remove('active'));
                    const active = document.querySelector(`.nav-link[href="#${entry.target.id}"]`);
                    if (active) active.classList.add('active');
                }
            });
        }, { threshold: 0.4 });
        sections.forEach(s => observer.observe(s));

        // Scroll to contact on form submit
        @if(session('scroll_to'))
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('{{ session('scroll_to') }}').scrollIntoView({ behavior: 'smooth' });
            });
        @endif
    </script>
</html>