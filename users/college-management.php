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
$editingCollege = null;

// Handle college deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $college_id = $conn->real_escape_string($_GET['delete']);
    
    // Check if there are applications for this college
    $checkQuery = "SELECT COUNT(*) as count FROM college_applications WHERE college_id = $college_id";
    $checkResult = $conn->query($checkQuery);
    $hasApplications = ($checkResult && $checkResult->fetch_assoc()['count'] > 0);
    
    if ($hasApplications) {
        $message = "Cannot delete college with existing applications. Remove applications first.";
        $messageClass = "error";
    } else {
        $deleteQuery = "DELETE FROM colleges WHERE id = $college_id";
        if ($conn->query($deleteQuery) === TRUE) {
            $message = "College deleted successfully!";
            $messageClass = "success";
        } else {
            $message = "Error deleting college: " . $conn->error;
            $messageClass = "error";
        }
    }
}

// Handle college form submission (add/edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_college'])) {
    // Get form data with proper escaping
    $name = $conn->real_escape_string($_POST['name']);
    $location = $conn->real_escape_string($_POST['location']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $country = $conn->real_escape_string($_POST['country']);
    $category = $conn->real_escape_string($_POST['category']);
    $ranking = (int)$_POST['ranking'];
    $tuition = (int)$_POST['tuition'];
    $acceptance_rate = (float)$_POST['acceptance_rate'];
    $grade = $conn->real_escape_string($_POST['grade']);
    $description = $conn->real_escape_string($_POST['description']);
    $logo_url = $conn->real_escape_string($_POST['logo_url']);
    $tags = $conn->real_escape_string($_POST['tags']);
    $google_maps_url = $conn->real_escape_string($_POST['google_maps_url']);
    
    // If editing existing college
    if (isset($_POST['college_id']) && is_numeric($_POST['college_id'])) {
        $college_id = $conn->real_escape_string($_POST['college_id']);
        
        $updateQuery = "UPDATE colleges SET 
                        name = '$name',
                        location = '$location',
                        city = '$city',
                        state = '$state',
                        country = '$country',
                        category = '$category',
                        ranking = $ranking,
                        tuition = $tuition,
                        acceptance_rate = $acceptance_rate,
                        grade = '$grade',
                        description = '$description',
                        logo_url = '$logo_url',
                        tags = '$tags',
                        google_maps_url = '$google_maps_url'
                        WHERE id = $college_id";
                        
        if ($conn->query($updateQuery) === TRUE) {
            $message = "College updated successfully!";
            $messageClass = "success";
        } else {
            $message = "Error updating college: " . $conn->error;
            $messageClass = "error";
        }
    } 
    // If adding new college
    else {
        $insertQuery = "INSERT INTO colleges (name, location, city, state, country, category, ranking, 
                                             tuition, acceptance_rate, grade, description, logo_url, tags, google_maps_url) 
                        VALUES ('$name', '$location', '$city', '$state', '$country', '$category', $ranking, 
                                $tuition, $acceptance_rate, '$grade', '$description', '$logo_url', '$tags', '$google_maps_url')";
                                
        if ($conn->query($insertQuery) === TRUE) {
            $message = "College added successfully!";
            $messageClass = "success";
        } else {
            $message = "Error adding college: " . $conn->error;
            $messageClass = "error";
        }
    }
}

// Get college for editing if edit parameter is set
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $college_id = $conn->real_escape_string($_GET['edit']);
    $editQuery = "SELECT * FROM colleges WHERE id = $college_id";
    $editResult = $conn->query($editQuery);
    
    if ($editResult && $editResult->num_rows > 0) {
        $editingCollege = $editResult->fetch_assoc();
    }
}

// Get all colleges
$collegesQuery = "SELECT * FROM colleges ORDER BY ranking ASC";
$collegesResult = $conn->query($collegesQuery);
$colleges = [];

