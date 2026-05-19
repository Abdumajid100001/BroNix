<!DOCTYPE html>
<html lang="ru" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookAI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        *{margin:0;padding:0;box-sizing:border-box}

        :root {
            --primary: #6366F1;
            --primary-light: #818CF8;
            --primary-dark: #4F46E5;
            --accent: #06D6A0;
            --warm: #F472B6;
            --gold: #FBBF24;
            --radius: 16px;
            --radius-lg: 24px;
            --transition: 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        [data-theme="light"] {
            --bg: #FAFBFF;
            --bg-card: #FFFFFF;
            --bg-soft: #F3F4F8;
            --bg-nav: rgba(250,251,255,0.85);
            --text: #0F172A;
            --text-mid: #475569;
            --text-light: #94A3B8;
            --border: #E2E8F0;
            --border-light: #F1F5F9;
            --shadow: 0 4px 20px rgba(0,0,0,0.06);
            --shadow-lg: 0 12px 40px rgba(0,0,0,0.08);
            --shadow-xl: 0 20px 60px rgba(0,0,0,0.12);
            --chart-grid: rgba(0,0,0,0.06);
            --chart-text: #94A3B8;
            --hero-card-bg: #FFFFFF;
        }

        [data-theme="dark"] {
            --bg: #0B0F1A;
            --bg-card: #141929;
            --bg-soft: #0F1424;
            --bg-nav: rgba(11,15,26,0.92);
            --text: #F1F5F9;
            --text-mid: #CBD5E1;
            --text-light: #64748B;
            --border: #1E293B;
            --border-light: #161D2F;
            --shadow: 0 4px 20px rgba(0,0,0,0.3);
            --shadow-lg: 0 12px 40px rgba(0,0,0,0.4);
            --shadow-xl: 0 20px 60px rgba(0,0,0,0.5);
            --chart-grid: rgba(255,255,255,0.06);
            --chart-text: #64748B;
            --hero-card-bg: #141929;
        }

        html { scroll-behavior: smooth }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
            transition: background var(--transition), color var(--transition);
        }

        ::-webkit-scrollbar{width:6px}
        ::-webkit-scrollbar-track{background:var(--bg-soft)}
        ::-webkit-scrollbar-thumb{background:var(--primary);border-radius:3px}

        /* ========== NAVBAR ========== */
        .navbar {
            position: fixed; top:0; left:0; right:0; z-index:1000;
            padding: 0.75rem 2rem;
            display:flex; justify-content:space-between; align-items:center;
            background: var(--bg-nav);
            backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--border-light);
            transition: all var(--transition);
        }

        .logo {
            font-size:1.4rem; font-weight:900;
            background:linear-gradient(135deg,#6366F1,#06D6A0);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
            display:flex; align-items:center; gap:0.5rem; cursor:pointer;
            letter-spacing:-0.5px;
        }

        .logo-icon {
            width:36px; height:36px; border-radius:10px;
            background:linear-gradient(135deg,#6366F1,#06D6A0);
            display:flex; align-items:center; justify-content:center;
            color:#fff; font-size:0.9rem; -webkit-text-fill-color:#fff;
        }

        .nav-center {
            display:flex; align-items:center;
        }

        .nav-links { display:flex; list-style:none; gap:0.2rem; align-items:center }

        .nav-links a {
            text-decoration:none; color:var(--text-mid); font-weight:500;
            padding:0.55rem 1rem; border-radius:50px; transition:all 0.3s;
            font-size:0.9rem; cursor:pointer; white-space:nowrap;
        }

        .nav-links a:hover, .nav-links a.active {
            color:var(--primary); background:rgba(99,102,241,0.08);
        }

        .nav-right { display:flex; align-items:center; gap:0.5rem }

        .theme-toggle, .lang-toggle-btn {
            width:42px; height:42px; border-radius:12px;
            border:1.5px solid var(--border); background:var(--bg-card);
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; font-size:1rem; color:var(--text-mid);
            transition:all 0.3s;
        }

        .theme-toggle:hover, .lang-toggle-btn:hover { border-color:var(--primary); color:var(--primary); }

        .lang-toggle-btn { font-size:0.82rem; font-weight:700; font-family:'Inter',sans-serif; width:auto; padding:0 0.8rem; }

        .nav-cta {
            background:var(--primary) !important; color:#fff !important;
            padding:0.6rem 1.5rem !important; font-weight:600 !important;
            box-shadow:0 4px 15px rgba(99,102,241,0.3); border-radius:50px !important;
        }

        .nav-cta:hover {
            transform:translateY(-2px) !important;
            box-shadow:0 6px 25px rgba(99,102,241,0.4) !important;
            background:var(--primary-dark) !important;
        }

        .mobile-toggle {
            display:none; background:none; border:none;
            font-size:1.3rem; color:var(--text); cursor:pointer; padding:0.5rem;
        }

        /* ========== PAGES ========== */
        .page {
            min-height:100vh; padding-top:75px;
            display:none;
            animation: fadeIn 0.5s cubic-bezier(0.16,1,0.3,1);
        }

        .page.active { display:block }

        @keyframes fadeIn {
            from { opacity:0; transform:translateY(20px) }
            to { opacity:1; transform:translateY(0) }
        }

        .container { max-width:1200px; margin:0 auto; padding:3.5rem 2rem }

        .section-badge {
            display:inline-flex; align-items:center; gap:0.5rem;
            background:rgba(99,102,241,0.08); color:var(--primary);
            padding:0.45rem 1.1rem; border-radius:50px; font-size:0.8rem;
            font-weight:600; margin-bottom:1rem;
        }

        .section-header { text-align:center; margin-bottom:3.5rem }
        .section-header h2 {
            font-size:2.6rem; font-weight:800; margin-bottom:0.8rem;
            letter-spacing:-1px; line-height:1.15;
        }
        .section-header h2 span {
            background:linear-gradient(135deg,#6366F1,#06D6A0);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        }
        .section-header p {
            color:var(--text-light); font-size:1.1rem; max-width:550px; margin:0 auto;
        }

        /* ========== HOME PAGE ========== */
        .hero-section {
            min-height:calc(100vh - 75px);
            display:flex; align-items:center;
            position:relative; overflow:hidden;
        }

        .hero-bg-glow {
            position:absolute; border-radius:50%; filter:blur(120px);
            pointer-events:none;
        }
        .hero-glow-1 {
            width:500px; height:500px;
            background:rgba(99,102,241,0.12);
            top:-100px; right:-100px;
            animation:glowFloat 10s ease-in-out infinite;
        }
        .hero-glow-2 {
            width:400px; height:400px;
            background:rgba(6,214,160,0.08);
            bottom:-80px; left:-80px;
            animation:glowFloat 12s ease-in-out infinite reverse;
        }

        @keyframes glowFloat {
            0%,100%{transform:translate(0,0)}
            50%{transform:translate(30px,-20px)}
        }

        .hero-grid-bg {
            position:absolute; inset:0;
            background-image:
                linear-gradient(rgba(99,102,241,0.03) 1px,transparent 1px),
                linear-gradient(90deg,rgba(99,102,241,0.03) 1px,transparent 1px);
            background-size:60px 60px;
            mask-image:radial-gradient(ellipse at center,black 25%,transparent 70%);
            -webkit-mask-image:radial-gradient(ellipse at center,black 25%,transparent 70%);
        }

        .hero-content {
            position:relative; z-index:2;
            display:grid; grid-template-columns:1fr 1fr; gap:3rem; align-items:center;
            width:100%;
        }

        .hero-text h1 {
            font-size:3.2rem; font-weight:900; line-height:1.08;
            letter-spacing:-1.5px; margin-bottom:1.2rem;
        }
        .hero-text h1 .gradient-text {
            background:linear-gradient(135deg,#6366F1,#06D6A0);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        }
        .hero-text p {
            color:var(--text-light); font-size:1.1rem; line-height:1.7;
            margin-bottom:1.8rem; max-width:440px;
        }

        .btn {
            padding:0.9rem 2rem; border-radius:50px; border:none;
            font-weight:600; font-size:0.95rem; cursor:pointer;
            transition:all 0.3s; display:inline-flex; align-items:center;
            gap:0.5rem; font-family:'Inter',sans-serif; text-decoration:none;
        }
        .btn-primary {
            background:var(--primary); color:#fff;
            box-shadow:0 4px 20px rgba(99,102,241,0.3);
        }
        .btn-primary:hover {
            transform:translateY(-3px); box-shadow:0 8px 30px rgba(99,102,241,0.4);
            background:var(--primary-dark);
        }
        .btn-ghost {
            background:var(--bg-card); color:var(--text);
            border:1.5px solid var(--border);
        }
        .btn-ghost:hover {
            border-color:var(--primary); color:var(--primary);
            transform:translateY(-3px); box-shadow:var(--shadow-lg);
        }

        .hero-buttons { display:flex; gap:1rem; flex-wrap:wrap }

        /* Hero Right - Dashboard Preview */
        .hero-right { position:relative }

        .dashboard-preview {
            background: var(--hero-card-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            position: relative;
            z-index: 2;
            animation: dashboardFloat 6s ease-in-out infinite;
        }

        @keyframes dashboardFloat {
            0%,100%{transform:translateY(0)}
            50%{transform:translateY(-8px)}
        }

        .dash-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-light);
        }

        .dash-topbar-left {
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .dash-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366F1, #06D6A0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .dash-user-info h5 { font-size: 0.85rem; font-weight: 600; }
        .dash-user-info p { font-size: 0.72rem; color: var(--text-light); }

        .dash-notif {
            width: 38px; height: 38px; border-radius: 50%;
            background: var(--bg-soft); border: 1px solid var(--border-light);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-mid); font-size: 0.85rem; position: relative;
            cursor: pointer;
        }

        .dash-notif::after {
            content: '';
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--warm);
            position: absolute; top: 6px; right: 6px;
            border: 2px solid var(--hero-card-bg);
        }

        .dash-body { padding: 1.5rem }

        .dash-greeting {
            font-size: 1.05rem; font-weight: 700; margin-bottom: 0.2rem;
        }

        .dash-greeting span {
            background: linear-gradient(135deg, #6366F1, #06D6A0);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .dash-sub { font-size: 0.78rem; color: var(--text-light); margin-bottom: 1.2rem; }

        .dash-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
        }

        .dash-mini-card {
            background: var(--bg-soft);
            border: 1px solid var(--border-light);
            border-radius: 14px;
            padding: 1rem;
            transition: all 0.3s;
            cursor: pointer;
        }

        .dash-mini-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .dmc-icon {
            width: 34px; height: 34px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 0.75rem; margin-bottom: 0.6rem;
        }

        .dmc-icon.purple { background: var(--primary); }
        .dmc-icon.green { background: var(--accent); }
        .dmc-icon.warm { background: var(--warm); }
        .dmc-icon.gold { background: var(--gold); }

        .dmc-value { font-size: 1.3rem; font-weight: 800; letter-spacing: -0.02em; }
        .dmc-label { font-size: 0.72rem; color: var(--text-light); margin-top: 0.1rem; }

        .dash-bottom-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 1.5rem;
            border-top: 1px solid var(--border-light);
            background: var(--bg-soft);
        }

        .dash-bottom-bar span { font-size: 0.78rem; color: var(--text-light); }

        .db-btn {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 0.45rem 1rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s;
        }

        .db-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .hero-float-card {
            position: absolute;
            background: var(--hero-card-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 0.8rem 1rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            z-index: 3;
            animation: floatCard 5s ease-in-out infinite;
        }

        .hfc-1 { top: -10px; left: -25px; animation-delay: -1s; }
        .hfc-2 { bottom: 30px; right: -20px; animation-delay: -3s; }

        @keyframes floatCard {
            0%,100%{transform:translateY(0)}
            50%{transform:translateY(-8px)}
        }

        .hfc-icon {
            width: 28px; height: 28px; border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 0.7rem; margin-bottom: 0.3rem;
        }
        .hfc-icon.purple { background: var(--primary); }
        .hfc-icon.green { background: var(--accent); }
        .hfc-text { font-size: 0.68rem; color: var(--text-light); }
        .hfc-val { font-size: 0.85rem; font-weight: 700; }

        /* Features strip */
        .features-strip {
            display:grid; grid-template-columns:repeat(4,1fr); gap:1rem;
            margin-top:3rem; position:relative; z-index:2;
        }
        .feature-mini {
            display:flex; align-items:center; gap:0.8rem;
            padding:1rem 1.2rem; background:var(--bg-card); border:1px solid var(--border-light);
            border-radius:var(--radius); transition:all 0.3s;
        }
        .feature-mini:hover { transform:translateY(-3px); box-shadow:var(--shadow-lg); }
        .fm-icon {
            width:38px; height:38px; border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            color:#fff; font-size:0.85rem; flex-shrink:0;
        }
        .fm-text h5 { font-size:0.85rem; font-weight:600; }
        .fm-text p { font-size:0.72rem; color:var(--text-light); }

        /* ========== BUSINESSES ========== */
        .filter-bar { display:flex; justify-content:center; gap:0.4rem; margin-bottom:2.5rem; flex-wrap:wrap }
        .filter-btn {
            padding:0.5rem 1.2rem; border-radius:50px; border:1.5px solid var(--border);
            background:var(--bg-card); color:var(--text-mid); font-weight:500;
            font-size:0.85rem; cursor:pointer; transition:all 0.3s; font-family:'Inter',sans-serif;
        }
        .filter-btn:hover, .filter-btn.active {
            border-color:var(--primary); background:var(--primary); color:#fff;
            box-shadow:0 4px 15px rgba(99,102,241,0.25);
        }

        .business-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(340px,1fr)); gap:1.5rem }

        .b-card {
            background:var(--bg-card); border:1px solid var(--border-light);
            border-radius:var(--radius-lg); overflow:hidden;
            transition:all 0.4s cubic-bezier(0.16,1,0.3,1); cursor:pointer;
        }
        .b-card:hover { transform:translateY(-8px); box-shadow:var(--shadow-xl); border-color:transparent; }

        .b-img {
            height:180px; position:relative; display:flex;
            align-items:center; justify-content:center;
        }
        .b-img i { font-size:3.5rem; color:rgba(255,255,255,0.95); z-index:2 }
        .rating-badge {
            position:absolute; top:1rem; right:1rem;
            background:rgba(255,255,255,0.95); backdrop-filter:blur(10px);
            padding:0.25rem 0.7rem; border-radius:50px; font-weight:700;
            font-size:0.8rem; color:#0F172A; display:flex; align-items:center; gap:0.2rem; z-index:3;
        }
        .rating-badge i { font-size:0.65rem; color:#FBBF24 }

        .b-body { padding:1.5rem }
        .b-body h3 { font-size:1.15rem; font-weight:700; margin-bottom:0.3rem; letter-spacing:-0.02em }
        .b-loc { color:var(--text-light); font-size:0.83rem; display:flex; align-items:center; gap:0.3rem; margin-bottom:0.7rem }
        .tags { display:flex; gap:0.35rem; flex-wrap:wrap; margin-bottom:1rem }
        .tag {
            background:var(--bg-soft); color:var(--text-mid); padding:0.25rem 0.6rem;
            border-radius:6px; font-size:0.75rem; font-weight:500; border:1px solid var(--border-light);
        }
        .b-footer { display:flex; justify-content:space-between; align-items:center; padding-top:1rem; border-top:1px solid var(--border-light) }
        .price { font-size:1.15rem; font-weight:700; color:var(--primary) }
        .price small { font-size:0.75rem; color:var(--text-light); font-weight:400 }
        .btn-book {
            background:var(--primary); color:#fff; border:none; padding:0.55rem 1.3rem;
            border-radius:50px; font-weight:600; font-size:0.85rem; cursor:pointer;
            transition:all 0.3s; font-family:'Inter',sans-serif;
        }
        .btn-book:hover { background:var(--primary-dark); transform:scale(1.05); box-shadow:0 4px 15px rgba(99,102,241,0.3) }

        /* ========== BOOKING ========== */
        .booking-layout { display:grid; grid-template-columns:1.3fr 1fr; gap:2.5rem; align-items:start }

        .form-card {
            background:var(--bg-card); border:1px solid var(--border-light);
            border-radius:var(--radius-lg); padding:2.5rem; box-shadow:var(--shadow);
        }
        .form-card h3 { font-size:1.5rem; font-weight:700; margin-bottom:0.3rem; letter-spacing:-0.02em }
        .form-card>p { color:var(--text-light); margin-bottom:1.8rem; font-size:0.92rem }

        .form-group { margin-bottom:1rem }
        .form-group label { display:block; font-weight:600; margin-bottom:0.4rem; font-size:0.85rem; color:var(--text-mid) }
        .form-control {
            width:100%; padding:0.85rem 1rem; border:1.5px solid var(--border);
            border-radius:12px; font-size:0.92rem; font-family:'Inter',sans-serif;
            transition:all 0.3s; background:var(--bg); color:var(--text);
        }
        .form-control:focus { outline:none; border-color:var(--primary); box-shadow:0 0 0 4px rgba(99,102,241,0.08) }
        .form-control::placeholder { color:var(--text-light) }
        .form-control-select {
            appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 10 10'%3E%3Cpath fill='%236366F1' d='M5 7L0 2h10z'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 1rem center; padding-right:2.5rem; cursor:pointer;
        }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem }

        .btn-submit {
            width:100%; padding:0.95rem; background:var(--primary); color:#fff; border:none;
            border-radius:12px; font-size:1rem; font-weight:700; cursor:pointer;
            transition:all 0.3s; font-family:'Inter',sans-serif; display:flex;
            align-items:center; justify-content:center; gap:0.5rem; margin-top:0.5rem;
        }
        .btn-submit:hover { background:var(--primary-dark); transform:translateY(-2px); box-shadow:0 8px 25px rgba(99,102,241,0.3) }

        .summary-card {
            background:var(--bg-soft); border:1px solid var(--border-light);
            border-radius:var(--radius-lg); padding:2rem; position:sticky; top:90px;
        }
        .s-header { display:flex; align-items:center; gap:0.8rem; margin-bottom:1.5rem }
        .s-icon {
            width:44px; height:44px; background:linear-gradient(135deg,#6366F1,#06D6A0);
            border-radius:12px; display:flex; align-items:center; justify-content:center;
            color:#fff; font-size:1rem;
        }
        .s-header h4 { font-size:1rem; font-weight:700 }
        .s-header p { font-size:0.78rem; color:var(--text-light) }

        .s-list { display:flex; flex-direction:column; gap:0.5rem; margin-bottom:1.2rem }
        .s-row { display:flex; justify-content:space-between; padding:0.55rem 0; border-bottom:1px solid var(--border-light); font-size:0.88rem }
        .s-row .lbl { color:var(--text-light) }
        .s-row .val { font-weight:600 }

        .s-total { display:flex; justify-content:space-between; padding:1rem 0; border-top:2px solid var(--border); font-size:1.1rem; font-weight:700 }
        .s-total .price-final {
            background:linear-gradient(135deg,#6366F1,#06D6A0);
            -webkit-background-clip:text; -webkit-text-fill-color:transparent;
        }
        .perks { display:flex; flex-direction:column; gap:0.6rem; margin-top:1.2rem }
        .perk { display:flex; align-items:center; gap:0.6rem; font-size:0.82rem; color:var(--text-light) }
        .perk i { color:var(--accent); font-size:0.75rem }

        /* ========== ANALYTICS ========== */
        .stats-row { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:2rem }
        .stat-card {
            background:var(--bg-card); border:1px solid var(--border-light);
            border-radius:var(--radius); padding:1.6rem; text-align:center; transition:all 0.3s;
        }
        .stat-card:hover { transform:translateY(-5px); box-shadow:var(--shadow-lg); }
        .stat-icon {
            width:44px; height:44px; margin:0 auto 0.8rem; border-radius:12px;
            display:flex; align-items:center; justify-content:center; color:#fff; font-size:1rem;
        }
        .stat-card:nth-child(1) .stat-icon { background:var(--primary) }
        .stat-card:nth-child(2) .stat-icon { background:var(--accent) }
        .stat-card:nth-child(3) .stat-icon { background:var(--warm) }
        .stat-card:nth-child(4) .stat-icon { background:var(--gold) }
        .stat-num { font-size:1.8rem; font-weight:800; letter-spacing:-0.03em }
        .stat-label { color:var(--text-light); font-size:0.78rem; font-weight:500 }

        .charts-row { display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; margin-bottom:2rem }
        .chart-card {
            background:var(--bg-card); border:1px solid var(--border-light);
            border-radius:var(--radius); padding:1.8rem;
        }
        .chart-card h4 { margin-bottom:1rem; font-size:1rem; font-weight:700; display:flex; align-items:center; gap:0.5rem }
        .chart-card h4 i { color:var(--primary) }
        .chart-wrap { position:relative; height:260px }

        .ai-tip {
            background:var(--bg-card); border:1px solid rgba(99,102,241,0.12);
            border-radius:var(--radius); padding:1.4rem; display:flex; align-items:flex-start; gap:1rem;
        }
        .ai-tip-icon {
            width:40px; height:40px; background:linear-gradient(135deg,#6366F1,#06D6A0);
            border-radius:10px; display:flex; align-items:center; justify-content:center;
            color:#fff; flex-shrink:0;
        }
        .ai-tip h5 { font-size:0.9rem; margin-bottom:0.2rem }
        .ai-tip p { color:var(--text-light); font-size:0.82rem; line-height:1.5 }

        /* ========== ABOUT ========== */
        .about-split { display:grid; grid-template-columns:1fr 1fr; gap:4rem; align-items:center; margin-bottom:4rem }
        .about-img-box {
            background:linear-gradient(135deg,#6366F1,#06D6A0);
            border-radius:var(--radius-lg); padding:3.5rem; position:relative; overflow:hidden;
        }
        .about-img-box::before {
            content:''; position:absolute; width:200px; height:200px;
            background:rgba(255,255,255,0.08); border-radius:50%; top:-60px; right:-40px;
        }
        .about-img-box i { font-size:7rem; color:rgba(255,255,255,0.9); display:block; text-align:center; position:relative; z-index:2 }

        .about-float {
            position:absolute; bottom:-15px; right:-15px;
            background:var(--bg-card); border-radius:var(--radius);
            padding:1rem; box-shadow:var(--shadow-lg); display:flex;
            align-items:center; gap:0.7rem; z-index:3;
            animation:floatCard 5s ease-in-out infinite;
        }
        .af-icon { width:38px; height:38px; background:var(--accent); border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff }
        .af-text h5 { font-size:0.95rem; font-weight:700 }
        .af-text p { color:var(--text-light); font-size:0.75rem }

        .about-text h3 { font-size:1.9rem; font-weight:700; margin-bottom:1rem; letter-spacing:-0.03em }
        .about-text p { color:var(--text-light); line-height:1.75; margin-bottom:1rem; font-size:0.95rem }
        .about-checks { display:grid; grid-template-columns:1fr 1fr; gap:0.7rem; margin-top:1.5rem }
        .about-check { display:flex; align-items:center; gap:0.6rem }
        .ac-icon {
            width:24px; height:24px; background:rgba(6,214,160,0.1);
            border-radius:7px; display:flex; align-items:center; justify-content:center;
            color:var(--accent); font-size:0.65rem; flex-shrink:0;
        }
        .about-check span { font-size:0.85rem; font-weight:500 }

        .team-section { text-align:center }
        .team-section h3 { font-size:1.9rem; font-weight:700; margin-bottom:2.5rem; letter-spacing:-0.03em }
        .team-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.2rem }
        .team-card {
            background:var(--bg-card); border:1px solid var(--border-light);
            border-radius:var(--radius-lg); padding:1.8rem 1.2rem; text-align:center;
            transition:all 0.4s;
        }
        .team-card:hover { transform:translateY(-8px); box-shadow:var(--shadow-lg) }
        .team-avatar {
            width:64px; height:64px; border-radius:50%; margin:0 auto 0.8rem;
            display:flex; align-items:center; justify-content:center;
            font-size:1.4rem; color:#fff;
        }
        .team-card:nth-child(1) .team-avatar { background:var(--primary) }
        .team-card:nth-child(2) .team-avatar { background:var(--warm) }
        .team-card:nth-child(3) .team-avatar { background:var(--accent) }
        .team-card:nth-child(4) .team-avatar { background:#7C3AED }
        .team-card h4 { font-size:1rem; font-weight:700; margin-bottom:0.15rem }
        .team-card .role { color:var(--primary); font-size:0.8rem; font-weight:500; margin-bottom:0.5rem }
        .team-card p { color:var(--text-light); font-size:0.8rem; line-height:1.4 }

        /* ========== CONTACT ========== */
        .contact-layout { display:grid; grid-template-columns:1fr 1.3fr; gap:2.5rem; align-items:start }
        .contact-left h3 { font-size:1.7rem; font-weight:700; margin-bottom:0.4rem; letter-spacing:-0.02em }
        .contact-left>p { color:var(--text-light); line-height:1.7; margin-bottom:1.8rem }
        .contact-items { display:flex; flex-direction:column; gap:0.7rem }
        .contact-item {
            background:var(--bg-card); border:1px solid var(--border-light);
            border-radius:var(--radius); padding:1.1rem; display:flex;
            align-items:center; gap:0.9rem; transition:all 0.3s; cursor:pointer;
        }
        .contact-item:hover { transform:translateX(5px); box-shadow:var(--shadow); border-color:var(--primary) }
        .ci-icon {
            width:40px; height:40px; border-radius:10px; display:flex;
            align-items:center; justify-content:center; color:#fff; font-size:0.9rem; flex-shrink:0;
        }
        .contact-item:nth-child(1) .ci-icon { background:var(--primary) }
        .contact-item:nth-child(2) .ci-icon { background:var(--accent) }
        .contact-item:nth-child(3) .ci-icon { background:var(--warm) }
        .ci-text h5 { font-size:0.88rem; font-weight:600; margin-bottom:0.1rem }
        .ci-text p { color:var(--text-light); font-size:0.82rem }

        .contact-form-card {
            background:var(--bg-card); border:1px solid var(--border-light);
            border-radius:var(--radius-lg); padding:2.5rem; box-shadow:var(--shadow);
        }
        .contact-form-card h3 { font-size:1.3rem; font-weight:700; margin-bottom:1.5rem; letter-spacing:-0.02em }
        .form-textarea { min-height:120px; resize:vertical }

        /* ========== FOOTER ========== */
        .footer {
            background:var(--bg-card); border-top:1px solid var(--border-light);
            padding:3.5rem 2rem 1.5rem;
        }
        .footer-grid {
            max-width:1200px; margin:0 auto;
            display:grid; grid-template-columns:1.8fr 1fr 1fr 1fr; gap:2.5rem; margin-bottom:2.5rem;
        }
        .footer-brand p { color:var(--text-light); line-height:1.7; font-size:0.88rem; margin-top:0.8rem; max-width:260px }
        .footer-col h4 { font-size:0.9rem; font-weight:600; margin-bottom:1rem }
        .footer-col ul { list-style:none; display:flex; flex-direction:column; gap:0.5rem }
        .footer-col ul a { color:var(--text-light); text-decoration:none; font-size:0.85rem; transition:all 0.3s }
        .footer-col ul a:hover { color:var(--primary) }
        .footer-bottom {
            max-width:1200px; margin:0 auto; padding-top:1.5rem;
            border-top:1px solid var(--border-light);
            display:flex; justify-content:space-between; align-items:center;
        }
        .footer-bottom p { color:var(--text-light); font-size:0.8rem }
        .footer-socials { display:flex; gap:0.4rem }
        .footer-socials a {
            width:36px; height:36px; border-radius:10px; background:var(--bg-soft);
            display:flex; align-items:center; justify-content:center;
            color:var(--text-light); text-decoration:none; transition:all 0.3s;
        }
        .footer-socials a:hover { background:var(--primary); color:#fff; transform:translateY(-3px) }

        /* ========== TOAST ========== */
        .toast {
            position:fixed; bottom:2rem; right:2rem;
            background:var(--bg-card); border:1px solid var(--border);
            border-radius:var(--radius); padding:1rem 1.3rem;
            box-shadow:var(--shadow-xl); display:flex; align-items:center; gap:0.7rem;
            z-index:9999; transform:translateX(120%); transition:transform 0.5s cubic-bezier(0.16,1,0.3,1);
        }
        .toast.show { transform:translateX(0) }
        .toast-icon {
            width:34px; height:34px; border-radius:8px; background:var(--accent);
            display:flex; align-items:center; justify-content:center; color:#fff; font-size:0.8rem;
        }
        .toast-text h5 { font-size:0.85rem; font-weight:600 }
        .toast-text p { color:var(--text-light); font-size:0.75rem }

        /* ========== MODAL ========== */
        .modal-overlay {
            position:fixed; inset:0; background:rgba(0,0,0,0.35);
            backdrop-filter:blur(8px); z-index:10000;
            display:flex; align-items:center; justify-content:center;
            opacity:0; visibility:hidden; transition:all 0.3s;
        }
        .modal-overlay.active { opacity:1; visibility:visible }
        .modal {
            background:var(--bg-card); border-radius:var(--radius-lg); padding:2.5rem;
            max-width:420px; width:90%; transform:scale(0.9); transition:all 0.3s; text-align:center;
        }
        .modal-overlay.active .modal { transform:scale(1) }
        .modal-icon {
            width:64px; height:64px; background:linear-gradient(135deg,#6366F1,#06D6A0);
            border-radius:50%; display:flex; align-items:center; justify-content:center;
            margin:0 auto 1.2rem; font-size:1.6rem; color:#fff;
        }
        .modal h3 { font-size:1.3rem; font-weight:700; margin-bottom:0.4rem }
        .modal p { color:var(--text-light); line-height:1.6; margin-bottom:1.8rem }
        .modal .btn-primary { width:100%; justify-content:center }

        /* ========== RESPONSIVE ========== */
        @media(max-width:1024px) {
            .hero-content { grid-template-columns:1fr; text-align:center }
            .hero-text p { margin:0 auto 2rem }
            .hero-buttons { justify-content:center }
            .hero-right { display:none }
            .hero-text h1 { font-size:2.8rem }
            .features-strip { grid-template-columns:repeat(2,1fr) }
            .business-grid { grid-template-columns:repeat(auto-fill,minmax(280px,1fr)) }
            .booking-layout { grid-template-columns:1fr }
            .summary-card { position:static }
            .stats-row { grid-template-columns:repeat(2,1fr) }
            .charts-row { grid-template-columns:1fr }
            .about-split { grid-template-columns:1fr }
            .about-img-box { order:-1 }
            .team-grid { grid-template-columns:repeat(2,1fr) }
            .contact-layout { grid-template-columns:1fr }
            .footer-grid { grid-template-columns:1fr 1fr }
        }
        @media(max-width:768px) {
            .nav-center { display:none }
            .nav-links {
                display:none; position:fixed; top:60px; left:0; right:0; bottom:0;
                background:var(--bg); backdrop-filter:blur(20px);
                flex-direction:column; justify-content:center; align-items:center; gap:0.3rem;
                padding: 2rem;
            }
            .nav-links.open { display:flex }
            .mobile-toggle { display:block }
            .section-header h2 { font-size:2rem }
            .hero-text h1 { font-size:2.1rem }
            .features-strip { grid-template-columns:1fr }
            .form-row { grid-template-columns:1fr }
            .about-checks { grid-template-columns:1fr }
            .team-grid { grid-template-columns:1fr 1fr }
            .footer-grid { grid-template-columns:1fr }
            .footer-bottom { flex-direction:column; gap:1rem; text-align:center }
        }
        @media(max-width:480px) {
            .hero-text h1 { font-size:1.8rem }
            .stats-row { grid-template-columns:1fr }
            .team-grid { grid-template-columns:1fr }
            .business-grid { grid-template-columns:1fr }
            .hero-buttons { flex-direction:column }
            .btn { width:100%; justify-content:center }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo" onclick="navigate('home')">
            <div class="logo-icon"><i class="fas fa-calendar-check"></i></div>
            BookAI
        </div>
        <div class="nav-center">
            <ul class="nav-links" id="navLinks">
                <li><a onclick="navigate('home')" data-page="home" data-i18n="nav_home" class="active">Главная</a></li>
                <li><a onclick="navigate('businesses')" data-page="businesses" data-i18n="nav_businesses">Бизнесы</a></li>
                <li><a onclick="navigate('booking')" data-page="booking" data-i18n="nav_booking">Бронирование</a></li>
                <li><a onclick="navigate('analytics')" data-page="analytics" data-i18n="nav_analytics">AI Анализ</a></li>
                <li><a onclick="navigate('about')" data-page="about" data-i18n="nav_about">О нас</a></li>
                <li><a onclick="navigate('contact')" data-page="contact" data-i18n="nav_contact">Контакты</a></li>
            </ul>
        </div>
        <div class="nav-right">
            <button class="theme-toggle" onclick="toggleTheme()" aria-label="Toggle theme">
                <i class="fas fa-moon" id="themeIcon"></i>
            </button>
            <button class="lang-toggle-btn" onclick="toggleLang()">
                <span id="langText">RU</span>
            </button>
            <a class="btn nav-cta" onclick="navigate('booking')" data-i18n="nav_cta">Забронировать</a>
            <button class="mobile-toggle" onclick="toggleMenu()"><i class="fas fa-bars" id="menuIcon"></i></button>
        </div>
    </nav>

    <!-- PAGE: HOME -->
    <div class="page active" id="page-home">
        <section class="hero-section">
            <div class="hero-bg-glow hero-glow-1"></div>
            <div class="hero-bg-glow hero-glow-2"></div>
            <div class="hero-grid-bg"></div>
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h1 data-i18n="hero_title">Умное <span class="gradient-text">бронирование</span> нового поколения</h1>
                        <p data-i18n="hero_desc">Используйте искусственный интеллект для оптимизации бронирований, увеличения прибыли и создания идеального клиентского опыта.</p>
                        <div class="hero-buttons">
                            <a class="btn btn-primary" onclick="navigate('booking')"><i class="fas fa-rocket"></i> <span data-i18n="hero_btn_start">Начать бесплатно</span></a>
                            <a class="btn btn-ghost" onclick="navigate('analytics')"><i class="fas fa-play"></i> <span data-i18n="hero_btn_demo">Смотреть демо</span></a>
                        </div>
                    </div>
                    <div class="hero-right">
                        <div class="hero-float-card hfc-1">
                            <div class="hfc-icon purple"><i class="fas fa-bell"></i></div>
                            <div class="hfc-text" data-i18n="float_booking">Новое бронирование</div>
                            <div class="hfc-val">+12 <span data-i18n="float_today">сегодня</span></div>
                        </div>
                        <div class="hero-float-card hfc-2">
                            <div class="hfc-icon green"><i class="fas fa-chart-line"></i></div>
                            <div class="hfc-text" data-i18n="float_revenue">Доход</div>
                            <div class="hfc-val">₽4.2M</div>
                        </div>
                        <!-- Dashboard Preview Card -->
                        <div class="dashboard-preview">
                            <div class="dash-topbar">
                                <div class="dash-topbar-left">
                                    <div class="dash-avatar">AI</div>
                                    <div class="dash-user-info">
                                        <h5 data-i18n="dash_welcome">Добро пожаловать</h5>
                                        <p data-i18n="dash_subtext">Ваша панель управления</p>
                                    </div>
                                </div>
                                <div class="dash-notif"><i class="fas fa-bell"></i></div>
                            </div>
                            <div class="dash-body">
                                <div class="dash-greeting">
                                    <span data-i18n="dash_greeting">Привет!</span> <span>👋</span>
                                </div>
                                <div class="dash-sub" data-i18n="dash_greeting_sub">Вот ваша сводка на сегодня</div>

                                <div class="dash-cards">
                                    <div class="dash-mini-card">
                                        <div class="dmc-icon purple"><i class="fas fa-calendar-check"></i></div>
                                        <div class="dmc-value">12</div>
                                        <div class="dmc-label" data-i18n="dmc_bookings">Бронирований</div>
                                    </div>
                                    <div class="dash-mini-card">
                                        <div class="dmc-icon green"><i class="fas fa-check-circle"></i></div>
                                        <div class="dmc-value">98%</div>
                                        <div class="dmc-label" data-i18n="dmc_confirmed">Подтверждено</div>
                                    </div>
                                    <div class="dash-mini-card">
                                        <div class="dmc-icon warm"><i class="fas fa-users"></i></div>
                                        <div class="dmc-value">247</div>
                                        <div class="dmc-label" data-i18n="dmc_clients">Клиентов</div>
                                    </div>
                                    <div class="dash-mini-card">
                                        <div class="dmc-icon gold"><i class="fas fa-star"></i></div>
                                        <div class="dmc-value">4.9</div>
                                        <div class="dmc-label" data-i18n="dmc_rating">Рейтинг</div>
                                    </div>
                                </div>
                            </div>
                            <div class="dash-bottom-bar">
                                <span data-i18n="dash_bottom">3 новых запроса</span>
                                <button class="db-btn" onclick="navigate('booking')" data-i18n="dash_btn">Все бронирования →</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="features-strip">
                    <div class="feature-mini">
                        <div class="fm-icon" style="background:var(--primary)"><i class="fas fa-robot"></i></div>
                        <div class="fm-text"><h5 data-i18n="f1_title">AI Оптимизация</h5><p data-i18n="f1_desc">Умные рекомендации</p></div>
                    </div>
                    <div class="feature-mini">
                        <div class="fm-icon" style="background:var(--accent)"><i class="fas fa-bolt"></i></div>
                        <div class="fm-text"><h5 data-i18n="f2_title">Мгновенно</h5><p data-i18n="f2_desc">Подтверждение за 1 сек</p></div>
                    </div>
                    <div class="feature-mini">
                        <div class="fm-icon" style="background:var(--warm)"><i class="fas fa-shield-alt"></i></div>
                        <div class="fm-text"><h5 data-i18n="f3_title">Безопасно</h5><p data-i18n="f3_desc">Защита данных</p></div>
                    </div>
                    <div class="feature-mini">
                        <div class="fm-icon" style="background:var(--gold)"><i class="fas fa-star"></i></div>
                        <div class="fm-text"><h5 data-i18n="f4_title">5000+ партнёров</h5><p data-i18n="f4_desc">По всей России</p></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- PAGE: BUSINESSES -->
    <div class="page" id="page-businesses">
        <div class="container">
            <div class="section-header">
                <div class="section-badge"><i class="fas fa-store"></i> <span data-i18n="biz_badge">Каталог</span></div>
                <h2 data-i18n="biz_title">Лучшие <span data-i18n="biz_span">бизнесы</span> для бронирования</h2>
                <p data-i18n="biz_desc">Выберите из тысяч проверенных заведений и запишитесь онлайн за несколько кликов</p>
            </div>
            <div class="filter-bar">
                <button class="filter-btn active" onclick="filterBiz(this)" data-i18n="filter_all">Все</button>
                <button class="filter-btn" onclick="filterBiz(this)" data-i18n="filter_rest">Рестораны</button>
                <button class="filter-btn" onclick="filterBiz(this)">SPA</button>
                <button class="filter-btn" onclick="filterBiz(this)" data-i18n="filter_co">Коворкинги</button>
                <button class="filter-btn" onclick="filterBiz(this)" data-i18n="filter_fit">Фитнес</button>
                <button class="filter-btn" onclick="filterBiz(this)" data-i18n="filter_hotel">Отели</button>
            </div>
            <div class="business-grid" id="businessGrid"></div>
        </div>
    </div>

    <!-- PAGE: BOOKING -->
    <div class="page" id="page-booking">
        <div class="container">
            <div class="section-header">
                <div class="section-badge"><i class="fas fa-calendar-plus"></i> <span data-i18n="book_badge">Бронирование</span></div>
                <h2 data-i18n="book_title">Забронируйте <span data-i18n="book_span">за минуту</span></h2>
                <p data-i18n="book_desc">Заполните простую форму и наш AI подберёт лучшее предложение для вас</p>
            </div>
            <div class="booking-layout">
                <div class="form-card">
                    <h3 data-i18n="book_form_title">Оформить бронирование</h3>
                    <p data-i18n="book_form_desc">Заполните данные для быстрого бронирования</p>
                    <form onsubmit="handleBooking(event)">
                        <div class="form-group">
                            <label data-i18n="book_type">Тип заведения</label>
                            <select class="form-control form-control-select" id="bookingType" onchange="updateSummary()">
                                <option value="" data-i18n="book_select">Выберите тип</option>
                                <option value="restaurant" data-i18n="book_rest">Ресторан</option>
                                <option value="spa" data-i18n="book_spa">SPA & Салон</option>
                                <option value="coworking" data-i18n="book_coworking">Коворкинг</option>
                                <option value="hotel" data-i18n="book_hotel">Отель</option>
                                <option value="fitness" data-i18n="book_fitness">Фитнес</option>
                                <option value="cinema" data-i18n="book_cinema">Кинотеатр</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label data-i18n="book_date">Дата</label>
                                <input type="date" class="form-control" id="bookingDate" onchange="updateSummary()">
                            </div>
                            <div class="form-group">
                                <label data-i18n="book_time">Время</label>
                                <select class="form-control form-control-select" id="bookingTime" onchange="updateSummary()">
                                    <option value="" data-i18n="book_select_time">Выберите время</option>
                                    <option>09:00</option><option>10:00</option><option>11:00</option><option>12:00</option>
                                    <option>13:00</option><option>14:00</option><option>15:00</option><option>16:00</option>
                                    <option>17:00</option><option>18:00</option><option>19:00</option><option>20:00</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label data-i18n="book_guests">Количество гостей</label>
                                <select class="form-control form-control-select" id="bookingGuests" onchange="updateSummary()">
                                    <option value="1" data-i18n="guest_1">1 человек</option>
                                    <option value="2" selected data-i18n="guest_2">2 человека</option>
                                    <option value="3" data-i18n="guest_3">3 человека</option>
                                    <option value="4" data-i18n="guest_4">4 человека</option>
                                    <option value="5" data-i18n="guest_5">5 человек</option>
                                    <option value="6" data-i18n="guest_6">6+ человек</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label data-i18n="book_name">Ваше имя</label>
                                <input type="text" class="form-control" id="bookingName" placeholder="Иван Петров" oninput="updateSummary()">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="ivan@example.com">
                            </div>
                            <div class="form-group">
                                <label data-i18n="book_phone">Телефон</label>
                                <input type="tel" class="form-control" placeholder="+7 (999) 123-45-67">
                            </div>
                        </div>
                        <div class="form-group">
                            <label data-i18n="book_wish">Пожелания</label>
                            <input type="text" class="form-control" id="bookingNotes" data-i18n-placeholder="book_wish_ph" placeholder="Особые пожелания...">
                        </div>
                        <button type="submit" class="btn-submit"><i class="fas fa-check-circle"></i> <span data-i18n="book_submit">Подтвердить бронирование</span></button>
                    </form>
                </div>
                <div class="summary-card">
                    <div class="s-header">
                        <div class="s-icon"><i class="fas fa-receipt"></i></div>
                        <div><h4 data-i18n="summary_title">Ваше бронирование</h4><p data-i18n="summary_sub">Предварительная информация</p></div>
                    </div>
                    <div class="s-list">
                        <div class="s-row"><span class="lbl" data-i18n="s_type">Заведение</span><span class="val" id="sumType">—</span></div>
                        <div class="s-row"><span class="lbl" data-i18n="s_date">Дата</span><span class="val" id="sumDate">—</span></div>
                        <div class="s-row"><span class="lbl" data-i18n="s_time">Время</span><span class="val" id="sumTime">—</span></div>
                        <div class="s-row"><span class="lbl" data-i18n="s_guests">Гостей</span><span class="val" id="sumGuests">2 человека</span></div>
                        <div class="s-row"><span class="lbl" data-i18n="s_name">Имя</span><span class="val" id="sumName">—</span></div>
                    </div>
                    <div class="s-total"><span data-i18n="s_total">Предварительно</span><span class="price-final" id="sumPrice">—</span></div>
                    <div class="perks">
                        <div class="perk"><i class="fas fa-shield-alt"></i> <span data-i18n="perk_1">Бесплатная отмена за 24 часа</span></div>
                        <div class="perk"><i class="fas fa-robot"></i> <span data-i18n="perk_2">AI-оптимизация расписания</span></div>
                        <div class="perk"><i class="fas fa-bell"></i> <span data-i18n="perk_3">Напоминание за 2 часа</span></div>
                        <div class="perk"><i class="fas fa-star"></i> <span data-i18n="perk_4">Бонусные баллы</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PAGE: ANALYTICS -->
    <div class="page" id="page-analytics">
        <div class="container">
            <div class="section-header">
                <div class="section-badge"><i class="fas fa-brain"></i> <span data-i18n="ai_badge">AI Аналитика</span></div>
                <h2 data-i18n="ai_title">Аналитика <span data-i18n="ai_span">на базе AI</span></h2>
                <p data-i18n="ai_desc">Умные инсайты и прогнозы для максимизации эффективности вашего бизнеса</p>
            </div>
            <div class="stats-row">
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-calendar-check"></i></div><div class="stat-num">12,847</div><div class="stat-label" data-i18n="ai_stat1">Бронирований за месяц</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-percentage"></i></div><div class="stat-num">94.2%</div><div class="stat-label" data-i18n="ai_stat2">Конверсия</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-coins"></i></div><div class="stat-num">₽4.2M</div><div class="stat-label" data-i18n="ai_stat3">Выручка</div></div>
                <div class="stat-card"><div class="stat-icon"><i class="fas fa-chart-line"></i></div><div class="stat-num">+32%</div><div class="stat-label" data-i18n="ai_stat4">Рост к прошлому</div></div>
            </div>
            <div class="charts-row">
                <div class="chart-card">
                    <h4><i class="fas fa-chart-area"></i> <span data-i18n="chart_bookings">Динамика бронирований</span></h4>
                    <div class="chart-wrap"><canvas id="bookingsChart"></canvas></div>
                </div>
                <div class="chart-card">
                    <h4><i class="fas fa-chart-pie"></i> <span data-i18n="chart_categories">Типы заведений</span></h4>
                    <div class="chart-wrap"><canvas id="categoriesChart"></canvas></div>
                </div>
            </div>
            <div class="ai-tip">
                <div class="ai-tip-icon"><i class="fas fa-robot"></i></div>
                <div>
                    <h5 data-i18n="ai_tip_title">🤖 AI Рекомендация</h5>
                    <p data-i18n="ai_tip_desc">На основе анализа данных, рекомендуем увеличить количество столиков на 20% в пятницу и субботу. Ожидается рост загрузки на 15% при добавлении вечерних слотов бронирования.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- PAGE: ABOUT -->
    <div class="page" id="page-about">
        <div class="container">
            <div class="about-split">
                <div>
                    <div class="about-img-box">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="about-float">
                        <div class="af-icon"><i class="fas fa-trophy"></i></div>
                        <div class="af-text"><h5 data-i18n="about_float">Лидер рынка</h5><p data-i18n="about_float_sub">№1 в России</p></div>
                    </div>
                </div>
                <div class="about-text">
                    <div class="section-badge"><i class="fas fa-info-circle"></i> <span data-i18n="about_badge">О нас</span></div>
                    <h3 data-i18n="about_title">Мы создаём будущее бронирования</h3>
                    <p data-i18n="about_p1">BookAI — это инновационная платформа, которая объединяет лучшие заведения с умными технологиями бронирования. Наша миссия — сделать процесс записи максимально простым и эффективным.</p>
                    <p data-i18n="about_p2">Благодаря искусственному интеллекту мы анализируем поведение пользователей, оптимизируем расписания и предлагаем персонализированные рекомендации.</p>
                    <div class="about-checks">
                        <div class="about-check"><div class="ac-icon"><i class="fas fa-check"></i></div><span data-i18n="about_c1">AI-оптимизация</span></div>
                        <div class="about-check"><div class="ac-icon"><i class="fas fa-check"></i></div><span data-i18n="about_c2">24/7 поддержка</span></div>
                        <div class="about-check"><div class="ac-icon"><i class="fas fa-check"></i></div><span data-i18n="about_c3">5000+ партнёров</span></div>
                        <div class="about-check"><div class="ac-icon"><i class="fas fa-check"></i></div><span data-i18n="about_c4">Мгновенное подтверждение</span></div>
                        <div class="about-check"><div class="ac-icon"><i class="fas fa-check"></i></div><span data-i18n="about_c5">Программа лояльности</span></div>
                        <div class="about-check"><div class="ac-icon"><i class="fas fa-check"></i></div><span data-i18n="about_c6">Безопасные платежи</span></div>
                    </div>
                </div>
            </div>
            <div class="team-section">
                <h3 data-i18n="team_title">Наша команда</h3>
                <div class="team-grid" id="teamGrid"></div>
            </div>
        </div>
    </div>

    <!-- PAGE: CONTACT -->
    <div class="page" id="page-contact">
        <div class="container">
            <div class="section-header">
                <div class="section-badge"><i class="fas fa-envelope"></i> <span data-i18n="contact_badge">Связь</span></div>
                <h2 data-i18n="contact_title">Свяжитесь <span data-i18n="contact_span">с нами</span></h2>
                <p data-i18n="contact_desc">Мы всегда рады помочь вам. Напишите нам, и мы ответим в течение 24 часов</p>
            </div>
            <div class="contact-layout">
                <div class="contact-left">
                    <h3 data-i18n="contact_chat">Давайте поговорим</h3>
                    <p data-i18n="contact_chat_desc">Есть вопросы о нашем сервисе? Хотите стать партнёром? Мы на связи и готовы помочь вам в любое время.</p>
                    <div class="contact-items">
                        <div class="contact-item">
                            <div class="ci-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="ci-text"><h5 data-i18n="ci_office">Наш офис</h5><p data-i18n="ci_office_addr">Москва, ул. Тверская, 12, офис 304</p></div>
                        </div>
                        <div class="contact-item">
                            <div class="ci-icon"><i class="fas fa-phone-alt"></i></div>
                            <div class="ci-text"><h5 data-i18n="ci_phone">Телефон</h5><p>+7 (495) 123-45-67</p></div>
                        </div>
                        <div class="contact-item">
                            <div class="ci-icon"><i class="fas fa-envelope"></i></div>
                            <div class="ci-text"><h5>Email</h5><p>hello@bookai.ru</p></div>
                        </div>
                    </div>
                </div>
                <div class="contact-form-card">
                    <h3 data-i18n="contact_form_title">Напишите нам</h3>
                    <form onsubmit="handleContact(event)">
                        <div class="form-row">
                            <div class="form-group">
                                <label data-i18n="contact_name">Имя</label>
                                <input type="text" class="form-control" data-i18n-placeholder="contact_name_ph" placeholder="Ваше имя" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="email@example.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label data-i18n="contact_subject">Тема</label>
                            <select class="form-control form-control-select">
                                <option data-i18n="cs_general">Общий вопрос</option>
                                <option data-i18n="cs_partner">Партнёрство</option>
                                <option data-i18n="cs_tech">Техническая поддержка</option>
                                <option data-i18n="cs_review">Отзыв</option>
                                <option data-i18n="cs_other">Другое</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label data-i18n="contact_msg">Сообщение</label>
                            <textarea class="form-control form-textarea" data-i18n-placeholder="contact_msg_ph" placeholder="Расскажите подробнее..." required></textarea>
                        </div>
                        <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> <span data-i18n="contact_send">Отправить сообщение</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="logo">
                    <div class="logo-icon"><i class="fas fa-calendar-check"></i></div>
                    BookAI
                </div>
                <p data-i18n="footer_desc">Умная платформа бронирования нового поколения. Оптимизируем ваш бизнес с помощью искусственного интеллекта.</p>
            </div>
            <div class="footer-col">
                <h4 data-i18n="footer_company">Компания</h4>
                <ul>
                    <li><a href="#" onclick="navigate('about')" data-i18n="nav_about">О нас</a></li>
                    <li><a href="#" data-i18n="footer_career">Карьера</a></li>
                    <li><a href="#" data-i18n="footer_blog">Блог</a></li>
                    <li><a href="#" data-i18n="footer_press">Пресса</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 data-i18n="footer_product">Продукт</h4>
                <ul>
                    <li><a href="#" onclick="navigate('businesses')" data-i18n="nav_businesses">Бизнесы</a></li>
                    <li><a href="#" onclick="navigate('booking')" data-i18n="nav_booking">Бронирование</a></li>
                    <li><a href="#" onclick="navigate('analytics')" data-i18n="nav_analytics">AI Аналитика</a></li>
                    <li><a href="#" data-i18n="footer_pricing">Тарифы</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 data-i18n="footer_support">Поддержка</h4>
                <ul>
                    <li><a href="#" onclick="navigate('contact')" data-i18n="nav_contact">Контакты</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#" data-i18n="footer_docs">Документация</a></li>
                    <li><a href="#" data-i18n="footer_status">Статус</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2024 BookAI. <span data-i18n="footer_rights">Все права защищены.</span></p>
            <div class="footer-socials">
                <a href="#"><i class="fab fa-telegram"></i></a>
                <a href="#"><i class="fab fa-vk"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </footer>

    <!-- Toast -->
    <div class="toast" id="toast">
        <div class="toast-icon"><i class="fas fa-check"></i></div>
        <div class="toast-text"><h5 id="toastTitle"></h5><p id="toastMsg"></p></div>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <div class="modal-icon"><i class="fas fa-check"></i></div>
            <h3 id="modalTitle"></h3>
            <p id="modalText"></p>
            <button class="btn btn-primary" onclick="closeModal()"><span data-i18n="modal_ok">Отлично!</span></button>
        </div>
    </div>

    <script>
        let currentTheme = 'light';
        let currentLang = 'ru';
        let chartsCreated = false;

        const i18n = {
            ru: {
                nav_home:'Главная', nav_businesses:'Бизнесы', nav_booking:'Бронирование',
                nav_analytics:'AI Анализ', nav_about:'О нас', nav_contact:'Контакты', nav_cta:'Забронировать',
                hero_title:'Умное <span class="gradient-text">бронирование</span> нового поколения',
                hero_desc:'Используйте искусственный интеллект для оптимизации бронирований, увеличения прибыли и создания идеального клиентского опыта.',
                hero_btn_start:'Начать бесплатно', hero_btn_demo:'Смотреть демо',
                float_booking:'Новое бронирование', float_today:'сегодня', float_revenue:'Доход',
                dash_welcome:'Добро пожаловать', dash_subtext:'Ваша панель управления',
                dash_greeting:'Привет!', dash_greeting_sub:'Вот ваша сводка на сегодня',
                dmc_bookings:'Бронирований', dmc_confirmed:'Подтверждено', dmc_clients:'Клиентов', dmc_rating:'Рейтинг',
                dash_bottom:'3 новых запроса', dash_btn:'Все бронирования →',
                f1_title:'AI Оптимизация', f1_desc:'Умные рекомендации', f2_title:'Мгновенно', f2_desc:'Подтверждение за 1 сек',
                f3_title:'Безопасно', f3_desc:'Защита данных', f4_title:'5000+ партнёров', f4_desc:'По всей России',
                biz_badge:'Каталог', biz_title:'Лучшие <span>бизнесы</span> для бронирования',
                biz_desc:'Выберите из тысяч проверенных заведений и запишитесь онлайн за несколько кликов',
                filter_all:'Все', filter_rest:'Рестораны', filter_co:'Коворкинги', filter_fit:'Фитнес', filter_hotel:'Отели',
                book_badge:'Бронирование', book_title:'Забронируйте <span>за минуту</span>',
                book_desc:'Заполните простую форму и наш AI подберёт лучшее предложение для вас',
                book_form_title:'Оформить бронирование', book_form_desc:'Заполните данные для быстрого бронирования',
                book_type:'Тип заведения', book_select:'Выберите тип', book_rest:'Ресторан', book_spa:'SPA & Салон',
                book_coworking:'Коворкинг', book_hotel:'Отель', book_fitness:'Фитнес', book_cinema:'Кинотеатр',
                book_date:'Дата', book_time:'Время', book_select_time:'Выберите время',
                book_guests:'Количество гостей', guest_1:'1 человек', guest_2:'2 человека', guest_3:'3 человека',
                guest_4:'4 человека', guest_5:'5 человек', guest_6:'6+ человек',
                book_name:'Ваше имя', book_phone:'Телефон', book_wish:'Пожелания', book_wish_ph:'Особые пожелания...',
                book_submit:'Подтвердить бронирование',
                summary_title:'Ваше бронирование', summary_sub:'Предварительная информация',
                s_type:'Заведение', s_date:'Дата', s_time:'Время', s_guests:'Гостей', s_name:'Имя',
                s_total:'Предварительно', perk_1:'Бесплатная отмена за 24 часа', perk_2:'AI-оптимизация расписания',
                perk_3:'Напоминание за 2 часа', perk_4:'Бонусные баллы',
                ai_badge:'AI Аналитика', ai_title:'Аналитика <span>на базе AI</span>',
                ai_desc:'Умные инсайты и прогнозы для максимизации эффективности вашего бизнеса',
                ai_stat1:'Бронирований за месяц', ai_stat2:'Конверсия', ai_stat3:'Выручка', ai_stat4:'Рост к прошлому',
                chart_bookings:'Динамика бронирований', chart_categories:'Типы заведений',
                ai_tip_title:'🤖 AI Рекомендация',
                ai_tip_desc:'На основе анализа данных, рекомендуем увеличить количество столиков на 20% в пятницу и субботу. Ожидается рост загрузки на 15% при добавлении вечерних слотов бронирования.',
                about_badge:'О нас', about_title:'Мы создаём будущее бронирования',
                about_p1:'BookAI — это инновационная платформа, которая объединяет лучшие заведения с умными технологиями бронирования. Наша миссия — сделать процесс записи максимально простым и эффективным.',
                about_p2:'Благодаря искусственному интеллекту мы анализируем поведение пользователей, оптимизируем расписания и предлагаем персонализированные рекомендации.',
                about_float:'Лидер рынка', about_float_sub:'№1 в России',
                about_c1:'AI-оптимизация', about_c2:'24/7 поддержка', about_c3:'5000+ партнёров',
                about_c4:'Мгновенное подтверждение', about_c5:'Программа лояльности', about_c6:'Безопасные платежи',
                team_title:'Наша команда',
                contact_badge:'Связь', contact_title:'Свяжитесь <span>с нами</span>',
                contact_desc:'Мы всегда рады помочь вам. Напишите нам, и мы ответим в течение 24 часов',
                contact_chat:'Давайте поговорим', contact_chat_desc:'Есть вопросы о нашем сервисе? Хотите стать партнёром? Мы на связи и готовы помочь вам в любое время.',
                ci_office:'Наш офис', ci_office_addr:'Москва, ул. Тверская, 12, офис 304', ci_phone:'Телефон',
                contact_form_title:'Напишите нам', contact_name:'Имя', contact_name_ph:'Ваше имя',
                contact_subject:'Тема', cs_general:'Общий вопрос', cs_partner:'Партнёрство', cs_tech:'Техническая поддержка',
                cs_review:'Отзыв', cs_other:'Другое', contact_msg:'Сообщение', contact_msg_ph:'Расскажите подробнее...',
                contact_send:'Отправить сообщение',
                footer_desc:'Умная платформа бронирования нового поколения. Оптимизируем ваш бизнес с помощью искусственного интеллекта.',
                footer_company:'Компания', footer_career:'Карьера', footer_blog:'Блог', footer_press:'Пресса',
                footer_product:'Продукт', footer_pricing:'Тарифы', footer_support:'Поддержка',
                footer_docs:'Документация', footer_status:'Статус', footer_rights:'Все права защищены.',
                toast_book:'Бронирование подтверждено!', toast_book_msg:'Мы отправим подтверждение на ваш email.',
                toast_contact:'Сообщение отправлено!', toast_contact_msg:'Мы ответим вам в течение 24 часов',
                toast_select:'Выбрано:', toast_select_msg:'. Заполните форму для бронирования.',
                modal_ok:'Отлично!', modal_title:'Бронирование подтверждено!',
                modal_text:'Ваше бронирование успешно создано. Мы отправим подтверждение на ваш email.',
                btn_book:'Забронировать', team_ceo:'CEO & Основатель', team_cto:'CTO',
                team_design:'Head of Design', team_marketing:'Marketing Director'
            },
            en: {
                nav_home:'Home', nav_businesses:'Businesses', nav_booking:'Booking',
                nav_analytics:'AI Analytics', nav_about:'About', nav_contact:'Contact', nav_cta:'Book Now',
                hero_title:'Smart <span class="gradient-text">booking</span> of the new generation',
                hero_desc:'Use artificial intelligence to optimize bookings, increase profits, and create the perfect customer experience.',
                hero_btn_start:'Start Free', hero_btn_demo:'Watch Demo',
                float_booking:'New Booking', float_today:'today', float_revenue:'Revenue',
                dash_welcome:'Welcome', dash_subtext:'Your dashboard',
                dash_greeting:'Hello!', dash_greeting_sub:"Here's your summary for today",
                dmc_bookings:'Bookings', dmc_confirmed:'Confirmed', dmc_clients:'Clients', dmc_rating:'Rating',
                dash_bottom:'3 new requests', dash_btn:'All bookings →',
                f1_title:'AI Optimization', f1_desc:'Smart recommendations', f2_title:'Instant', f2_desc:'Confirmation in 1 sec',
                f3_title:'Secure', f3_desc:'Data protection', f4_title:'5000+ Partners', f4_desc:'Across Russia',
                biz_badge:'Catalog', biz_title:'Best <span>businesses</span> to book',
                biz_desc:'Choose from thousands of verified venues and book online in a few clicks',
                filter_all:'All', filter_rest:'Restaurants', filter_co:'Coworkings', filter_fit:'Fitness', filter_hotel:'Hotels',
                book_badge:'Booking', book_title:'Book <span>in a minute</span>',
                book_desc:'Fill out a simple form and our AI will find the best offer for you',
                book_form_title:'Make a Booking', book_form_desc:'Fill in the details for quick booking',
                book_type:'Venue Type', book_select:'Select type', book_rest:'Restaurant', book_spa:'SPA & Salon',
                book_coworking:'Coworking', book_hotel:'Hotel', book_fitness:'Fitness', book_cinema:'Cinema',
                book_date:'Date', book_time:'Time', book_select_time:'Select time',
                book_guests:'Number of Guests', guest_1:'1 person', guest_2:'2 people', guest_3:'3 people',
                guest_4:'4 people', guest_5:'5 people', guest_6:'6+ people',
                book_name:'Your Name', book_phone:'Phone', book_wish:'Wishes', book_wish_ph:'Special requests...',
                book_submit:'Confirm Booking',
                summary_title:'Your Booking', summary_sub:'Preliminary information',
                s_type:'Venue', s_date:'Date', s_time:'Time', s_guests:'Guests', s_name:'Name',
                s_total:'Preliminary', perk_1:'Free cancellation 24h before', perk_2:'AI schedule optimization',
                perk_3:'Reminder 2 hours before', perk_4:'Bonus points',
                ai_badge:'AI Analytics', ai_title:'AI-Powered <span>Analytics</span>',
                ai_desc:'Smart insights and forecasts to maximize your business efficiency',
                ai_stat1:'Bookings this month', ai_stat2:'Conversion', ai_stat3:'Revenue', ai_stat4:'Growth vs last',
                chart_bookings:'Booking Trends', chart_categories:'Venue Types',
                ai_tip_title:'🤖 AI Recommendation',
                ai_tip_desc:'Based on data analysis, we recommend increasing the number of tables by 20% on Friday and Saturday. A 15% increase in occupancy is expected when adding evening booking slots.',
                about_badge:'About Us', about_title:'We are creating the future of booking',
                about_p1:'BookAI is an innovative platform that combines the best venues with smart booking technologies. Our mission is to make the booking process as simple and efficient as possible.',
                about_p2:'Thanks to artificial intelligence, we analyze user behavior, optimize schedules, and offer personalized recommendations.',
                about_float:'Market Leader', about_float_sub:'#1 in Russia',
                about_c1:'AI Optimization', about_c2:'24/7 Support', about_c3:'5000+ Partners',
                about_c4:'Instant Confirmation', about_c5:'Loyalty Program', about_c6:'Secure Payments',
                team_title:'Our Team',
                contact_badge:'Contact', contact_title:'Get <span>in touch</span>',
                contact_desc:'We are always happy to help. Write to us and we will respond within 24 hours',
                contact_chat:"Let's Talk", contact_chat_desc:'Have questions about our service? Want to become a partner? We are online and ready to help anytime.',
                ci_office:'Our Office', ci_office_addr:'Moscow, Tverskaya St. 12, Office 304', ci_phone:'Phone',
                contact_form_title:'Write to Us', contact_name:'Name', contact_name_ph:'Your name',
                contact_subject:'Subject', cs_general:'General question', cs_partner:'Partnership', cs_tech:'Technical support',
                cs_review:'Review', cs_other:'Other', contact_msg:'Message', contact_msg_ph:'Tell us more...',
                contact_send:'Send Message',
                footer_desc:'Smart booking platform of the new generation. Optimizing your business with artificial intelligence.',
                footer_company:'Company', footer_career:'Careers', footer_blog:'Blog', footer_press:'Press',
                footer_product:'Product', footer_pricing:'Pricing', footer_support:'Support',
                footer_docs:'Documentation', footer_status:'Status', footer_rights:'All rights reserved.',
                toast_book:'Booking confirmed!', toast_book_msg:'We will send confirmation to your email.',
                toast_contact:'Message sent!', toast_contact_msg:'We will respond within 24 hours',
                toast_select:'Selected:', toast_select_msg:'. Fill out the form to book.',
                modal_ok:'Great!', modal_title:'Booking confirmed!',
                modal_text:'Your booking has been successfully created. We will send confirmation to your email.',
                btn_book:'Book', team_ceo:'CEO & Founder', team_cto:'CTO',
                team_design:'Head of Design', team_marketing:'Marketing Director'
            }
        };

        const businesses = [
            { icon:'fa-utensils', gradient:'linear-gradient(135deg,#667EEA,#764BA2)', rating:4.9,
              ru:{name:'Ресторан «Панорама»',loc:'Москва, Арбат 24',tags:['Европейская','Терраса','VIP']},
              en:{name:'Panorama Restaurant',loc:'Moscow, Arbat 24',tags:['European','Terrace','VIP']},
              price:'2,500₽', unit_ru:'/ чел', unit_en:'/ person' },
            { icon:'fa-spa', gradient:'linear-gradient(135deg,#F093FB,#F5576C)', rating:4.8,
              ru:{name:'SPA «Гармония»',loc:'Санкт-Петербург, Невский 56',tags:['Массаж','Сауна','Бассейн']},
              en:{name:'Harmony SPA',loc:'St. Petersburg, Nevsky 56',tags:['Massage','Sauna','Pool']},
              price:'3,000₽', unit_ru:'/ час', unit_en:'/ hour' },
            { icon:'fa-laptop-code', gradient:'linear-gradient(135deg,#4ECDC4,#44CF6C)', rating:4.7,
              ru:{name:'Коворкинг «TechSpace»',loc:'Казань, Баумана 12',tags:['Wi-Fi','Переговорки','24/7']},
              en:{name:'TechSpace Coworking',loc:'Kazan, Baumana 12',tags:['Wi-Fi','Meeting Rooms','24/7']},
              price:'500₽', unit_ru:'/ день', unit_en:'/ day' },
            { icon:'fa-film', gradient:'linear-gradient(135deg,#FF6B6B,#FFE66D)', rating:4.9,
              ru:{name:'Кинотеатр «StarLight»',loc:'Новосибирск, Красный проспект 88',tags:['IMAX','Dolby Atmos','VIP зал']},
              en:{name:'StarLight Cinema',loc:'Novosibirsk, Krasny Prospect 88',tags:['IMAX','Dolby Atmos','VIP Hall']},
              price:'800₽', unit_ru:'/ билет', unit_en:'/ ticket' },
            { icon:'fa-dumbbell', gradient:'linear-gradient(135deg,#a18cd1,#fbc2eb)', rating:4.6,
              ru:{name:'Фитнес «PowerZone»',loc:'Екатеринбург, Ленина 30',tags:['Тренажёры','Групповые','Тренер']},
              en:{name:'PowerZone Fitness',loc:'Yekaterinburg, Lenina 30',tags:['Gym','Group Classes','Trainer']},
              price:'1,200₽', unit_ru:'/ занятие', unit_en:'/ session' },
            { icon:'fa-hotel', gradient:'linear-gradient(135deg,#89f7fe,#66a6ff)', rating:4.8,
              ru:{name:'Отель «Skyline»',loc:'Сочи, Набережная 15',tags:['Люкс','Вид на море','Завтрак']},
              en:{name:'Skyline Hotel',loc:'Sochi, Embankment 15',tags:['Suite','Sea View','Breakfast']},
              price:'5,500₽', unit_ru:'/ ночь', unit_en:'/ night' }
        ];

        const teamData = [
            { ru:{name:'Алексей Морозов',desc:'10+ лет в сфере технологий'}, en:{name:'Alexey Morozov',desc:'10+ years in tech'}, roleKey:'team_ceo' },
            { ru:{name:'Мария Волкова',desc:'Эксперт в AI и ML'}, en:{name:'Maria Volkova',desc:'AI & ML expert'}, roleKey:'team_cto' },
            { ru:{name:'Дмитрий Козлов',desc:'Создаёт лучший UX'}, en:{name:'Dmitry Kozlov',desc:'Creates the best UX'}, roleKey:'team_design' },
            { ru:{name:'Анна Смирнова',desc:'Стратегия роста'}, en:{name:'Anna Smirnova',desc:'Growth strategy'}, roleKey:'team_marketing' }
        ];

        function navigate(page) {
            document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
            document.getElementById('page-' + page).classList.add('active');
            document.querySelectorAll('.nav-links a[data-page]').forEach(a => {
                a.classList.toggle('active', a.dataset.page === page);
            });
            closeMenu();
            window.scrollTo({ top: 0, behavior: 'instant' });
            if (page === 'analytics' && !chartsCreated) {
                setTimeout(createCharts, 300);
            }
        }

        function toggleTheme() {
            currentTheme = currentTheme === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', currentTheme);
            const icon = document.getElementById('themeIcon');
            icon.className = currentTheme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
            if (chartsCreated) updateChartsTheme();
        }

        function toggleLang() {
            currentLang = currentLang === 'ru' ? 'en' : 'ru';
            document.getElementById('langText').textContent = currentLang === 'ru' ? 'RU' : 'EN';
            document.documentElement.lang = currentLang === 'ru' ? 'ru' : 'en';
            applyTranslations();
        }

        function applyTranslations() {
            const t = i18n[currentLang];
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (t[key]) {
                    if (el.tagName === 'OPTION') {
                        el.textContent = t[key];
                    } else if (el.querySelectorAll('span.gradient-text').length > 0 || el.querySelector('.gradient-text')) {
                        el.innerHTML = t[key];
                    } else {
                        el.textContent = t[key];
                    }
                }
            });
            document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
                const key = el.getAttribute('data-i18n-placeholder');
                if (t[key]) el.placeholder = t[key];
            });
            renderBusinesses();
            renderTeam();
            updateSummary();
        }

        function renderBusinesses() {
            const t = i18n[currentLang];
            const grid = document.getElementById('businessGrid');
            grid.innerHTML = businesses.map(b => {
                const d = b[currentLang];
                const unit = currentLang === 'ru' ? b.unit_ru : b.unit_en;
                const prefix = currentLang === 'ru' ? 'от ' : '';
                return `<div class="b-card">
                    <div class="b-img" style="background:${b.gradient}">
                        <i class="fas ${b.icon}"></i>
                        <div class="rating-badge"><i class="fas fa-star"></i> ${b.rating}</div>
                    </div>
                    <div class="b-body">
                        <h3>${d.name}</h3>
                        <div class="b-loc"><i class="fas fa-map-marker-alt"></i> ${d.loc}</div>
                        <div class="tags">${d.tags.map(tag => `<span class="tag">${tag}</span>`).join('')}</div>
                        <div class="b-footer">
                            <div class="price">${prefix}${b.price} <small>${unit}</small></div>
                            <button class="btn-book" onclick="showBookingModal('${d.name}')">${t.btn_book}</button>
                        </div>
                    </div>
                </div>`;
            }).join('');
        }

        function renderTeam() {
            const t = i18n[currentLang];
            const grid = document.getElementById('teamGrid');
            const colors = ['var(--primary)','var(--warm)','var(--accent)','#7C3AED'];
            grid.innerHTML = teamData.map((m, i) => {
                const d = m[currentLang];
                return `<div class="team-card">
                    <div class="team-avatar" style="background:${colors[i]}"><i class="fas fa-user"></i></div>
                    <h4>${d.name}</h4>
                    <div class="role">${t[m.roleKey]}</div>
                    <p>${d.desc}</p>
                </div>`;
            }).join('');
        }

        function filterBiz(btn) {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }

        function updateSummary() {
            const t = i18n[currentLang];
            const type = document.getElementById('bookingType').value;
            const date = document.getElementById('bookingDate').value;
            const time = document.getElementById('bookingTime').value;
            const guests = document.getElementById('bookingGuests').value;
            const name = document.getElementById('bookingName').value;

            const typeNames = { '':'—', 'restaurant':t.book_rest, 'spa':t.book_spa, 'coworking':t.book_coworking, 'hotel':t.book_hotel, 'fitness':t.book_fitness, 'cinema':t.book_cinema };
            const prices = { '':'—', 'restaurant':'5,000₽', 'spa':'6,000₽', 'coworking':'1,000₽', 'hotel':'11,000₽', 'fitness':'2,400₽', 'cinema':'1,600₽' };
            const guestLabels = { '1':t.guest_1, '2':t.guest_2, '3':t.guest_3, '4':t.guest_4, '5':t.guest_5, '6':t.guest_6 };

            document.getElementById('sumType').textContent = typeNames[type];
            document.getElementById('sumDate').textContent = date ? new Date(date).toLocaleDateString(currentLang==='ru'?'ru-RU':'en-US', {day:'numeric',month:'long',year:'numeric'}) : '—';
            document.getElementById('sumTime').textContent = time || '—';
            document.getElementById('sumGuests').textContent = guestLabels[guests];
            document.getElementById('sumName').textContent = name || '—';
            document.getElementById('sumPrice').textContent = prices[type];
        }

        function handleBooking(e) {
            e.preventDefault();
            const type = document.getElementById('bookingType').value;
            const t = i18n[currentLang];
            if (!type) { showToast('Error', 'Пожалуйста, выберите тип заведения'); return; }
            showModal(t.modal_title, t.modal_text);
            e.target.reset();
            updateSummary();
        }

        function handleContact(e) {
            e.preventDefault();
            const t = i18n[currentLang];
            showToast(t.toast_contact, t.toast_contact_msg);
            e.target.reset();
        }

        function showToast(title, msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 4000);
        }

        function showBookingModal(name) {
            navigate('booking');
            showToast(i18n[currentLang].toast_select, name + i18n[currentLang].toast_select_msg);
        }

        function showModal(title, text) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalText').textContent = text;
            document.getElementById('modalOverlay').classList.add('active');
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('active');
        }

        document.getElementById('modalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

        function toggleMenu() {
            const nl = document.getElementById('navLinks');
            const mi = document.getElementById('menuIcon');
            nl.classList.toggle('open');
            mi.className = nl.classList.contains('open') ? 'fas fa-times' : 'fas fa-bars';
        }

        function closeMenu() {
            document.getElementById('navLinks').classList.remove('open');
            document.getElementById('menuIcon').className = 'fas fa-bars';
        }

        document.getElementById('bookingDate').setAttribute('min', new Date().toISOString().split('T')[0]);

        let bookingsChart, categoriesChart;

        function createCharts() {
            chartsCreated = true;
            const gridColor = getComputedStyle(document.documentElement).getPropertyValue('--chart-grid').trim();
            const textColor = getComputedStyle(document.documentElement).getPropertyValue('--chart-text').trim();

            bookingsChart = new Chart(document.getElementById('bookingsChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                    datasets: [{
                        label: 'Bookings', data: [650,780,920,1100,1350,1500,1680,1550,1420,1780,2100,2450],
                        borderColor: '#6366F1', backgroundColor: 'rgba(99,102,241,0.06)',
                        borderWidth: 2.5, fill: true, tension: 0.4,
                        pointBackgroundColor: '#6366F1', pointBorderColor: '#fff', pointBorderWidth: 2,
                        pointRadius: 3, pointHoverRadius: 6
                    }, {
                        label: 'Cancellations', data: [45,52,38,42,35,28,22,30,38,25,18,12],
                        borderColor: '#F472B6', backgroundColor: 'rgba(244,114,182,0.04)',
                        borderWidth: 2, fill: true, tension: 0.4,
                        pointBackgroundColor: '#F472B6', pointBorderColor: '#fff', pointBorderWidth: 2,
                        pointRadius: 2, pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { labels: { color: textColor, font: { family: 'Inter' }, usePointStyle: true, pointStyle: 'circle' } } },
                    scales: {
                        x: { ticks: { color: textColor }, grid: { color: gridColor } },
                        y: { ticks: { color: textColor }, grid: { color: gridColor } }
                    }
                }
            });

            categoriesChart = new Chart(document.getElementById('categoriesChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Restaurants','SPA','Hotels','Fitness','Coworkings','Cinema'],
                    datasets: [{
                        data: [35,20,18,12,8,7],
                        backgroundColor: ['#6366F1','#06D6A0','#F472B6','#FBBF24','#a18cd1','#89f7fe'],
                        borderWidth: 0, hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { color: textColor, font: { family: 'Inter', size: 11 }, usePointStyle: true, pointStyle: 'circle', padding: 12 } }
                    },
                    cutout: '68%'
                }
            });
        }

        function updateChartsTheme() {
            if (!chartsCreated) return;
            const gridColor = getComputedStyle(document.documentElement).getPropertyValue('--chart-grid').trim();
            const textColor = getComputedStyle(document.documentElement).getPropertyValue('--chart-text').trim();
            [bookingsChart, categoriesChart].forEach(chart => {
                if (chart) {
                    chart.options.scales?.x && (chart.options.scales.x.ticks.color = textColor);
                    chart.options.scales?.y && (chart.options.scales.y.ticks.color = textColor);
                    chart.options.scales?.x && (chart.options.scales.x.grid.color = gridColor);
                    chart.options.scales?.y && (chart.options.scales.y.grid.color = gridColor);
                    chart.options.plugins.legend.labels.color = textColor;
                    chart.update();
                }
            });
        }

        renderBusinesses();
        renderTeam();

        window.addEventListener('scroll', () => {
            document.querySelector('.navbar').style.borderBottomColor =
                window.scrollY > 30 ? 'var(--border)' : 'var(--border-light)';
        });
    </script>
</body>
</html>

