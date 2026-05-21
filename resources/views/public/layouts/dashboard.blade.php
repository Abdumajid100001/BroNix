<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bronix — Платформа для бронирования</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0a0a0f;
            --bg-soft: #111119;
            --surface: #16161f;
            --surface-soft: #1c1c28;
            --border: rgba(255, 255, 255, 0.06);
            --text: #f0f0f5;
            --text-secondary: #b0b0c0;
            --text-muted: #6b6b80;
            --primary: #7c3aed;
            --primary-light: #a78bfa;
            --primary-glow: rgba(124, 58, 237, 0.3);
            --accent: #06b6d4;
            --accent-glow: rgba(6, 182, 212, 0.3);
            --gradient-1: linear-gradient(135deg, #7c3aed, #2563eb);
            --gradient-2: linear-gradient(135deg, #06b6d4, #7c3aed);
            --radius: 16px;
            --radius-lg: 24px;
            --radius-xl: 32px;
            --transition-theme: background 0.4s ease, color 0.4s ease, border-color 0.4s ease, background-color 0.4s ease;
        }

        body.light {
            --bg: #f8f9fc;
            --bg-soft: #f1f3f8;
            --surface: #ffffff;
            --surface-soft: #f5f6fa;
            --border: rgba(0, 0, 0, 0.08);
            --text: #0f0f1a;
            --text-secondary: #4a4a5e;
            --text-muted: #7a7a90;
            --primary-glow: rgba(124, 58, 237, 0.15);
            --accent-glow: rgba(6, 182, 212, 0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
            transition: var(--transition-theme);
        }

        .bg-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px; pointer-events: none; transition: opacity 0.4s ease;
        }
        body.light .bg-grid {
            background-image: linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px);
        }

        .bg-glow { position: fixed; border-radius: 50%; filter: blur(120px); pointer-events: none; z-index: 0; transition: opacity 0.4s ease; }
        .bg-glow-1 { width: 600px; height: 600px; background: var(--primary-glow); top: -200px; left: -100px; opacity: 0.4; }
        .bg-glow-2 { width: 500px; height: 500px; background: var(--accent-glow); top: 40%; right: -150px; opacity: 0.3; }
        .bg-glow-3 { width: 400px; height: 400px; background: rgba(236, 72, 153, 0.2); bottom: 10%; left: 20%; opacity: 0.25; }

        .nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 0 2rem; transition: all 0.3s ease; }
        .nav.scrolled { background: rgba(10, 10, 15, 0.85); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }
        body.light .nav.scrolled { background: rgba(248, 249, 252, 0.85); }
        .nav-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 72px; }
        .nav-logo { display: flex; align-items: center; gap: 0.6rem; font-weight: 800; font-size: 1.35rem; letter-spacing: -0.02em; color: var(--text); text-decoration: none; transition: color 0.4s ease; }
        .nav-logo-icon { width: 36px; height: 36px; background: var(--gradient-1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1rem; color: white; box-shadow: 0 4px 16px var(--primary-glow); }
        .nav-links { display: flex; align-items: center; gap: 0.25rem; list-style: none; }
        .nav-links a { padding: 0.5rem 1rem; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; border-radius: 10px; transition: all 0.2s ease; }
        .nav-links a:hover { color: var(--text); background: rgba(255,255,255,0.04); }
        body.light .nav-links a:hover { background: rgba(0,0,0,0.04); }
        .nav-actions { display: flex; align-items: center; gap: 0.75rem; }

        .theme-toggle { width: 42px; height: 42px; border-radius: 12px; border: 1px solid var(--border); background: var(--surface); color: var(--text); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.25s ease; font-size: 1.1rem; }
        .theme-toggle:hover { background: var(--surface-soft); transform: translateY(-1px); border-color: var(--primary); color: var(--primary); }
        .theme-toggle .icon-sun, .theme-toggle .icon-moon { transition: all 0.3s ease; }
        .theme-toggle .icon-sun { display: none; }
        .theme-toggle .icon-moon { display: block; }
        body.light .theme-toggle .icon-sun { display: block; }
        body.light .theme-toggle .icon-moon { display: none; }

        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.65rem 1.4rem; border-radius: 12px; font-size: 0.9rem; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: all 0.25s ease; white-space: nowrap; }
        .btn-ghost { background: transparent; color: var(--text-muted); border: 1px solid var(--border); transition: var(--transition-theme); }
        .btn-ghost:hover { color: var(--text); background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.12); }
        body.light .btn-ghost:hover { background: rgba(0,0,0,0.04); border-color: rgba(0,0,0,0.15); }
        .btn-primary { background: var(--gradient-1); color: white; box-shadow: 0 4px 16px var(--primary-glow); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px var(--primary-glow); }
        .btn-large { padding: 0.9rem 2rem; font-size: 1rem; border-radius: 14px; }
        .btn-outline { background: transparent; color: var(--primary); border: 1.5px solid rgba(124, 58, 237, 0.3); }
        .btn-outline:hover { background: rgba(124, 58, 237, 0.08); border-color: var(--primary); transform: translateY(-1px); }
        .mobile-toggle { display: none; background: none; border: none; color: var(--text); font-size: 1.5rem; cursor: pointer; padding: 0.5rem; }

        .hero { position: relative; z-index: 1; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 8rem 2rem 6rem; text-align: center; }
        .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.4rem 1rem 0.4rem 0.6rem; border-radius: 999px; background: rgba(124, 58, 237, 0.1); border: 1px solid rgba(124, 58, 237, 0.2); color: var(--primary-light); font-size: 0.82rem; font-weight: 600; margin-bottom: 2rem; animation: fadeUp 0.8s ease forwards; }
        body.light .hero-badge { background: rgba(124, 58, 237, 0.06); color: #7c3aed; }
        .hero-badge-dot { width: 8px; height: 8px; background: var(--primary); border-radius: 50%; animation: pulse 2s ease-in-out infinite; }
        .hero h1 { font-size: clamp(2.8rem, 6vw, 5rem); font-weight: 900; letter-spacing: -0.03em; line-height: 1.05; margin-bottom: 1.5rem; animation: fadeUp 0.8s ease 0.1s forwards; opacity: 0; }
        .hero h1 .gradient-text { background: var(--gradient-2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero p { max-width: 600px; margin: 0 auto 2.5rem; color: var(--text-muted); font-size: clamp(1rem, 1.8vw, 1.2rem); line-height: 1.7; animation: fadeUp 0.8s ease 0.2s forwards; opacity: 0; }
        .hero-actions { display: flex; align-items: center; justify-content: center; gap: 1rem; flex-wrap: wrap; animation: fadeUp 0.8s ease 0.3s forwards; opacity: 0; }
        .hero-visual { margin-top: 4rem; animation: fadeUp 0.8s ease 0.4s forwards; opacity: 0; }
        .hero-mockup { max-width: 900px; margin: 0 auto; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-xl); overflow: hidden; box-shadow: 0 24px 80px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.03); transition: var(--transition-theme); }
        body.light .hero-mockup { box-shadow: 0 24px 80px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.05); }
        .mockup-bar { display: flex; align-items: center; gap: 0.5rem; padding: 1rem 1.25rem; background: rgba(255,255,255,0.02); border-bottom: 1px solid var(--border); transition: var(--transition-theme); }
        body.light .mockup-bar { background: rgba(0,0,0,0.02); }
        .mockup-dot { width: 10px; height: 10px; border-radius: 50%; }
        .mockup-dot:nth-child(1) { background: #ef4444; }
        .mockup-dot:nth-child(2) { background: #f59e0b; }
        .mockup-dot:nth-child(3) { background: #22c55e; }
        .mockup-body { padding: 2rem; min-height: 350px; display: grid; grid-template-columns: 200px 1fr; gap: 1.5rem; }
        .mockup-sidebar { display: flex; flex-direction: column; gap: 0.5rem; }
        .mockup-sidebar-item { padding: 0.6rem 0.8rem; border-radius: 10px; background: rgba(255,255,255,0.03); font-size: 0.8rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.6rem; transition: var(--transition-theme); }
        body.light .mockup-sidebar-item { background: rgba(0,0,0,0.03); }
        .mockup-sidebar-item.active { background: rgba(124, 58, 237, 0.15); color: var(--primary-light); }
        body.light .mockup-sidebar-item.active { background: rgba(124, 58, 237, 0.08); color: #7c3aed; }
        .mockup-sidebar-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .mockup-content { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
        .mockup-card { background: rgba(255,255,255,0.03); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.25rem; transition: var(--transition-theme); }
        body.light .mockup-card { background: rgba(0,0,0,0.02); }
        .mockup-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .mockup-card-title { font-size: 0.75rem; color: var(--text-muted); font-weight: 600; transition: color 0.4s ease; }
        .mockup-card-badge { padding: 0.2rem 0.5rem; border-radius: 6px; font-size: 0.65rem; font-weight: 700; }
        .badge-green { background: rgba(34,197,94,0.15); color: #22c55e; }
        .badge-blue { background: rgba(59,130,246,0.15); color: #3b82f6; }
        .badge-purple { background: rgba(124,58,237,0.15); color: #a78bfa; }
        body.light .badge-green { background: rgba(34,197,94,0.1); color: #16a34a; }
        body.light .badge-blue { background: rgba(59,130,246,0.1); color: #2563eb; }
        body.light .badge-purple { background: rgba(124,58,237,0.1); color: #7c3aed; }
        .mockup-stat { font-size: 1.5rem; font-weight: 800; margin-bottom: 0.25rem; transition: color 0.4s ease; }
        .mockup-stat-sub { font-size: 0.7rem; color: var(--text-muted); transition: color 0.4s ease; }
        .mockup-bar-chart { display: flex; align-items: flex-end; gap: 4px; height: 50px; margin-top: 0.75rem; }
        .mockup-bar-item { flex: 1; border-radius: 3px; background: var(--gradient-1); opacity: 0.6; }

        .section { position: relative; z-index: 1; padding: 6rem 2rem; }
        .section-inner { max-width: 1200px; margin: 0 auto; }
        .section-header { text-align: center; max-width: 650px; margin: 0 auto 4rem; }
        .section-label { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.9rem; border-radius: 999px; background: rgba(124, 58, 237, 0.1); border: 1px solid rgba(124, 58, 237, 0.15); color: var(--primary-light); font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 1.25rem; transition: var(--transition-theme); }
        body.light .section-label { background: rgba(124, 58, 237, 0.06); color: #7c3aed; }
        .section-header h2 { font-size: clamp(2rem, 3.5vw, 3rem); font-weight: 800; letter-spacing: -0.02em; line-height: 1.1; margin-bottom: 1rem; }
        .section-header p { color: var(--text-muted); font-size: 1.05rem; line-height: 1.7; transition: color 0.4s ease; }

        .business-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .business-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; transition: all 0.3s ease; cursor: pointer; }
        .business-card:hover { border-color: rgba(124, 58, 237, 0.2); transform: translateY(-4px); box-shadow: 0 16px 48px rgba(0,0,0,0.25); }
        body.light .business-card:hover { box-shadow: 0 16px 48px rgba(0,0,0,0.08); }
        .business-img { height: 180px; background: var(--gradient-1); position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 4rem; }
        .business-img-overlay { position: absolute; inset: 0; background: linear-gradient(180deg, transparent 40%, rgba(0,0,0,0.6)); }
        .business-rating { position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,0.5); backdrop-filter: blur(10px); padding: 0.3rem 0.6rem; border-radius: 8px; font-size: 0.75rem; font-weight: 700; color: white; display: flex; align-items: center; gap: 0.3rem; }
        .business-body { padding: 1.25rem; }
        .business-category { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary-light); margin-bottom: 0.4rem; transition: color 0.4s ease; }
        body.light .business-category { color: var(--primary); }
        .business-name { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.4rem; letter-spacing: -0.01em; }
        .business-location { font-size: 0.82rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.35rem; margin-bottom: 1rem; transition: color 0.4s ease; }
        .business-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 1rem; border-top: 1px solid var(--border); transition: border-color 0.4s ease; }
        .business-price { font-size: 0.85rem; color: var(--text-muted); transition: color 0.4s ease; }
        .business-price strong { font-size: 1.1rem; color: var(--text); font-weight: 800; transition: color 0.4s ease; }
        .business-book-btn { padding: 0.45rem 1rem; border-radius: 10px; background: var(--gradient-1); color: white; font-size: 0.8rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s ease; }
        .business-book-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px var(--primary-glow); }

        .booking-section { border-top: 1px solid var(--border); }
        .booking-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; }
        .booking-info h3 { font-size: 1.8rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 1rem; }
        .booking-info p { color: var(--text-muted); font-size: 1rem; line-height: 1.7; margin-bottom: 2rem; transition: color 0.4s ease; }
        .booking-steps { display: flex; flex-direction: column; gap: 1.25rem; }
        .booking-step { display: flex; align-items: flex-start; gap: 1rem; }
        .booking-step-num { width: 40px; height: 40px; border-radius: 12px; background: rgba(124, 58, 237, 0.12); color: var(--primary-light); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; flex-shrink: 0; transition: var(--transition-theme); }
        body.light .booking-step-num { background: rgba(124, 58, 237, 0.08); color: var(--primary); }
        .booking-step h4 { font-size: 1rem; font-weight: 700; margin-bottom: 0.2rem; }
        .booking-step p { font-size: 0.88rem; color: var(--text-muted); margin: 0; transition: color 0.4s ease; }
        .booking-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-xl); padding: 2rem; transition: var(--transition-theme); }
        .booking-card h3 { font-size: 1.3rem; font-weight: 700; margin-bottom: 0.3rem; }
        .booking-card-subtitle { color: var(--text-muted); font-size: 0.88rem; margin-bottom: 1.5rem; transition: color 0.4s ease; }
        .booking-form { display: flex; flex-direction: column; gap: 1rem; }
        .booking-field label { display: block; font-size: 0.82rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.4rem; transition: color 0.4s ease; }
        .booking-input { width: 100%; padding: 0.8rem 1rem; border-radius: 12px; border: 1.5px solid var(--border); background: var(--bg); color: var(--text); font-size: 0.9rem; font-family: inherit; transition: var(--transition-theme); }
        .booking-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-glow); }
        body.light .booking-input { background: #f5f6fa; }
        .booking-input::placeholder { color: var(--text-muted); }
        .booking-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .booking-submit { width: 100%; padding: 0.9rem; border-radius: 12px; background: var(--gradient-1); color: white; font-weight: 700; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.25s ease; margin-top: 0.5rem; }
        .booking-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px var(--primary-glow); }

        .stats-section { border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); background: rgba(255,255,255,0.01); transition: var(--transition-theme); }
        body.light .stats-section { background: rgba(0,0,0,0.02); }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; text-align: center; }
        .stat-item { padding: 2rem 1rem; }
        .stat-value { font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; letter-spacing: -0.02em; background: var(--gradient-2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 0.5rem; }
        .stat-label { color: var(--text-muted); font-size: 0.9rem; font-weight: 500; transition: color 0.4s ease; }

        .cta-section { text-align: center; }
        .cta-box { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-xl); padding: 4rem 2rem; position: relative; overflow: hidden; transition: var(--transition-theme); }
        .cta-box::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at center, rgba(124,58,237,0.06), transparent 60%); pointer-events: none; }
        .cta-box h2 { font-size: clamp(2rem, 3.5vw, 3rem); font-weight: 800; letter-spacing: -0.02em; margin-bottom: 1rem; position: relative; }
        .cta-box p { color: var(--text-muted); font-size: 1.1rem; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto; position: relative; transition: color 0.4s ease; }
        .cta-actions { display: flex; align-items: center; justify-content: center; gap: 1rem; position: relative; flex-wrap: wrap; }

        .footer { position: relative; z-index: 1; border-top: 1px solid var(--border); padding: 4rem 2rem 2rem; transition: border-color 0.4s ease; }
        .footer-inner { max-width: 1200px; margin: 0 auto; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 3rem; margin-bottom: 3rem; }
        .footer-brand p { color: var(--text-muted); font-size: 0.9rem; line-height: 1.7; margin-top: 1rem; max-width: 280px; transition: color 0.4s ease; }
        .footer-col h4 { font-size: 0.82rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-muted); margin-bottom: 1rem; transition: color 0.4s ease; }
        .footer-col a { display: block; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; padding: 0.3rem 0; transition: color 0.2s; }
        .footer-col a:hover { color: var(--text); }
        .footer-bottom { border-top: 1px solid var(--border); padding-top: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; transition: border-color 0.4s ease; }
        .footer-bottom p { color: var(--text-muted); font-size: 0.82rem; transition: color 0.4s ease; }
        .footer-socials { display: flex; gap: 0.75rem; }
        .footer-social { width: 36px; height: 36px; border-radius: 10px; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); text-decoration: none; font-size: 1rem; transition: all 0.2s; }
        .footer-social:hover { color: var(--text); border-color: rgba(255,255,255,0.15); background: rgba(255,255,255,0.04); }
        body.light .footer-social:hover { border-color: rgba(0,0,0,0.15); background: rgba(0,0,0,0.04); }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
        .observe { opacity: 0; transform: translateY(40px); transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
        .observe.visible { opacity: 1; transform: translateY(0); }
        .observe-delay-1 { transition-delay: 0.1s; }
        .observe-delay-2 { transition-delay: 0.2s; }
        .observe-delay-3 { transition-delay: 0.3s; }
        .observe-delay-4 { transition-delay: 0.4s; }

        @media (max-width: 1024px) {
            .business-grid { grid-template-columns: repeat(2, 1fr); }
            .booking-layout { grid-template-columns: 1fr; }
            .mockup-body { grid-template-columns: 1fr; }
            .mockup-sidebar { flex-direction: row; overflow-x: auto; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .mobile-toggle { display: block; }
            .business-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .hero { padding: 7rem 1.5rem 4rem; }
            .mockup-content { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; gap: 2rem; }
            .cta-box { padding: 3rem 1.5rem; }
            .booking-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>
    <div class="bg-glow bg-glow-3"></div>

    <nav class="nav" id="nav">
        <div class="nav-inner">
            <a href="#" class="nav-logo">
                <div class="nav-logo-icon">B</div>
                Bronix
            </a>
            <ul class="nav-links">
                <li><a href="#businesses">Бизнесы</a></li>
                <li><a href="#booking">Бронирование</a></li>
                <li><a href="#stats">Статистика</a></li>
                <li><a href="#contact">Контакты</a></li>
            </ul>
            <div class="nav-actions">
                <button class="theme-toggle" id="themeToggle" aria-label="Переключить тему">
                    <span class="icon-sun">☀️</span>
                    <span class="icon-moon">🌙</span>
                </button>
                <a href="#" class="btn btn-ghost">Войти</a>
                <a href="#" class="btn btn-primary">Регистрация</a>
            </div>
            <button class="mobile-toggle" id="mobileToggle">☰</button>
        </div>
    </nav>

    <section class="hero">
        <div>
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Новая платформа бронирования
            </div>
            <h1>Бронируйте<br><span class="gradient-text">лучшие места</span></h1>
            <p>Bronix — удобная платформа для поиска и бронирования ресторанов, салонов, студий и других бизнесов. Быстро, просто, онлайн.</p>
            <div class="hero-actions">
                <a href="#businesses" class="btn btn-primary btn-large">Найти бизнес →</a>
                <a href="#booking" class="btn btn-ghost btn-large">Забронировать</a>
            </div>

            <div class="hero-visual">
                <div class="hero-mockup">
                    <div class="mockup-bar">
                        <div class="mockup-dot"></div>
                        <div class="mockup-dot"></div>
                        <div class="mockup-dot"></div>
                    </div>
                    <div class="mockup-body">
                        <div class="mockup-sidebar">
                            <div class="mockup-sidebar-item active">
                                <div class="mockup-sidebar-dot"></div> Поиск
                            </div>
                            <div class="mockup-sidebar-item">
                                <div class="mockup-sidebar-dot"></div> Мои брони
                            </div>
                            <div class="mockup-sidebar-item">
                                <div class="mockup-sidebar-dot"></div> Избранное
                            </div>
                            <div class="mockup-sidebar-item">
                                <div class="mockup-sidebar-dot"></div> Бизнесам
                            </div>
                        </div>
                        <div class="mockup-content">
                            <div class="mockup-card">
                                <div class="mockup-card-header">
                                    <span class="mockup-card-title">Бронирования</span>
                                    <span class="mockup-card-badge badge-green">+34%</span>
                                </div>
                                <div class="mockup-stat">1,248</div>
                                <div class="mockup-stat-sub">за последний месяц</div>
                            </div>
                            <div class="mockup-card">
                                <div class="mockup-card-header">
                                    <span class="mockup-card-title">Бизнесы</span>
                                    <span class="mockup-card-badge badge-blue">Новые</span>
                                </div>
                                <div class="mockup-stat">856</div>
                                <div class="mockup-stat-sub">активных партнёров</div>
                            </div>
                            <div class="mockup-card">
                                <div class="mockup-card-header">
                                    <span class="mockup-card-title">Рейтинг</span>
                                    <span class="mockup-card-badge badge-purple">4.9★</span>
                                </div>
                                <div class="mockup-bar-chart">
                                    <div class="mockup-bar-item" style="height:40%"></div>
                                    <div class="mockup-bar-item" style="height:65%"></div>
                                    <div class="mockup-bar-item" style="height:45%"></div>
                                    <div class="mockup-bar-item" style="height:80%"></div>
                                    <div class="mockup-bar-item" style="height:55%"></div>
                                    <div class="mockup-bar-item" style="height:90%"></div>
                                    <div class="mockup-bar-item" style="height:70%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="businesses">
        <div class="section-inner">
            <div class="section-header observe">
                <div class="section-label">🏢 Бизнесы</div>
                <h2>Лучшие места для бронирования</h2>
                <p>Рестораны, салоны красоты, студии йоги и многие другие — выбирайте и бронируйте в один клик.</p>
            </div>
            <div class="business-grid">
                <div class="business-card observe observe-delay-1">
                    <div class="business-img">🍽️<div class="business-img-overlay"></div><div class="business-rating">⭐ 4.9</div></div>
                    <div class="business-body">
                        <div class="business-category">Ресторан</div>
                        <div class="business-name">La Maison Gourmet</div>
                        <div class="business-location">📍 Москва, ул. Арбат, 12</div>
                        <div class="business-footer">
                            <div class="business-price">от <strong>2 500 ₽</strong> / чел</div>
                            <button class="business-book-btn" onclick="scrollToBooking('La Maison Gourmet')">Забронировать</button>
                        </div>
                    </div>
                </div>
                <div class="business-card observe observe-delay-2">
                    <div class="business-img">💇‍♀️<div class="business-img-overlay"></div><div class="business-rating">⭐ 4.8</div></div>
                    <div class="business-body">
                        <div class="business-category">Салон красоты</div>
                        <div class="business-name">Studio Elegance</div>
                        <div class="business-location">📍 Санкт-Петербург, Невский, 45</div>
                        <div class="business-footer">
                            <div class="business-price">от <strong>1 800 ₽</strong> / сеанс</div>
                            <button class="business-book-btn" onclick="scrollToBooking('Studio Elegance')">Забронировать</button>
                        </div>
                    </div>
                </div>
                <div class="business-card observe observe-delay-3">
                    <div class="business-img">🧘<div class="business-img-overlay"></div><div class="business-rating">⭐ 4.9</div></div>
                    <div class="business-body">
                        <div class="business-category">Студия йоги</div>
                        <div class="business-name">Zen Space</div>
                        <div class="business-location">📍 Казань, ул. Баумана, 8</div>
                        <div class="business-footer">
                            <div class="business-price">от <strong>900 ₽</strong> / занятие</div>
                            <button class="business-book-btn" onclick="scrollToBooking('Zen Space')">Забронировать</button>
                        </div>
                    </div>
                </div>
                <div class="business-card observe observe-delay-1">
                    <div class="business-img">☕<div class="business-img-overlay"></div><div class="business-rating">⭐ 4.7</div></div>
                    <div class="business-body">
                        <div class="business-category">Кофейня</div>
                        <div class="business-name">Brew & Bean</div>
                        <div class="business-location">📍 Новосибирск, Красный пр., 22</div>
                        <div class="business-footer">
                            <div class="business-price">от <strong>450 ₽</strong> / заказ</div>
                            <button class="business-book-btn" onclick="scrollToBooking('Brew & Bean')">Забронировать</button>
                        </div>
                    </div>
                </div>
                <div class="business-card observe observe-delay-2">
                    <div class="business-img">🏋️<div class="business-img-overlay"></div><div class="business-rating">⭐ 4.8</div></div>
                    <div class="business-body">
                        <div class="business-category">Фитнес</div>
                        <div class="business-name">Iron Temple Gym</div>
                        <div class="business-location">📍 Екатеринбург, Ленина, 50</div>
                        <div class="business-footer">
                            <div class="business-price">от <strong>1 200 ₽</strong> / визит</div>
                            <button class="business-book-btn" onclick="scrollToBooking('Iron Temple Gym')">Забронировать</button>
                        </div>
                    </div>
                </div>
                <div class="business-card observe observe-delay-3">
                    <div class="business-img">🎨<div class="business-img-overlay"></div><div class="business-rating">⭐ 4.6</div></div>
                    <div class="business-body">
                        <div class="business-category">Арт-студия</div>
                        <div class="business-name">Palette Workshop</div>
                        <div class="business-location">📍 Москва, Третьяковский пр., 3</div>
                        <div class="business-footer">
                            <div class="business-price">от <strong>3 000 ₽</strong> / мастер-класс</div>
                            <button class="business-book-btn" onclick="scrollToBooking('Palette Workshop')">Забронировать</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section booking-section" id="booking">
        <div class="section-inner">
            <div class="booking-layout">
                <div class="booking-info observe">
                    <div class="section-label">📅 Бронирование</div>
                    <h3>Забронируйте место за пару кликов</h3>
                    <p>Больше никаких звонков и ожидания ответа. Выберите бизнес, дату и время — мы мгновенно подтвердим вашу бронь.</p>
                    <div class="booking-steps">
                        <div class="booking-step">
                            <div class="booking-step-num">1</div>
                            <div><h4>Выберите бизнес</h4><p>Найдите подходящий ресторан, салон или студию</p></div>
                        </div>
                        <div class="booking-step">
                            <div class="booking-step-num">2</div>
                            <div><h4>Укажите дату и время</h4><p>Выберите удобное время из доступных слотов</p></div>
                        </div>
                        <div class="booking-step">
                            <div class="booking-step-num">3</div>
                            <div><h4>Получите подтверждение</h4><p>Мгновенное подтверждение на email и в приложении</p></div>
                        </div>
                    </div>
                </div>
                <div class="booking-card observe observe-delay-2">
                    <h3>Запись на бронирование</h3>
                    <p class="booking-card-subtitle">Заполните форму и получите подтверждение за 1 минуту</p>
                    <form class="booking-form" onsubmit="handleBooking(event)">
                        <div class="booking-field">
                            <label>Ваше имя</label>
                            <input type="text" class="booking-input" placeholder="Иван Иванов" required>
                        </div>
                        <div class="booking-field">
                            <label>Телефон</label>
                            <input type="tel" class="booking-input" placeholder="+7 (999) 123-45-67" required>
                        </div>
                        <div class="booking-field">
                            <label>Бизнес</label>
                            <input type="text" id="bookingBusiness" class="booking-input" placeholder="Выберите бизнес" required>
                        </div>
                        <div class="booking-row">
                            <div class="booking-field">
                                <label>Дата</label>
                                <input type="date" class="booking-input" required>
                            </div>
                            <div class="booking-field">
                                <label>Время</label>
                                <input type="time" class="booking-input" required>
                            </div>
                        </div>
                        <div class="booking-field">
                            <label>Количество гостей</label>
                            <select class="booking-input">
                                <option>1 человек</option>
                                <option selected>2 человека</option>
                                <option>3 человека</option>
                                <option>4 человека</option>
                                <option>5+ человек</option>
                            </select>
                        </div>
                        <button type="submit" class="booking-submit">Забронировать →</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="section stats-section" id="stats">
        <div class="section-inner">
            <div class="stats-grid">
                <div class="stat-item observe observe-delay-1">
                    <div class="stat-value">12K+</div>
                    <div class="stat-label">Активных пользователей</div>
                </div>
                <div class="stat-item observe observe-delay-2">
                    <div class="stat-value">850+</div>
                    <div class="stat-label">Бизнесов на платформе</div>
                </div>
                <div class="stat-item observe observe-delay-3">
                    <div class="stat-value">50K+</div>
                    <div class="stat-label">Бронирований в месяц</div>
                </div>
                <div class="stat-item observe observe-delay-4">
                    <div class="stat-value">4.9★</div>
                    <div class="stat-label">Средняя оценка</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section cta-section" id="contact">
        <div class="section-inner">
            <div class="cta-box observe">
                <h2>Готовы начать?</h2>
                <p>Присоединяйтесь к тысячам пользователей, которые бронируют любимые места через Bronix.</p>
                <div class="cta-actions">
                    <a href="#" class="btn btn-primary btn-large">Создать аккаунт бесплатно →</a>
                    <a href="#businesses" class="btn btn-outline btn-large">Посмотреть бизнесы</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="#" class="nav-logo">
                        <div class="nav-logo-icon">B</div>
                        Bronix
                    </a>
                    <p>Удобная платформа для поиска и бронирования лучших мест в вашем городе.</p>
                </div>
                <div class="footer-col">
                    <h4>Платформа</h4>
                    <a href="#businesses">Каталог бизнесов</a>
                    <a href="#booking">Бронирование</a>
                    <a href="#">Для бизнеса</a>
                    <a href="#">Приложение</a>
                </div>
                <div class="footer-col">
                    <h4>Компания</h4>
                    <a href="#">О нас</a>
                    <a href="#">Блог</a>
                    <a href="#">Карьера</a>
                    <a href="#">Контакты</a>
                </div>
                <div class="footer-col">
                    <h4>Поддержка</h4>
                    <a href="#">Помощь</a>
                    <a href="#">FAQ</a>
                    <a href="#">Условия</a>
                    <a href="#">Конфиденциальность</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2026 Bronix. Все права защищены.</p>
                <div class="footer-socials">
                    <a href="#" class="footer-social" title="Telegram">✈</a>
                    <a href="#" class="footer-social" title="GitHub">⌘</a>
                    <a href="#" class="footer-social" title="Twitter">𝕏</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;

        function applyTheme(isLight) {
            body.classList.toggle('light', isLight);
            localStorage.setItem('bronix-theme', isLight ? 'light' : 'dark');
        }

        const savedTheme = localStorage.getItem('bronix-theme');
        if (savedTheme === 'light') applyTheme(true);

        themeToggle.addEventListener('click', () => applyTheme(!body.classList.contains('light')));

        const nav = document.getElementById('nav');
        window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 20));

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.observe').forEach(el => observer.observe(el));

        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', (e) => {
                const target = document.querySelector(link.getAttribute('href'));
                if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
            });
        });

        function scrollToBooking(businessName) {
            const input = document.getElementById('bookingBusiness');
            input.value = businessName;
            document.getElementById('booking').scrollIntoView({ behavior: 'smooth' });
            setTimeout(() => input.focus(), 500);
        }

        function handleBooking(e) {
            e.preventDefault();
            const btn = e.target.querySelector('.booking-submit');
            const originalText = btn.textContent;
            btn.textContent = '✓ Бронирование подтверждено!';
            btn.style.background = 'linear-gradient(135deg, #22c55e, #16a34a)';
            setTimeout(() => {
                btn.textContent = originalText;
                btn.style.background = '';
                e.target.reset();
            }, 3000);
        }
    </script>
</body>
</html>