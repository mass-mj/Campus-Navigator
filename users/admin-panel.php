<?php
// Start session
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.html");
    exit();
}

// Include database connection
require_once '../config/db_connect.php';

// Handle application status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $application_id = $conn->real_escape_string($_POST['application_id']);
    $new_status = $conn->real_escape_string($_POST['status']);
    $rejection_reason = isset($_POST['rejection_reason']) ? $conn->real_escape_string($_POST['rejection_reason']) : '';
    
    $updateQuery = "UPDATE college_applications SET 
                    status = '$new_status'";
    
    // Add rejection reason if status is Rejected
    if ($new_status === 'Rejected' && !empty($rejection_reason)) {
        try {
            // First, verify if the column exists to avoid SQL errors
            $updateQuery .= ", rejection_reason = '$rejection_reason'";
        } catch (Exception $e) {
            // If there's an error, don't include the rejection reason field
            $missingColumnError = true;
        }
    }
    
    $updateQuery .= " WHERE id = $application_id";
    
    try {
        if ($conn->query($updateQuery) === TRUE) {
            $statusUpdateSuccess = true;
        } else {
            // If we get "Unknown column" error for rejection_reason
            if (strpos($conn->error, "Unknown column 'rejection_reason'") !== false) {
                $missingColumnError = true;
                // Try the update without the rejection reason
                $simpleUpdateQuery = "UPDATE college_applications SET status = '$new_status' WHERE id = $application_id";
                if ($conn->query($simpleUpdateQuery) === TRUE) {
                    $statusUpdateSuccess = true;
                    $columnMissingButUpdated = true;
                } else {
                    $statusUpdateError = "Error updating application: " . $conn->error;
                }
            } else {
                $statusUpdateError = "Error updating application: " . $conn->error;
            }
        }
    } catch (Exception $e) {
        $statusUpdateError = "Error updating application: " . $e->getMessage();
    }
}

// Get all college applications with college names
$applicationsQuery = "SELECT ca.*, c.name as college_name, u.username, u.email as user_email 
                     FROM college_applications ca 
                     JOIN colleges c ON ca.college_id = c.id 
                     LEFT JOIN users u ON ca.user_id = u.id 
                     ORDER BY ca.applied_at DESC";
$applicationsResult = $conn->query($applicationsQuery);
$applications = [];

if ($applicationsResult && $applicationsResult->num_rows > 0) {
    while ($row = $applicationsResult->fetch_assoc()) {
        $applications[] = $row;
    }
}

