<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolarCare - Standard User Views</title>
    <style>
        /* Base Reset & Layout */
        body { margin: 0; font-family: sans-serif; display: flex; height: 100vh; overflow: hidden; background-color: #f4f6f9; }
        
        /* Sidebar Styling */
        .sidebar { width: 250px; background-color: #343a40; color: white; display: flex; flex-direction: column; }
        .sidebar h2 { text-align: center; padding: 15px 0; margin: 0; border-bottom: 1px solid #4f5962; font-size: 1.2rem; }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 15px 20px; display: block; border-bottom: 1px solid #4f5962; cursor: pointer; }
        .sidebar a:hover, .sidebar a.active-nav { background-color: #4f5962; color: white; }
        
        /* Main Area Setup */
        .main-wrapper { flex-grow: 1; display: flex; flex-direction: column; }
        
        /* Navbar Styling */
        .navbar { background-color: #ffffff; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #dee2e6; }
        .navbar .page-title { font-weight: bold; color: #333; font-size: 1.1rem; }
        .navbar .user-profile { font-size: 0.9rem; color: #666; }

        /* Content Container */
        .content { padding: 30px; overflow-y: auto; }
        .view-section { display: none; }
        .view-section.active { display: block; }
        
        /* Card & Form Styling */
        .card { background: white; border: 1px solid #dee2e6; padding: 25px; border-radius: 5px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 0.9rem; color: #333;}
        input[type="number"], input[type="text"] { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; background-color: #fff; }
        input[readonly] { background-color: #e9ecef; color: #495057; }
        button { padding: 10px 15px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 4px; font-size: 1rem; }
        button:hover { background: #0056b3; }
        
        /* Badges */
        .badge { display: inline-block; padding: 5px 12px; border-radius: 12px; font-weight: bold; font-size: 0.85rem; }
        .badge-green { background-color: #28a745; color: white; }
        .badge-yellow { background-color: #ffc107; color: #212529; }
        .badge-red { background-color: #dc3545; color: white; }
        
        /* Simple Tables for Static Data */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6; font-size: 0.9rem; }
        th { background-color: #f8f9fa; color: #495057; }
        
        #result-section { margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; display: none; }
        #booking-action { margin-top: 15px; display: none; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>SolarCare</h2>
        <a onclick="switchView('view-dashboard', this, 'Dashboard')" class="active-nav">Dashboard</a>
        <a onclick="switchView('view-log', this, 'Log Production')">Log Production</a>
        <a onclick="switchView('view-alerts', this, 'Diagnostic Alerts')">Diagnostic Alerts</a>
        <a onclick="switchView('view-bookings', this, 'Service Bookings')">Service Bookings</a>
        <a onclick="switchView('view-specs', this, 'System Specs')">System Specs</a>
    </div>

    <div class="main-wrapper">
        <div class="navbar">
            <div class="page-title" id="nav-title">Dashboard</div>
            <div class="user-profile">Standard User Account</div>
        </div>

        <div class="content">
            
            <!-- VIEW: Dashboard -->
            <div id="view-dashboard" class="view-section active">
                <div class="card">
                    <h3 style="margin-top: 0;">Health Summary Report</h3>
                    <p style="color: #666; font-size: 0.9rem;">Overview of your residential solar array health based on recent generation trends.</p>
                    
                    <div style="display: flex; gap: 20px; margin-top: 20px;">
                        <div style="flex: 1; padding: 15px; border: 1px solid #dee2e6; border-radius: 4px; text-align: center;">
                            <h4 style="margin: 0 0 10px 0; color: #666;">Current Status</h4>
                            <span class="badge badge-yellow">Degraded</span>
                        </div>
                        <div style="flex: 1; padding: 15px; border: 1px solid #dee2e6; border-radius: 4px; text-align: center;">
                            <h4 style="margin: 0 0 10px 0; color: #666;">Active Bookings</h4>
                            <span style="font-size: 1.2rem; font-weight: bold;">1</span>
                        </div>
                        <div style="flex: 1; padding: 15px; border: 1px solid #dee2e6; border-radius: 4px; text-align: center;">
                            <h4 style="margin: 0 0 10px 0; color: #666;">Avg Efficiency (7 Days)</h4>
                            <span style="font-size: 1.2rem; font-weight: bold;">74%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VIEW: Log Production (Core Algorithm) -->
            <div id="view-log" class="view-section">
                <div class="card" style="max-width: 500px;">
                    <h3 style="margin-top: 0;">Log Daily Generation</h3>
                    <p style="color: #666; font-size: 0.9rem;">Log daily kilowatt-hour (kWh) production figures</p>

                    <div class="form-group">
                        <label>Baseline Expected Capacity (kWh):</label>
                        <input type="number" id="baselineCapacity" value="30" readonly>
                    </div>
                    <div class="form-group">
                        <label>Actual Logged Daily Generation (kWh):</label>
                        <input type="number" id="actualOutput" placeholder="e.g., 28" required>
                    </div>

                    <button onclick="calculateHealth()" style="width: 100%;">Calculate Health Score</button>

                    <div id="result-section">
                        <h4 style="margin-bottom: 5px;">Diagnostic Result:</h4>
                        <span id="status-badge" class="badge"></span>
                        <p id="recommendation-text" style="font-size: 0.9rem; color: #444;"></p>
                        <div id="booking-action">
                            <button style="background: #28a745; width: 100%;" onclick="switchView('view-bookings', document.querySelectorAll('.sidebar a')[3], 'Service Bookings')">Book Maintenance Service</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VIEW: Diagnostic Alerts -->
            <div id="view-alerts" class="view-section">
                <div class="card">
                    <h3 style="margin-top: 0;">Automated System Health Diagnostic Indicators</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Details / Warning</th>
                                <th>Action Required</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Oct 06, 2026</td>
                                <td><span class="badge badge-yellow">Degraded</span></td>
                                <td>Performance drop warning: 72% efficiency detected</td>
                                <td>Schedule Cleaning</td>
                            </tr>
                            <tr>
                                <td>Oct 05, 2026</td>
                                <td><span class="badge badge-green">Optimal</span></td>
                                <td>System operating at expected baseline capacity.</td>
                                <td>None</td>
                            </tr>
                            <tr>
                                <td>Sep 12, 2026</td>
                                <td><span class="badge badge-red">Critical Fault</span></td>
                                <td>Severe efficiency loss. Possible component failure.</td>
                                <td>Inverter Checkup</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- VIEW: Service Bookings -->
            <div id="view-bookings" class="view-section">
                <div class="card">
                    <h3 style="margin-top: 0;">Track Status of Ongoing Service Bookings</h3>
                    <div style="margin-bottom: 20px;">
                        <button style="background: #28a745;">+ New Service Booking</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Booking Ref</th>
                                <th>Service Type</th>
                                <th>Scheduled Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#BK-1042</td>
                                <td>System Cleaning & Inspection</td>
                                <td>Oct 10, 2026 - 09:00 AM</td>
                                <td><span class="badge" style="background: #17a2b8; color: white;">Assigned to Technician</span></td>
                            </tr>
                            <tr>
                                <td>#BK-0891</td>
                                <td>Inverter Checkup</td>
                                <td>Sep 15, 2026 - 02:00 PM</td>
                                <td><span class="badge" style="background: #6c757d; color: white;">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- VIEW: System Specs -->
            <div id="view-specs" class="view-section">
                <div class="card" style="max-width: 600px;">
                    <h3 style="margin-top: 0;">Manage Solar Equipment Baseline Specifications</h3>
                    <p style="color: #666; font-size: 0.9rem;">These static hardware details are used by the algorithm to determine your health status.</p>
                    
                    <div class="form-group">
                        <label>System Capacity (kWp)</label>
                        <input type="text" value="5.5 kWp" readonly>
                    </div>
                    <div class="form-group">
                        <label>Expected Daily Baseline (kWh)</label>
                        <input type="number" value="30" readonly>
                    </div>
                    <div class="form-group">
                        <label>Inverter Type</label>
                        <input type="text" value="String Inverter (Non-Smart)" readonly>
                        <small style="color: #666;">Note: No Automated IoT Data Collection available</small>
                    </div>
                    <div class="form-group">
                        <label>Installation Date</label>
                        <input type="text" value="Jan 15, 2024" readonly>
                    </div>
                    
                    <button style="background: #6c757d;">Request Specification Update</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        // SPA View Switcher
        function switchView(viewId, navElement, title) {
            // Hide all sections
            document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
            // Remove active state from all nav links
            document.querySelectorAll('.sidebar a').forEach(el => el.classList.remove('active-nav'));
            
            // Show target section and highlight nav
            document.getElementById(viewId).classList.add('active');
            navElement.classList.add('active-nav');
            
            // Update Top Navbar Title
            document.getElementById('nav-title').textContent = title;
        }

        // Diagnostic Logic
        function calculateHealth() {
            const baseline = parseFloat(document.getElementById('baselineCapacity').value);
            const actual = parseFloat(document.getElementById('actualOutput').value);
            
            if (!baseline || !actual) {
                alert("Please enter valid numbers.");
                return;
            }

            const efficiency = actual / baseline;
            const resultSection = document.getElementById('result-section');
            const statusBadge = document.getElementById('status-badge');
            const recommendationText = document.getElementById('recommendation-text');
            const bookingAction = document.getElementById('booking-action');

            statusBadge.className = 'badge';
            bookingAction.style.display = 'none';
            resultSection.style.display = 'block';

            if (efficiency >= 0.90) {
                statusBadge.textContent = "Optimal";
                statusBadge.classList.add("badge-green");
                recommendationText.textContent = "Your solar array is operating at peak efficiency.";
            } 
            else if (efficiency >= 0.70) {
                statusBadge.textContent = "Degraded";
                statusBadge.classList.add("badge-yellow");
                recommendationText.textContent = "Warning: Generation has dropped. Dirt accumulation or minor hardware degradation suspected.";
                bookingAction.style.display = 'block';
            } 
            else {
                statusBadge.textContent = "Critical Fault Detected";
                statusBadge.classList.add("badge-red");
                recommendationText.textContent = "Alert: Severe efficiency loss detected. Immediate inverter checkup or parts replacement recommended.";
                bookingAction.style.display = 'block';
            }
        }
    </script>
</body>
</html>