if ($collegesResult && $collegesResult->num_rows > 0) {
    while ($row = $collegesResult->fetch_assoc()) {
        $colleges[] = $row;
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
    <title>College Management | TheCodex</title>
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

        .logo {
            <div class="logo">
                <a href="../index.html">
                    <h1>Campus<span>Campass</span></h1>
                </a>
            </div>
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
            color: var(--primary-color);
        }

        .add-btn {
            background-color: var(--primary-color);
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
            background-color: #4527a0;
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

        /* College Form Styles */
        .college-form-container {
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
            color: var(--primary-color);
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
            border-color: var(--primary-color);
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
            background-color: var(--primary-color);
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
            background-color: #4527a0;
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

        /* College List Styles */
        .colleges-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 25px;
        }

        .colleges-table {
            width: 100%;
            border-collapse: collapse;
        }

        .colleges-table th, .colleges-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .colleges-table th {
            background-color: #f9f9f9;
            font-weight: 600;
        }

        .colleges-table tbody tr {
            transition: background-color 0.3s;
        }

        .colleges-table tbody tr:hover {
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
            
            .colleges-table {
                display: block;
                overflow-x: auto;
            }
        }

        .no-colleges {
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

        .search-box button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .college-logo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .truncate {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .form-helper {
            display: block;
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            font-style: italic;
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
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">College Management</h1>
            <?php if (!$editingCollege): ?>
            <button class="add-btn" id="showFormBtn"><i class="fas fa-plus"></i> Add New College</button>
            <?php endif; ?>
        </div>

        <?php if ($message): ?>
        <div class="message <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

        <!-- College Form -->
        <div class="college-form-container" id="collegeForm" style="<?php echo ($editingCollege || isset($_GET['showform'])) ? '' : 'display:none;'; ?>">
            <h2 class="form-title"><?php echo $editingCollege ? 'Edit College' : 'Add New College'; ?></h2>
            
            <form method="POST" action="college-management.php">
                <?php if ($editingCollege): ?>
                <input type="hidden" name="college_id" value="<?php echo $editingCollege['id']; ?>">
                <?php endif; ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">College Name*</label>
                        <input type="text" id="name" name="name" value="<?php echo $editingCollege ? $editingCollege['name'] : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="location">Location*</label>
                        <input type="text" id="location" name="location" value="<?php echo $editingCollege ? $editingCollege['location'] : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City*</label>
                        <input type="text" id="city" name="city" value="<?php echo $editingCollege ? $editingCollege['city'] : ''; ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="state">State*</label>
                        <input type="text" id="state" name="state" value="<?php echo $editingCollege ? $editingCollege['state'] : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="country">Country*</label>
                        <input type="text" id="country" name="country" value="<?php echo $editingCollege ? $editingCollege['country'] : 'India'; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Category*</label>
                        <input type="text" id="category" name="category" placeholder="e.g. engineering, medicine, international" value="<?php echo $editingCollege ? $editingCollege['category'] : ''; ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="ranking">Ranking*</label>
                        <input type="number" id="ranking" name="ranking" min="1" value="<?php echo $editingCollege ? $editingCollege['ranking'] : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tuition">Tuition Fee (annual in INR)*</label>
                        <input type="number" id="tuition" name="tuition" min="0" value="<?php echo $editingCollege ? $editingCollege['tuition'] : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="acceptance_rate">Acceptance Rate (%)*</label>
                        <input type="number" id="acceptance_rate" name="acceptance_rate" min="0" max="100" step="0.01" value="<?php echo $editingCollege ? $editingCollege['acceptance_rate'] : ''; ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="grade">Grade*</label>
                        <input type="text" id="grade" name="grade" placeholder="e.g. A+, A, B+" value="<?php echo $editingCollege ? $editingCollege['grade'] : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="logo_url">Logo URL*</label>
                        <input type="text" id="logo_url" name="logo_url" placeholder="https://example.com/logo.jpg or use placeholder" value="<?php echo $editingCollege ? $editingCollege['logo_url'] : 'https://placehold.co/80x80?text=College'; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tags">Tags (comma separated)*</label>
                        <input type="text" id="tags" name="tags" placeholder="e.g. Engineering,Technology,Science" value="<?php echo $editingCollege ? $editingCollege['tags'] : ''; ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="google_maps_url">Google Maps URL</label>
                    <input type="text" id="google_maps_url" name="google_maps_url" placeholder="https://www.google.com/maps?q=CollegeName" value="<?php echo $editingCollege ? $editingCollege['google_maps_url'] : ''; ?>">
                    <small class="form-helper">Enter a Google Maps URL to link directly to college location. Example: https://www.google.com/maps?q=IIT+Bombay</small>
                </div>
                
                <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea id="description" name="description" required><?php echo $editingCollege ? $editingCollege['description'] : ''; ?></textarea>
                </div>
                
                <div class="btn-container">
                    <a href="college-management.php" class="cancel-btn">Cancel</a>
                    <button type="submit" name="save_college" class="save-btn">
                        <?php echo $editingCollege ? 'Update College' : 'Add College'; ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- Colleges List -->
        <div class="colleges-container" id="collegesList" style="<?php echo ($editingCollege || isset($_GET['showform'])) ? 'display:none;' : ''; ?>">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search colleges..." onkeyup="searchColleges()">
            </div>
            
            <?php if (count($colleges) > 0): ?>
            <table class="colleges-table">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Category</th>
                        <th>Ranking</th>
                        <th>Acceptance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($colleges as $college): ?>
                    <tr class="college-row">
                        <td>
                            <img src="<?php echo $college['logo_url']; ?>" alt="<?php echo $college['name']; ?>" class="college-logo">
                        </td>
                        <td>
                            <div class="truncate" title="<?php echo $college['name']; ?>"><?php echo $college['name']; ?></div>
                        </td>
                        <td>
                            <div class="truncate" title="<?php echo $college['location']; ?>"><?php echo $college['location']; ?></div>
                        </td>
                        <td>
                            <div class="truncate" title="<?php echo $college['category']; ?>"><?php echo $college['category']; ?></div>
                        </td>
                        <td><?php echo $college['ranking']; ?></td>
                        <td><?php echo $college['acceptance_rate']; ?>%</td>
                        <td>
                            <a href="college-management.php?edit=<?php echo $college['id']; ?>" class="action-btn edit-btn">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" onclick="confirmDelete(<?php echo $college['id']; ?>, '<?php echo addslashes($college['name']); ?>')" class="action-btn delete-btn">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="no-colleges">
                <p>No colleges found. Add your first college!</p>
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

        // Toggle college form visibility
        const showFormBtn = document.getElementById('showFormBtn');
        if (showFormBtn) {
            showFormBtn.addEventListener('click', function() {
                document.getElementById('collegeForm').style.display = 'block';
                document.getElementById('collegesList').style.display = 'none';
            });
        }

        // Search colleges function
        function searchColleges() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.college-row');
            
            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const location = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const category = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || location.includes(searchTerm) || category.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Confirm delete function
        function confirmDelete(id, name) {
            if (confirm(`Are you sure you want to delete "${name}"? This cannot be undone.`)) {
                window.location.href = `college-management.php?delete=${id}`;
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