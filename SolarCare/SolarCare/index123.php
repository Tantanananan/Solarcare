<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolarCare - Solar Panel Maintenance</title>
    <meta name="description" content="SolarCare helps residential solar panel owners monitor system health, explore maintenance services, and book certified technicians.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* ── Top Navigation ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            height: 60px;
        }

        .navbar .brand {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a1a2e;
            text-decoration: none;
        }

        .navbar .brand span { color: #007bff; }

        .nav-links {
            display: flex;
            gap: 5px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.9rem;
            color: #555;
            transition: background 0.2s, color 0.2s;
            cursor: pointer;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background: #f0f4ff;
            color: #007bff;
        }

        .nav-cta {
            background: #007bff;
            color: #fff !important;
            border-radius: 6px;
            padding: 8px 18px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: background 0.2s;
        }

        .nav-cta:hover { background: #0056b3 !important; color: #fff !important; }

        /* ── Page Sections ── */
        .page { display: none; }
        .page.active { display: block; }

        /* ── Hero Section ── */
        .hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
            color: #fff;
            padding: 80px 40px;
            text-align: center;
        }

        .hero h1 {
            font-size: 2.4rem;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.3;
        }

        .hero h1 span { color: #4da8ff; }

        .hero p {
            font-size: 1.05rem;
            color: #b0c4de;
            max-width: 560px;
            margin: 0 auto 32px;
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            width: auto;
        }

        .btn-primary:hover { background: #0056b3; }

        .btn-outline {
            background: transparent;
            color: #fff;
            border: 1.5px solid rgba(255,255,255,0.4);
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            width: auto;
        }

        .btn-outline:hover { border-color: #fff; background: rgba(255,255,255,0.07); }

        /* ── Info Cards (homepage) ── */
        .section { padding: 60px 40px; max-width: 960px; margin: 0 auto; }
        .section-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 8px; color: #1a1a2e; }
        .section-sub { font-size: 0.95rem; color: #666; margin-bottom: 36px; }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
        }

        .info-card {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            padding: 28px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .info-card .icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #e8f0fe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 16px;
        }

        .info-card h3 { font-size: 1rem; font-weight: 700; margin-bottom: 8px; color: #1a1a2e; }
        .info-card p { font-size: 0.88rem; color: #666; line-height: 1.6; }

        /* ── Divider ── */
        .divider { border: none; border-top: 1px solid #eee; margin: 0 40px; }

        /* ── Calculator Page ── */
        .page-header {
            background: #fff;
            border-bottom: 1px solid #eee;
            padding: 40px 40px 32px;
        }

        .page-header h1 { font-size: 1.6rem; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
        .page-header p { font-size: 0.92rem; color: #666; }

        .calc-wrapper {
            max-width: 520px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .form-card {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 7px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d0d0d0;
            border-radius: 7px;
            font-size: 0.95rem;
            background: #fff;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }

        .form-group input:focus { outline: none; border-color: #007bff; }

        .result-box {
            margin-top: 24px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e8e8e8;
            display: none;
        }

        .result-box .result-label { font-size: 0.82rem; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }

        .badge {
            display: inline-block;
            padding: 5px 14px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.82rem;
        }

        .badge-green { background: #d4edda; color: #155724; }
        .badge-yellow { background: #fff3cd; color: #856404; }
        .badge-red { background: #f8d7da; color: #721c24; }

        .result-text { font-size: 0.88rem; color: #555; margin-top: 10px; line-height: 1.6; }

        .upsell-box {
            margin-top: 16px;
            padding: 16px;
            background: #e8f0fe;
            border-radius: 8px;
            text-align: center;
        }

        .upsell-box p { font-size: 0.85rem; color: #444; margin-bottom: 10px; }

        /* ── Pricing / Catalog ── */
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .pricing-card {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            padding: 28px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .pricing-card .service-type {
            font-size: 0.75rem;
            font-weight: 700;
            color: #007bff;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 8px;
        }

        .pricing-card h3 { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin-bottom: 8px; }
        .pricing-card p { font-size: 0.85rem; color: #666; line-height: 1.6; margin-bottom: 16px; }

        .price-tag { font-size: 1.4rem; font-weight: 700; color: #1a1a2e; }
        .price-tag span { font-size: 0.85rem; font-weight: 400; color: #888; }

        /* ── Registration ── */
        .register-wrapper {
            max-width: 480px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .note-text {
            font-size: 0.8rem;
            color: #888;
            text-align: center;
            margin-top: 16px;
            line-height: 1.6;
        }

        button { width: auto; }

        .btn-full {
            width: 100%;
            background: #28a745;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-full:hover { background: #218838; }

        .btn-block {
            display: block;
            width: 100%;
            background: #007bff;
            color: #fff;
            border: none;
            padding: 11px;
            border-radius: 7px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-block:hover { background: #0056b3; }

        .btn-green-block {
            display: block;
            width: 100%;
            background: #28a745;
            color: #fff;
            border: none;
            padding: 11px;
            border-radius: 7px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-green-block:hover { background: #218838; }
    </style>
</head>
<body>

    <!-- ── Top Navigation ── -->
    <nav class="navbar">
        <a class="brand" href="#"><Solar></Solar>Solar<span>Care</span></a>
        <ul class="nav-links">
            <li><a id="nav-portal"  onclick="showPage('page-portal',  this)" class="active">Home</a></li>
            <li><a id="nav-demo"    onclick="showPage('page-demo',    this)">Health Check</a></li>
            <li><a id="nav-catalog" onclick="showPage('page-catalog', this)">Services</a></li>
        </ul>
        <a class="nav-cta" onclick="showPage('page-register', null)">Register Free</a>
    </nav>

    <!-- ══════════════════════════════════ -->
    <!-- PAGE: Home / Informational Portal -->
    <!-- ══════════════════════════════════ -->
    <div id="page-portal" class="page active">

        <!-- Hero -->
        <div class="hero">
            <h1>Keep Your Solar Array<br><span>Running at Peak Power</span></h1>
            <p>Monitor system health, spot efficiency drops early, and book certified technicians — all in one place.</p>
            <div class="hero-actions">
                <button class="btn-primary" onclick="showPage('page-demo', document.getElementById('nav-demo'))">Try Health Check</button>
                <button class="btn-outline" onclick="showPage('page-catalog', document.getElementById('nav-catalog'))">View Services</button>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="section">
            <p class="section-title">Common Signs Your System Needs Attention</p>
            <p class="section-sub">Residential solar panels degrade gradually. Here's what to look out for.</p>

            <div class="info-grid">
                <div class="info-card">
                    <div class="icon">📉</div>
                    <h3>Unexplained Drop in Bill Savings</h3>
                    <p>If your electricity bill has spiked despite consistent weather, your panels may be suffering from dirt accumulation or micro-cracks in the cells.</p>
                </div>
                <div class="info-card">
                    <div class="icon">🔆</div>
                    <h3>Reduced Daily Generation</h3>
                    <p>A noticeable drop in daily kWh output compared to your baseline is a strong indicator that a cleaning or inspection is overdue.</p>
                </div>
                <div class="info-card">
                    <div class="icon">🛠️</div>
                    <h3>When to Schedule Cleaning</h3>
                    <p>It is recommended to schedule a professional cleaning at least twice a year to prevent degraded generation levels from accumulating.</p>
                </div>
            </div>
        </div>

    </div>

    <!-- ══════════════════════════════════ -->
    <!-- PAGE: Health Demo Calculator      -->
    <!-- ══════════════════════════════════ -->
    <div id="page-demo" class="page">

        <div class="page-header">
            <h1>Solar Health Check</h1>
            <p>Estimate your system's efficiency by comparing expected vs. actual production figures.</p>
        </div>

        <div class="calc-wrapper">
            <div class="form-card">
                <div class="form-group">
                    <label>Expected Monthly Production (kWh)</label>
                    <input type="number" id="demoExpected" placeholder="e.g., 900">
                </div>
                <div class="form-group">
                    <label>Actual Recent Production (kWh)</label>
                    <input type="number" id="demoActual" placeholder="e.g., 750">
                </div>

                <button class="btn-block" onclick="calculateDemoHealth()">Estimate System Health</button>

                <div class="result-box" id="result-section">
                    <div class="result-label">Estimated Result</div>
                    <span class="badge" id="demo-badge"></span>
                    <p class="result-text" id="demo-text"></p>

                    <div class="upsell-box" id="upsell-box" style="display:none;">
                        <p>Want to track this daily and schedule a technician?</p>
                        <button class="btn-green-block" onclick="showPage('page-register', null)">Register a Free Owner Account</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ══════════════════════════════════ -->
    <!-- PAGE: Service & Pricing Catalog   -->
    <!-- ══════════════════════════════════ -->
    <div id="page-catalog" class="page">

        <div class="page-header">
            <h1>Service Packages</h1>
            <p>Explore our maintenance services and pricing. All work is carried out by certified technicians.</p>
        </div>

        <div class="section">
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="service-type">Service</div>
                    <h3>Standard System Cleaning</h3>
                    <p>Removal of dirt, dust, and debris from solar panels to restore generation capacity.</p>
                    <div class="price-tag">₱1,200 <span>/ session</span></div>
                </div>
                <div class="pricing-card">
                    <div class="service-type">Inspection</div>
                    <h3>Preventative Inspection</h3>
                    <p>Thorough visual check of panels, wiring, and inverter status to catch issues early.</p>
                    <div class="price-tag">₱1,500 <span>/ session</span></div>
                </div>
                <div class="pricing-card">
                    <div class="service-type">Diagnostic</div>
                    <h3>Inverter Diagnostic</h3>
                    <p>Troubleshooting for critical fault errors and power flow issues in string inverter setups.</p>
                    <div class="price-tag">₱2,500 <span>/ session</span></div>
                </div>
            </div>

            <div style="text-align:center; margin-top: 40px;">
                <p style="font-size: 0.9rem; color: #888; margin-bottom: 16px;">Ready to book a service? Create a free owner account to get started.</p>
                <button class="btn-primary" onclick="showPage('page-register', null)">Register Free</button>
            </div>
        </div>

    </div>

    <!-- ══════════════════════════════════ -->
    <!-- PAGE: Account Registration        -->
    <!-- ══════════════════════════════════ -->
    <div id="page-register" class="page">

        <div class="page-header">
            <h1>Create Your Account</h1>
            <p>Register to track solar health daily and access appointment scheduling.</p>
        </div>

        <div class="register-wrapper">
            <div class="form-card">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" placeholder="e.g., Juan Dela Cruz">
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" placeholder="juan@example.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" placeholder="••••••••">
                </div>
                <button class="btn-full">Create Account</button>
                <p class="note-text">After registering, an administrator will review your account before granting access to diagnostic logging and service booking tools.</p>
            </div>
        </div>

    </div>

    <script>
        function showPage(pageId, navEl) {
            // Hide all pages
            document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
            // Clear active nav
            document.querySelectorAll('.nav-links a').forEach(a => a.classList.remove('active'));

            document.getElementById(pageId).classList.add('active');
            if (navEl) navEl.classList.add('active');

            window.scrollTo(0, 0);
        }

        function calculateDemoHealth() {
            const expected = parseFloat(document.getElementById('demoExpected').value);
            const actual   = parseFloat(document.getElementById('demoActual').value);

            if (!expected || !actual || expected <= 0) {
                alert('Please enter valid numbers.');
                return;
            }

            const efficiency    = actual / expected;
            const resultSection = document.getElementById('result-section');
            const demoBadge     = document.getElementById('demo-badge');
            const demoText      = document.getElementById('demo-text');
            const upsellBox     = document.getElementById('upsell-box');

            demoBadge.className = 'badge';
            resultSection.style.display = 'block';
            upsellBox.style.display = 'none';

            if (efficiency >= 0.90) {
                demoBadge.textContent = '✓ Optimal';
                demoBadge.classList.add('badge-green');
                demoText.textContent = 'Your production looks great based on these figures. Keep up the regular maintenance.';
            } else if (efficiency >= 0.70) {
                const loss = Math.round((1 - efficiency) * 100);
                demoBadge.textContent = `⚠ Degraded — ${loss}% Loss`;
                demoBadge.classList.add('badge-yellow');
                demoText.textContent = 'Your inputs suggest a noticeable efficiency drop. A cleaning or inspection is likely needed.';
                upsellBox.style.display = 'block';
            } else {
                const loss = Math.round((1 - efficiency) * 100);
                demoBadge.textContent = `✕ Critical Fault — ${loss}% Loss`;
                demoBadge.classList.add('badge-red');
                demoText.textContent = 'Severe efficiency drop detected. Your system likely requires immediate professional diagnosis.';
                upsellBox.style.display = 'block';
            }
        }
    </script>

</body>
</html>
