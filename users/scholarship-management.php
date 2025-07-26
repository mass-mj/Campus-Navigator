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

// Initialize variables
$message = '';
$messageClass = '';
$editingScholarship = null;

// Handle scholarship deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $scholarship_id = $conn->real_escape_string($_GET['delete']);
    
    // Check if there are applications for this scholarship
    $checkQuery = "SELECT COUNT(*) as count FROM scholarship_applications WHERE scholarship_id = $scholarship_id";
    $checkResult = $conn->query($checkQuery);
    $hasApplications = ($checkResult && $checkResult->fetch_assoc()['count'] > 0);
    
    if ($hasApplications) {
        $message = "Cannot delete scholarship with existing applications. Remove applications first.";
        $messageClass = "error";
    } else {
        $deleteQuery = "DELETE FROM scholarships WHERE id = $scholarship_id";
        if ($conn->query($deleteQuery) === TRUE) {
            $message = "Scholarship deleted successfully!";
            $messageClass = "success";
        } else {
            $message = "Error deleting scholarship: " . $conn->error;
            $messageClass = "error";
        }
    }
}

// Handle scholarship form submission (add/edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_scholarship'])) {
    // Get form data with proper escaping
    $name = $conn->real_escape_string($_POST['name']);
    $organization = $conn->real_escape_string($_POST['organization']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $deadline = $conn->real_escape_string($_POST['deadline']);
    $description = $conn->real_escape_string($_POST['description']);
    $eligibility = $conn->real_escape_string($_POST['eligibility']);
    $min_gpa = (float)$_POST['min_gpa'];
    $category = $conn->real_escape_string($_POST['category']);
    $country = $conn->real_escape_string($_POST['country']);
    $required_documents = $conn->real_escape_string($_POST['required_documents']);
    
    // If editing existing scholarship
    if (isset($_POST['scholarship_id']) && is_numeric($_POST['scholarship_id'])) {
        $scholarship_id = $conn->real_escape_string($_POST['scholarship_id']);
        
        $updateQuery = "UPDATE scholarships SET 
                        name = '$name',
                        organization = '$organization',
                        amount = '$amount',
                        deadline = '$deadline',
                        description = '$description',
                        eligibility = '$eligibility',
                        min_gpa = $min_gpa,
                        category = '$category',
                        country = '$country',
                        required_documents = '$required_documents'
                        WHERE id = $scholarship_id";
                        
        if ($conn->query($updateQuery) === TRUE) {
            $message = "Scholarship updated successfully!";
            $messageClass = "success";
        } else {
            $message = "Error updating scholarship: " . $conn->error;
            $messageClass = "error";
        }
    } 
    // If adding new scholarship
    else {
        $insertQuery = "INSERT INTO scholarships (name, organization, amount, deadline, description, 
                                               eligibility, min_gpa, category, country, required_documents) 
                        VALUES ('$name', '$organization', '$amount', '$deadline', '$description', 
                                '$eligibility', $min_gpa, '$category', '$country', '$required_documents')";
                                
        if ($conn->query($insertQuery) === TRUE) {
            $message = "Scholarship added successfully!";
            $messageClass = "success";
        } else {
            $message = "Error adding scholarship: " . $conn->error;
            $messageClass = "error";
        }
    }
}

// Get scholarship for editing if edit parameter is set
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $scholarship_id = $conn->real_escape_string($_GET['edit']);
    $editQuery = "SELECT * FROM scholarships WHERE id = $scholarship_id";
    $editResult = $conn->query($editQuery);
    
    if ($editResult && $editResult->num_rows > 0) {
        $editingScholarship = $editResult->fetch_assoc();
    }
}

// Get all scholarships
$scholarshipsQuery = "SELECT * FROM scholarships ORDER BY deadline ASC";
$scholarshipsResult = $conn->query($scholarshipsQuery);
$scholarships = [];

if ($scholarshipsResult && $scholarshipsResult->num_rows > 0) {
    while ($row = $scholarshipsResult->fetch_assoc()) {
        $scholarships[] = $row;
    }
}

