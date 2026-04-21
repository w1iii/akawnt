<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Akawnt - The Fiscal Atelier')</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                "colors": {
                    "inverse-surface": "#0b0f10",
                    "surface-tint": "#545f73",
                    "on-secondary-fixed-variant": "#4d5d73",
                    "outline-variant": "#a9b4b9",
                    "surface-container-highest": "#d9e4ea",
                    "on-primary-fixed": "#354053",
                    "on-secondary-fixed": "#314055",
                    "on-secondary-container": "#435368",
                    "secondary-container": "#d3e4fe",
                    "on-tertiary-container": "#002d47",
                    "surface-container-lowest": "#ffffff",
                    "secondary-fixed-dim": "#c5d6f0",
                    "tertiary-fixed": "#51b0f6",
                    "tertiary": "#006499",
                    "on-tertiary-fixed-variant": "#003655",
                    "inverse-primary": "#dae6fe",
                    "primary-fixed": "#d8e3fb",
                    "on-primary-fixed-variant": "#515c70",
                    "on-secondary": "#f7f9ff",
                    "on-tertiary": "#f6f9ff",
                    "on-tertiary-fixed": "#000d19",
                    "error-dim": "#4e0309",
                    "surface-variant": "#d9e4ea",
                    "secondary": "#506076",
                    "error-container": "#fe8983",
                    "primary-fixed-dim": "#cad5ed",
                    "on-surface": "#2a3439",
                    "on-primary-container": "#475266",
                    "tertiary-container": "#51b0f6",
                    "primary-dim": "#485367",
                    "secondary-dim": "#44546a",
                    "surface-bright": "#f7f9fb",
                    "tertiary-dim": "#005886",
                    "outline": "#717c82",
                    "surface": "#f7f9fb",
                    "secondary-fixed": "#d3e4fe",
                    "error": "#9f403d",
                    "on-background": "#2a3439",
                    "on-primary": "#f6f7ff",
                    "on-error": "#fff7f6",
                    "on-surface-variant": "#566166",
                    "inverse-on-surface": "#9a9d9f",
                    "surface-container": "#e8eff3",
                    "tertiary-fixed-dim": "#40a2e7",
                    "primary-container": "#d8e3fb",
                    "background": "#f7f9fb",
                    "surface-dim": "#cfdce3",
                    "on-error-container": "#752121",
                    "primary": "#545f73",
                    "surface-container-high": "#e1e9ee",
                    "surface-container-low": "#f0f4f7"
                },
                "fontFamily": {
                    "headline": ["Manrope"],
                    "body": ["Inter"],
                    "label": ["Inter"]
                }
            }
        }
    }
</script>
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    body {
        font-family: 'Inter', sans-serif;
    }
    h1, h2, h3, h4, h5, h6, .headline {
        font-family: 'Manrope', sans-serif;
    }
    .sidebar-link.active {
        background: white;
        color: #0d0d0d;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 700;
        border-radius: 0.5rem;
        transition: all 0.2s;
        cursor: pointer;
        border: none;
    }
    .button-primary {
        background-color: #545f73;
        color: #f6f7ff;
    }
    .button-primary:hover {
        background-color: #485367;
    }
    .button-secondary {
        background-color: #e8eff3;
        color: #2a3439;
    }
    .button-secondary:hover {
        background-color: #d9e4ea;
    }
    .button-success {
        background-color: #48bb78;
        color: white;
    }
    .button-success:hover {
        background-color: #38a169;
    }
    .button-danger {
        background-color: #e53e3e;
        color: white;
    }
    .button-danger:hover {
        background-color: #c53030;
    }
    .button-warning {
        background-color: #ed8936;
        color: white;
    }
    .button-warning:hover {
        background-color: #dd6b20;
    }
    .button-info {
        background-color: #3181c8;
        color: white;
    }
    .button-info:hover {
        background-color: #2b6cb0;
    }
