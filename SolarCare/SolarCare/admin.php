<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolarCare - Admin Operations</title>
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
        .navbar .user-profile { font-size: 0.9rem; color: #666; font-weight: bold; }

        /* Content Container */
        .content { padding: 30px; overflow-y: auto; }
        .view-section { display: none; }
        .view-section.active { display: block; }
        
        /* Card & Form Styling */
        .card { background: white; border: 1px solid #dee2e6; padding: 25px; border-radius: 5px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 0.9rem; color: #333;}
        input[type="number"], input[type="text"], select { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; background-color: #fff; }
        button { padding: 8px 12px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 4px; font-size: 0.9rem; }
        button:hover { background: #0056b3; }
        button.btn-sm { padding: 5px 8px; font-size: 0.8rem; }
        button.btn-success { background: #28a745; }
        
        /* Badges */
        .badge { display: inline-block; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 0.75rem; }
        .badge-green { background-color: #28a745; color: white; }
        .badge-yellow { background-color: #ffc107; color: #212529; }
        .badge-red { background-color: #dc3545; color: white; }
        
        /* Simple Tables for Static Data */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6; font-size: 0.9rem; }
        th { background-color: #f8f9fa; color: #495057; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>SolarCare</h2>
        <a onclick="switchView('view-dashboard', this, 'Executive Dashboard')" class="active-nav">Dashboard</a>
        <a onclick="switchView('view-accounts', this, 'Account & Profile Management')">Manage Accounts</a>
        <a onclick="switchView('view-bookings', this, 'Service Booking Dispatch')">Manage Bookings</a>
        <a onclick="switchView('view-rules', this, 'Diagnostic Threshold Rules')">Diagnostic Rules</a>
        <a onclick="switchView('view-catalog', this, 'Service & Pricing Catalog')">Service Catalog</a>
    </div>

    <div class="main-wrapper">
        <div class="navbar">
            <div class="page-title" id="nav-title">Executive Dashboard</div>
            <div class="user-profile">Administrator</div>
        </div>

        <div class="content">
            
            <!-- VIEW: Dashboard -->
            <div id="view-dashboard" class="view-section active">
                <div class="card">
                    <h3 style="margin-top: 0;">Operational Reports Overview</h3>
                    <p style="color: #666; font-size: 0.9rem;">High-level view covering platform health trends, total bookings, and revenue metrics.</p>
                    
                    <div style="display: flex; gap: 20px; margin-top: 20px;">
                        <div style="flex: 1; padding: 15px; border: 1px solid #dee2e6; border-radius: 4px; text-align: center;">
                            <h4 style="margin: 0 0 10px 0; color: #666;">Total Active Bookings</h4>
                            <span style="font-size: 1.5rem; font-weight: bold;">12</span>
                        </div>
                        <div style="flex: 1; padding: 15px; border: 1px solid #dee2e6; border-radius: 4px; text-align: center;">
                            <h4 style="margin: 0 0 10px 0; color: #666;">Pending Verifications</h4>
                            <span style="font-size: 1.5rem; font-weight: bold;">3</span>
                        </div>
                        <div style="flex: 1; padding: 15px; border: 1px solid #dee2e6; border-radius: 4px; text-align: center;">
                            <h4 style="margin: 0 0 10px 0; color: #666;">Systems in Fault Status</h4>
                            <span class="badge badge-red" style="font-size: 1.2rem;">4</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VIEW: Manage Accounts -->
            <div id="view-accounts" class="view-section">
                <div class="card">
                    <h3 style="margin-top: 0;">User & Technician Management</h3>
                    <p style="color: #666; font-size: 0.9rem;">Verify user registrations, view customer history, and manage technician profiles.</p>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Juan Dela Cruz</td>
                                <td>Standard User (Owner)</td>
                                <td><span class="badge badge-yellow">Pending Verification</span></td>
                                <td><button class="btn-sm btn-success">Verify</button></td>
                            </tr>
                            <tr>
                                <td>Mark Reyes</td>
                                <td>Technician</td>
                                <td><span class="badge badge-green">Active</span></td>
                                <td><button class="btn-sm">Edit Profile</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- VIEW: Manage Bookings -->
            <div id="view-bookings" class="view-section">
                <div class="card">
                    <h3 style="margin-top: 0;">Monitor & Dispatch Service Bookings</h3>
                    <p style="color: #666; font-size: 0.9rem;">Assign and update dispatch statuses from initiation to completion.</p>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Ref ID</th>
                                <th>Customer</th>
                                <th>Service Requested</th>
                                <th>Assign Technician</th>
                                <th>Dispatch Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#BK-1042</td>
                                <td>Juan Dela Cruz</td>
                                <td>System Cleaning</td>
                                <td>
                                    <select style="padding: 4px;">
                                        <option>Unassigned</option>
                                        <option selected>Mark Reyes</option>
                                    </select>
                                </td>
                                <td>
                                    <select style="padding: 4px;">
                                        <option>Pending</option>
                                        <option selected>Dispatched</option>
                                        <option>Completed</option>
                                    </select>
                                </td>
                                <td><button class="btn-sm">Update</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <small style="display: block; margin-top: 15px; color: #888;">* Bookings require manual payment confirmation. The system does not execute direct online fund settlement.</small>
                </div>
            </div>

            <!-- VIEW: Diagnostic Rules -->
            <div id="view-rules" class="view-section">
                <div class="card" style="max-width: 600px;">
                    <h3 style="margin-top: 0;">Configure Diagnostic Threshold Rules</h3>
                    <p style="color: #666; font-size: 0.9rem;">Define the efficiency loss percentages that trigger automated diagnostic status alerts. Algorithm calculates estimations vs. deep hardware diagnostics.</p>
                    
                    <div class="form-group">
                        <label>Optimal Status Threshold (%)</label>
                        <input type="number" value="90">
                        <small style="color: #666;">Efficiency above this percentage triggers a Green badge.</small>
                    </div>
                    <div class="form-group">
                        <label>Degraded Status Threshold (%)</label>
                        <input type="number" value="70">
                        <small style="color: #666;">Efficiency between this and Optimal triggers a Yellow badge.</small>
                    </div>
                    <div class="form-group">
                        <label>Critical Fault Threshold (%)</label>
                        <input type="number" value="50">
                        <small style="color: #666;">Efficiency below Degraded triggers a Red badge.</small>
                    </div>
                    
                    <button class="btn-success">Save Threshold Configurations</button>
                </div>
            </div>

            <!-- VIEW: Service Catalog -->
            <div id="view-catalog" class="view-section">
                <div class="card">
                    <h3 style="margin-top: 0;">Manage Service Catalog</h3>
                    <p style="color: #666; font-size: 0.9rem;">Configure service types, part replacements, pricing, and scheduling availability</p>
                    
                    <div style="margin-bottom: 15px;">
                        <button class="btn-success">+ Add New Service/Part</button>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Service Type</th>
                                <th>Service Name</th>
                                <th>Base Pricing (PHP)</th>
                                <th>Availability</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Service</td>
                                <td>Preventative Inspection</td>
                                <td>1,500.00</td>
                                <td><span class="badge badge-green">Available</span></td>
                                <td><button class="btn-sm">Edit</button></td>
                            </tr>
                            <tr>
                                <td>Part Replacement</td>
                                <td>String Inverter Check/Swap</td>
                                <td>3,000.00</td>
                                <td><span class="badge badge-yellow">Limited Schedule</span></td>
                                <td><button class="btn-sm">Edit</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        // SPA View Switcher
        function switchView(viewId, navElement, title) {
            document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.sidebar a').forEach(el => el.classList.remove('active-nav'));
            
            document.getElementById(viewId).classList.add('active');
            navElement.classList.add('active-nav');
            
            document.getElementById('nav-title').textContent = title;
        }
    </script>
</body>
</html>