// Get admin info
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
    <title>Scholarship Management | TheCodex</title>
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
            --scholarship-color: #9C27B0;
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

        .main-content {
            margin-top: 80px;
            padding: 20px 5%;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--scholarship-color);
        }

        .add-btn {
            background-color: var(--scholarship-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .add-btn i {
            margin-right: 8px;
        }

        .add-btn:hover {
            background-color: #7B1FA2;
        }

        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            animation: fadeIn 0.3s;
        }

        .success {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
        }

        .error {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--danger-color);
        }

        /* Scholarship Form Styles */
        .scholarship-form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 25px;
            margin-bottom: 30px;
        }

        .form-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--scholarship-color);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
            transition: border 0.3s;
        }

        .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
            border-color: var(--scholarship-color);
            outline: none;
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .btn-container {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
        }

        .save-btn {
            background-color: var(--scholarship-color);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .save-btn:hover {
            background-color: #7B1FA2;
        }

        .cancel-btn {
            background-color: #888;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .cancel-btn:hover {
            background-color: #777;
        }

        /* Scholarship List Styles */
        .scholarships-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 25px;
        }

        .scholarships-table {
            width: 100%;
            border-collapse: collapse;
        }

        .scholarships-table th, .scholarships-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .scholarships-table th {
            background-color: #f9f9f9;
            font-weight: 600;
        }

        .scholarships-table tbody tr {
            transition: background-color 0.3s;
        }

        .scholarships-table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 5px;
            margin-right: 5px;
            transition: color 0.3s;
        }

        .edit-btn {
            color: var(--warning-color);
        }

        .edit-btn:hover {
            color: #e68900;
        }

        .delete-btn {
            color: var(--danger-color);
        }

        .delete-btn:hover {
            color: #d32f2f;
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .scholarships-table {
                display: block;
                overflow-x: auto;
            }
        }

        .no-scholarships {
            padding: 20px;
            text-align: center;
            color: #888;
            font-size: 16px;
        }

        .search-box {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .search-box input {
            flex: 1;
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
            color: white;
            background-color: var(--scholarship-color);
        }

        .truncate {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .deadline-near {
            color: var(--danger-color);
            font-weight: 600;
        }

        .deadline-upcoming {
            color: var(--warning-color);
            font-weight: 500;
        }

        .deadline-distant {
            color: var(--success-color);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="../index.html">
                    <h1>Campus<span>Campass</span></h1>
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
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Scholarship Management</h1>
            <?php if (!$editingScholarship): ?>
            <button class="add-btn" id="showFormBtn"><i class="fas fa-plus"></i> Add New Scholarship</button>
            <?php endif; ?>
        </div>

        <?php if ($message): ?>
        <div class="message <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <!-- Scholarship Form -->
        <div class="scholarship-form-container" id="scholarshipForm" style="<?php echo ($editingScholarship || isset($_GET['showform'])) ? '' : 'display:none;'; ?>">
            <h2 class="form-title"><?php echo $editingScholarship ? 'Edit Scholarship' : 'Add New Scholarship'; ?></h2>
            
            <form method="POST" action="scholarship-management.php">
                <?php if ($editingScholarship): ?>
                <input type="hidden" name="scholarship_id" value="<?php echo $editingScholarship['id']; ?>">
                <?php endif; ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Scholarship Name*</label>
                        <input type="text" id="name" name="name" value="<?php echo $editingScholarship ? $editingScholarship['name'] : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="organization">Organization*</label>
                        <input type="text" id="organization" name="organization" value="<?php echo $editingScholarship ? $editingScholarship['organization'] : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="amount">Amount*</label>
                        <input type="text" id="amount" name="amount" placeholder="e.g. ₹50,000" value="<?php echo $editingScholarship ? $editingScholarship['amount'] : ''; ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="deadline">Application Deadline*</label>
                        <input type="date" id="deadline" name="deadline" value="<?php echo $editingScholarship ? $editingScholarship['deadline'] : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category*</label>
                        <input type="text" id="category" name="category" placeholder="e.g. Academic, STEM, Arts, Need-based" value="<?php echo $editingScholarship ? $editingScholarship['category'] : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="country">Country*</label>
                        <input type="text" id="country" name="country" value="<?php echo $editingScholarship ? $editingScholarship['country'] : 'India'; ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="min_gpa">Minimum GPA*</label>
                        <input type="number" id="min_gpa" name="min_gpa" min="0" max="4" step="0.1" value="<?php echo $editingScholarship ? $editingScholarship['min_gpa'] : ''; ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea id="description" name="description" required><?php echo $editingScholarship ? $editingScholarship['description'] : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="eligibility">Eligibility Criteria*</label>
                    <textarea id="eligibility" name="eligibility" required><?php echo $editingScholarship ? $editingScholarship['eligibility'] : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="required_documents">Required Documents*</label>
                    <textarea id="required_documents" name="required_documents" required><?php echo $editingScholarship ? $editingScholarship['required_documents'] : ''; ?></textarea>
                </div>
                
                <div class="btn-container">
                    <a href="scholarship-management.php" class="cancel-btn">Cancel</a>
                    <button type="submit" name="save_scholarship" class="save-btn">
                        <?php echo $editingScholarship ? 'Update Scholarship' : 'Add Scholarship'; ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- Scholarships List -->
        <div class="scholarships-container" id="scholarshipsList" style="<?php echo ($editingScholarship || isset($_GET['showform'])) ? 'display:none;' : ''; ?>">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search scholarships..." onkeyup="searchScholarships()">
            </div>
            
            <?php if (count($scholarships) > 0): ?>
            <table class="scholarships-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Organization</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Deadline</th>
                        <th>Min GPA</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($scholarships as $scholarship): 
                        // Calculate days until deadline
                        $deadline = new DateTime($scholarship['deadline']);
                        $today = new DateTime();
                        $interval = $today->diff($deadline);
                        $daysRemaining = $deadline > $today ? $interval->days : -$interval->days;
                        
                        // Set class based on days remaining
                        $deadlineClass = "";
                        if ($daysRemaining < 0) {
                            $deadlineClass = "deadline-near";
                            $deadlineText = "Expired";
                        } elseif ($daysRemaining <= 14) {
                            $deadlineClass = "deadline-near";
                            $deadlineText = $daysRemaining . " days left";
                        } elseif ($daysRemaining <= 30) {
                            $deadlineClass = "deadline-upcoming";
                            $deadlineText = $daysRemaining . " days left";
                        } else {
                            $deadlineClass = "deadline-distant";
                            $deadlineText = date('M d, Y', strtotime($scholarship['deadline']));
                        }
                    ?>
                    <tr class="scholarship-row" 
                        data-name="<?php echo strtolower($scholarship['name']); ?>" 
                        data-org="<?php echo strtolower($scholarship['organization']); ?>"
                        data-category="<?php echo strtolower($scholarship['category']); ?>">
                        <td>
                            <div class="truncate" title="<?php echo $scholarship['name']; ?>"><?php echo $scholarship['name']; ?></div>
                        </td>
                        <td>
                            <div class="truncate" title="<?php echo $scholarship['organization']; ?>"><?php echo $scholarship['organization']; ?></div>
                        </td>
                        <td><?php echo $scholarship['amount']; ?></td>
                        <td><span class="badge"><?php echo $scholarship['category']; ?></span></td>
                        <td class="<?php echo $deadlineClass; ?>"><?php echo $deadlineText; ?></td>
                        <td><?php echo $scholarship['min_gpa']; ?></td>
                        <td>
                            <a href="scholarship-management.php?edit=<?php echo $scholarship['id']; ?>" class="action-btn edit-btn">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="confirmDelete(<?php echo $scholarship['id']; ?>, '<?php echo addslashes($scholarship['name']); ?>')" class="action-btn delete-btn">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="no-scholarships">
                <p>No scholarships found. Add your first scholarship!</p>
            </div>
            <?php endif; ?>
        </div>
    </main>

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

        // Toggle scholarship form visibility
        const showFormBtn = document.getElementById('showFormBtn');
        if (showFormBtn) {
            showFormBtn.addEventListener('click', function() {
                document.getElementById('scholarshipForm').style.display = 'block';
                document.getElementById('scholarshipsList').style.display = 'none';
            });
        }

        // Search scholarships function
        function searchScholarships() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.scholarship-row');
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                const org = row.getAttribute('data-org');
                const category = row.getAttribute('data-category');
                
                if (name.includes(searchTerm) || org.includes(searchTerm) || category.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Confirm delete function
        function confirmDelete(id, name) {
            if (confirm(`Are you sure you want to delete "${name}"? This cannot be undone.`)) {
                window.location.href = `scholarship-management.php?delete=${id}`;
            }
        }

        // Auto-hide success message after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const successMsg = document.querySelector('.message.success');
                if (successMsg) {
                    successMsg.style.opacity = '0';
                    setTimeout(() => successMsg.style.display = 'none', 500);
                }
            }, 5000);
        });
    </script>
</body>
</html>