</style>
</head>
<body class="text-on-surface bg-background">
<aside class="h-screen w-64 fixed left-0 top-0 bg-slate-100/50 flex flex-col p-6 font-headline tracking-tight z-50">
<div class="flex items-center gap-3 mb-8">
<div class="w-10 h-10 bg-primary flex items-center justify-center rounded-lg shadow-sm">
<span class="material-symbols-outlined text-on-primary">draw</span>
</div>
<div>
<h1 class="text-2xl font-bold tracking-tighter text-slate-800">Akawnt</h1>
<p class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant font-medium">The Fiscal Atelier</p>
</div>
</div>
<nav class="flex-1 space-y-1">
<a class="sidebar-link flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-700 hover:bg-slate-200/50 transition-colors duration-200 rounded-lg @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">
<span class="material-symbols-outlined">dashboard</span>
<span>Dashboard</span>
</a>
<a class="sidebar-link flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-700 hover:bg-slate-200/50 transition-colors duration-200 rounded-lg @if(request()->routeIs('admin.applications*')) active @endif" href="{{ route('admin.applications.index') }}">
<span class="material-symbols-outlined">assignment</span>
<span>Applications</span>
</a>
<a class="sidebar-link flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-700 hover:bg-slate-200/50 transition-colors duration-200 rounded-lg @if(request()->routeIs('admin.management*')) active @endif" href="{{ route('admin.management.index') }}">
<span class="material-symbols-outlined">admin_panel_settings</span>
<span>Admin Management</span>
</a>
<a class="sidebar-link flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-700 hover:bg-slate-200/50 transition-colors duration-200 rounded-lg @if(request()->routeIs('admin.accountants*')) active @endif" href="{{ route('admin.accountants.index') }}">
<span class="material-symbols-outlined">group</span>
<span>Accountants</span>
</a>
<a class="sidebar-link flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-700 hover:bg-slate-200/50 transition-colors duration-200 rounded-lg @if(request()->routeIs('admin.reports*')) active @endif" href="{{ route('admin.reports.index') }}">
<span class="material-symbols-outlined">description</span>
<span>Reports</span>
</a>
</nav>
<div class="pt-6 border-t border-slate-200 space-y-3">
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-700 hover:bg-slate-200/50 transition-colors duration-200 rounded-lg" href="#">
<span class="material-symbols-outlined">help_outline</span>
<span>Support</span>
</a>
<div class="flex items-center gap-3 px-4 py-3">
<div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center">
<span class="material-symbols-outlined text-primary">{{ substr(Auth::guard('admin')->user()->name ?? Auth::user()->name, 0, 1) }}</span>
</div>
<div class="overflow-hidden flex-1">
<p class="text-xs font-bold text-slate-900 truncate">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</p>
<p class="text-[10px] text-slate-500 truncate">Administrator</p>
</div>
</div>
<form method="POST" action="{{ route('admin.logout') }}">
@csrf
<button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors duration-200 rounded-lg">
<span class="material-symbols-outlined">logout</span>
<span>Logout</span>
</button>
</form>
</div>
</aside>
<main class="ml-64 min-h-screen">
<header class="fixed top-0 right-0 left-64 h-16 z-40 bg-slate-50/80 backdrop-blur-md flex items-center justify-between px-8 w-full">
<div class="flex items-center flex-1 max-w-xl">
<div class="relative w-full group">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">search</span>
<input class="w-full bg-surface-container-highest/50 border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-slate-200 transition-all outline-none" placeholder="Search applications, users..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-4 text-slate-500">
<button class="material-symbols-outlined hover:text-slate-900 transition-all">notifications</button>
<button class="material-symbols-outlined hover:text-slate-900 transition-all">apps</button>
</div>
<div class="h-8 w-px bg-slate-200 mx-2"></div>
<div class="flex items-center gap-3">
<span class="text-sm font-medium text-slate-900">{{ date('F Y') }}</span>
</div>
</div>
</div>
</header>
<div class="pt-24 pb-12 px-8">
@yield('content')
</div>
</main>
</body>
</html>