// Get current admin info
$admin_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $admin_id";
$result = $conn->query($query);
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Campus Navigator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #5e35b1;
            --secondary-color: #ff5722;
            --dark-color: #333;
            --light-color: #f4f4f4;
            --success-color: #4CAF50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
            --pending-color: #2196F3;
            --review-color: #9C27B0;
            --waitlisted-color: #FFC107;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: var(--dark-color);
        }

        header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
        }

        .logo h1 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 24px;
            color: var(--dark-color);
        }

        .logo span {
            color: var(--primary-color);
        }

        .user-menu {
            display: flex;
            align-items: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
            padding: 5px 10px;
            border-radius: 50px;
            transition: all 0.3s;
        }

        .user-profile:hover {
            background-color: #f0f0f0;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            border: 2px solid var(--primary-color);
        }

        .user-dropdown {
            position: absolute;
            right: 5%;
            top: 70px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            width: 200px;
            display: none;
            z-index: 101;
        }

        .user-dropdown.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .user-dropdown a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: var(--dark-color);
            transition: all 0.3s;
        }

        .user-dropdown a:hover {
            background-color: #f5f5f5;
            color: var(--primary-color);
        }

        .user-dropdown a i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .admin-main {
            margin-top: 80px;
            padding: 20px 5%;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .admin-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .admin-badge {
            background-color: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 20px;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .stat-card .stat-value {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .pending { color: var(--pending-color); }
        .review { color: var(--review-color); }
        .accepted { color: var(--success-color); }
        .rejected { color: var(--danger-color); }
        .waitlisted { color: var(--waitlisted-color); }

        .stat-card .stat-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 40px;
            opacity: 0.1;
        }

        .applications-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 25px;
            margin-bottom: 30px;
        }

        .applications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-filter {
            display: flex;
            gap: 15px;
        }

        .search-filter input, .search-filter select {
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .search-filter button {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .search-filter button:hover {
            background: #4527a0;
        }

        .applications-table {
            width: 100%;
            border-collapse: collapse;
        }

        .applications-table th, .applications-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .applications-table th {
            background-color: #f9f9f9;
            font-weight: 600;
        }

        .applications-table tbody tr {
            transition: background-color 0.3s;
        }

        .applications-table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
            color: white;
        }

        .status-pending { background-color: var(--pending-color); }
        .status-review { background-color: var(--review-color); }
        .status-accepted { background-color: var(--success-color); }
        .status-rejected { background-color: var(--danger-color); }
        .status-waitlisted { background-color: var(--waitlisted-color); }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 5px;
            color: var(--primary-color);
            transition: color 0.3s;
        }

        .action-btn:hover {
            color: var(--secondary-color);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 200;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            overflow: auto;
        }

        .modal-content {
            position: relative;
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            width: 70%;
            max-width: 800px;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.3);
            animation: modalFadeIn 0.4s;
        }

        @keyframes modalFadeIn {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close-modal:hover {
            color: var(--dark-color);
        }

        .modal-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .application-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .detail-group {
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        .detail-value {
            font-size: 16px;
        }

        .application-notes {
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .status-form {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #4527a0;
        }

        .btn-secondary {
            background-color: #888;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #777;
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        /* Animation for status update success */
        .update-success {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            animation: fadeIn 0.3s;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .dashboard-stats {
                grid-template-columns: 1fr;
            }
            
            .applications-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .search-filter {
                flex-wrap: wrap;
                width: 100%;
            }
            
            .search-filter input, .search-filter select {
                width: 100%;
            }
            
            .modal-content {
                width: 90%;
                padding: 20px;
            }
            
            .application-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="../index.html">
                    <h1>The<span>Codex</span></h1>
                </a>
            </div>
            <div class="user-menu">
                <div class="user-profile" id="userProfileBtn">
                    <img src="<?php echo file_exists('../uploads/' . $admin['profile_picture']) ? '../uploads/' . $admin['profile_picture'] : '../uploads/default.jpg'; ?>" alt="Admin Profile">
                    <span><?php echo $admin['username']; ?></span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="user-dropdown" id="userDropdown">
                    <a href="admin-panel.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="college-management.php"><i class="fas fa-university"></i> Manage Colleges</a>
                    <a href="scholarship-management.php"><i class="fas fa-award"></i> Manage Scholarships</a>
                    <a href="ai_assistant_management.php"><i class="fas fa-robot"></i> AI Assistant</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Admin Dashboard Content -->
    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Admin Dashboard</h1>
            <div class="admin-badge">Administrator</div>
        </div>

        <!-- Dashboard Stats -->
        <div class="dashboard-stats">
            <?php
            // Count applications by status
            $statusCounts = [
                'Pending' => 0,
                'Under Review' => 0,
                'Accepted' => 0,
                'Waitlisted' => 0,
                'Rejected' => 0
            ];
            
            foreach ($applications as $app) {
                if (isset($statusCounts[$app['status']])) {
                    $statusCounts[$app['status']]++;
                }
            }
            
            $totalApplications = count($applications);
            ?>
            
            <div class="stat-card">
                <h3>Total Applications</h3>
                <div class="stat-value"><?php echo $totalApplications; ?></div>
                <i class="fas fa-file-alt stat-icon"></i>
            </div>
            
            <div class="stat-card">
                <h3>Pending</h3>
                <div class="stat-value pending"><?php echo $statusCounts['Pending']; ?></div>
                <i class="fas fa-clock stat-icon"></i>
            </div>
            
            <div class="stat-card">
                <h3>Under Review</h3>
                <div class="stat-value review"><?php echo $statusCounts['Under Review']; ?></div>
                <i class="fas fa-search stat-icon"></i>
            </div>
            
            <div class="stat-card">
                <h3>Accepted</h3>
                <div class="stat-value accepted"><?php echo $statusCounts['Accepted']; ?></div>
                <i class="fas fa-check-circle stat-icon"></i>
            </div>
            
            <div class="stat-card">
                <h3>Waitlisted</h3>
                <div class="stat-value waitlisted"><?php echo $statusCounts['Waitlisted']; ?></div>
                <i class="fas fa-list-alt stat-icon"></i>
            </div>
            
            <div class="stat-card">
                <h3>Rejected</h3>
                <div class="stat-value rejected"><?php echo $statusCounts['Rejected']; ?></div>
                <i class="fas fa-times-circle stat-icon"></i>
            </div>
        </div>

        <!-- Applications Container -->
        <div class="applications-container">
            <div class="applications-header">
                <h2>College Applications</h2>
                <div class="search-filter">
                    <input type="text" id="searchInput" placeholder="Search by name..." onkeyup="filterApplications()">
                    <select id="statusFilter" onchange="filterApplications()">
                        <option value="">All Statuses</option>
                        <option value="Pending">Pending</option>
                        <option value="Under Review">Under Review</option>
                        <option value="Accepted">Accepted</option>
                        <option value="Waitlisted">Waitlisted</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
            </div>

            <?php if (isset($statusUpdateSuccess) && $statusUpdateSuccess): ?>
            <div class="update-success">
                <i class="fas fa-check-circle"></i> Application status updated successfully!
            </div>
            <?php endif; ?>
            
            <?php if (isset($missingColumnError) && $missingColumnError): ?>
            <div class="update-warning" style="background-color: #fff3cd; color: #856404; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #ffeeba;">
                <i class="fas fa-exclamation-triangle"></i> 
                <strong>Database Update Required:</strong> The 'rejection_reason' column is missing from your database. 
                <a href="../setup/fix_rejection_reason.php" style="color: #856404; text-decoration: underline; font-weight: bold;">Click here to fix this issue</a>.
                <?php if (isset($columnMissingButUpdated) && $columnMissingButUpdated): ?>
                <div style="margin-top: 10px;">The status was updated successfully, but the rejection reason could not be saved.</div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (isset($statusUpdateError)): ?>
            <div class="update-error" style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #f5c6cb;">
                <i class="fas fa-times-circle"></i> <?php echo $statusUpdateError; ?>
            </div>
            <?php endif; ?>

            <div class="applications-table-container">
                <table class="applications-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Applicant</th>
                            <th>College</th>
                            <th>Program</th>
                            <th>Applied On</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($applications as $app): ?>
                        <tr class="application-row" 
                            data-name="<?php echo strtolower($app['full_name']); ?>" 
                            data-status="<?php echo $app['status']; ?>">
                            <td><?php echo $app['id']; ?></td>
                            <td><?php echo $app['full_name']; ?></td>
                            <td><?php echo $app['college_name']; ?></td>
                            <td><?php echo $app['program_of_interest']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($app['applied_at'])); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $app['status'])); ?>">
                                    <?php echo $app['status']; ?>
                                </span>
                            </td>
                            <td>
                                <button class="action-btn view-btn" onclick="viewApplication(<?php echo htmlspecialchars(json_encode($app)); ?>)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Application Details Modal -->
    <div id="applicationModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2 class="modal-title">Application Details</h2>
            
            <div id="applicationDetailsContent">
                <!-- Content will be inserted dynamically -->
            </div>
            
            <form id="statusUpdateForm" class="status-form" method="POST">
                <input type="hidden" id="application_id" name="application_id" value="">
                
                <div class="form-group">
                    <label for="status">Update Status:</label>
                    <select id="status" name="status" required>
                        <option value="Pending">Pending</option>
                        <option value="Under Review">Under Review</option>
                        <option value="Accepted">Accepted</option>
                        <option value="Waitlisted">Waitlisted</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                
                <div class="form-group" id="rejectionReasonGroup" style="display:none;">
                    <label for="rejection_reason">Rejection Reason:</label>
                    <textarea id="rejection_reason" name="rejection_reason" placeholder="Provide a reason for rejection..."></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle user dropdown
        document.getElementById('userProfileBtn').addEventListener('click', function() {
            document.getElementById('userDropdown').classList.toggle('active');
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.user-profile') && !e.target.closest('.user-dropdown')) {
                document.getElementById('userDropdown').classList.remove('active');
            }
        });

        // Application filtering
        function filterApplications() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('.application-row');
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const status = row.getAttribute('data-status');
                
                const nameMatch = name.includes(searchTerm);
                const statusMatch = statusFilter === '' || status === statusFilter;
                
                if (nameMatch && statusMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Modal functions
        const modal = document.getElementById('applicationModal');
        
        function viewApplication(application) {
            // Populate modal with application details
            const detailsContent = document.getElementById('applicationDetailsContent');
            
            // Format the details HTML
            let detailsHTML = `
                <div class="application-details">
                    <div>
                        <div class="detail-group">
                            <div class="detail-label">Full Name</div>
                            <div class="detail-value">${application.full_name}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">${application.email}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value">${application.phone}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">College</div>
                            <div class="detail-value">${application.college_name}</div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-group">
                            <div class="detail-label">Program of Interest</div>
                            <div class="detail-value">${application.program_of_interest}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">High School</div>
                            <div class="detail-value">${application.high_school}</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">High School Percentage</div>
                            <div class="detail-value">${application.high_school_percentage}%</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Date of Birth</div>
                            <div class="detail-value">${application.dob}</div>
                        </div>
                    </div>
                </div>
                
                <div class="application-notes">
                    <div class="detail-label">Personal Statement</div>
                    <div class="detail-value">${application.personal_statement}</div>
                </div>`;
                
            // Add rejection reason if exists
            if (application.rejection_reason) {
                detailsHTML += `
                <div class="application-notes" style="background-color: rgba(244, 67, 54, 0.1);">
                    <div class="detail-label">Rejection Reason</div>
                    <div class="detail-value">${application.rejection_reason}</div>
                </div>`;
            }
            
            detailsContent.innerHTML = detailsHTML;
            
            // Set form values
            document.getElementById('application_id').value = application.id;
            document.getElementById('status').value = application.status;
            
            // Show/hide rejection reason field based on status
            toggleRejectionReason();
            
            // Open modal
            modal.style.display = 'block';
        }
        
        function closeModal() {
            modal.style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
        
        // Toggle rejection reason field visibility
        document.getElementById('status').addEventListener('change', toggleRejectionReason);
        
        function toggleRejectionReason() {
            const status = document.getElementById('status').value;
            const rejectionGroup = document.getElementById('rejectionReasonGroup');
            
            if (status === 'Rejected') {
                rejectionGroup.style.display = 'block';
            } else {
                rejectionGroup.style.display = 'none';
            }
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            // Automatically hide success message after 5 seconds
            setTimeout(function() {
                const successMsg = document.querySelector('.update-success');
                if (successMsg) {
                    successMsg.style.opacity = '0';
                    setTimeout(() => successMsg.style.display = 'none', 500);
                }
            }, 5000);
        });
    </script>
</body>
</html>