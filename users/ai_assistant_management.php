<?php
include '../config/db_connect.php';
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.html");
    exit();
}

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Add new FAQ
        if ($_POST['action'] === 'add') {
            $question = $_POST['question'];
            $answer = $_POST['answer'];
            $category = $_POST['category'];
            $display_order = $_POST['display_order'];
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            
            $stmt = $conn->prepare("INSERT INTO ai_assistant_faq (question, answer, category, display_order, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssii", $question, $answer, $category, $display_order, $is_active);
            $stmt->execute();
            $stmt->close();
            
            $success_message = "FAQ added successfully!";
        }
        
        // Update existing FAQ
        elseif ($_POST['action'] === 'update') {
            $faq_id = $_POST['faq_id'];
            $question = $_POST['question'];
            $answer = $_POST['answer'];
            $category = $_POST['category'];
            $display_order = $_POST['display_order'];
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            
            $stmt = $conn->prepare("UPDATE ai_assistant_faq SET question = ?, answer = ?, category = ?, display_order = ?, is_active = ? WHERE faq_id = ?");
            $stmt->bind_param("sssiii", $question, $answer, $category, $display_order, $is_active, $faq_id);
            $stmt->execute();
            $stmt->close();
            
            $success_message = "FAQ updated successfully!";
        }
        
        // Delete FAQ
        elseif ($_POST['action'] === 'delete') {
            $faq_id = $_POST['faq_id'];
            
            $stmt = $conn->prepare("DELETE FROM ai_assistant_faq WHERE faq_id = ?");
            $stmt->bind_param("i", $faq_id);
            $stmt->execute();
            $stmt->close();
            
            $success_message = "FAQ deleted successfully!";
        }
    }
}

// Get all FAQ entries
$sql = "SELECT * FROM ai_assistant_faq ORDER BY category, display_order";
$result = $conn->query($sql);
$faqs = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $faqs[] = $row;
    }
}

// Get all unique categories
$sql = "SELECT DISTINCT category FROM ai_assistant_faq ORDER BY category";
$result = $conn->query($sql);
$categories = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
    }
}

// Get chat logs
$sql = "SELECT cl.*, u.email, u.username 
        FROM ai_assistant_chat_logs cl
        LEFT JOIN users u ON cl.user_id = u.id
        ORDER BY cl.created_at DESC
        LIMIT 100";
$result = $conn->query($sql);
$chat_logs = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $chat_logs[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Assistant Management | Campus Navigator Admin</title>
    <link rel="stylesheet" href="../landingpage/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --admin-primary: #4a6cf7;
            --admin-secondary: #6a7c94;
            --admin-success: #2ecc71;
            --admin-danger: #e74c3c;
            --admin-warning: #f39c12;
            --admin-bg: #f8f9fa;
            --admin-panel-bg: #ffffff;
            --admin-text: #2d3748;
            --admin-text-light: #718096;
            --admin-border: #e2e8f0;
        }
        
        body {
            background-color: var(--admin-bg);
            color: var(--admin-text);
        }
        
        .admin-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--admin-border);
        }
        
        .admin-title h1 {
            font-size: 1.8rem;
            color: var(--admin-primary);
            margin: 0;
        }
        
        .admin-title p {
            margin: 0.5rem 0 0;
            color: var(--admin-text-light);
        }
        
        .admin-nav a {
            margin-left: 1rem;
            color: var(--admin-primary);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.2s;
        }
        
        .admin-nav a:hover {
            background-color: rgba(74, 108, 247, 0.1);
        }
        
        .admin-panel {
            background-color: var(--admin-panel-bg);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .admin-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--admin-border);
        }
        
        .admin-panel-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }
        
        .admin-panel-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .admin-btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .admin-btn-primary {
            background-color: var(--admin-primary);
            color: white;
        }
        
        .admin-btn-primary:hover {
            background-color: #3a59d9;
        }
        
        .admin-btn-secondary {
            background-color: var(--admin-secondary);
            color: white;
        }
        
        .admin-btn-secondary:hover {
            background-color: #5a6a7f;
        }
        
        .admin-btn-danger {
            background-color: var(--admin-danger);
            color: white;
        }
        
        .admin-btn-danger:hover {
            background-color: #c0392b;
        }
        
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .admin-table th,
        .admin-table td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--admin-border);
        }
        
        .admin-table th {
            font-weight: 600;
            color: var(--admin-text-light);
            background-color: #f8fafc;
        }
        
        .admin-table tr:last-child td {
            border-bottom: none;
        }
        
        .admin-table tr:hover td {
            background-color: #f8fafc;
        }
        
        .admin-table .actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .admin-table .actions button {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .admin-table .actions .edit {
            background-color: #f8fafc;
            color: var(--admin-primary);
            border: 1px solid var(--admin-border);
        }
        
        .admin-table .actions .edit:hover {
            background-color: var(--admin-primary);
            color: white;
        }
        
        .admin-table .actions .delete {
            background-color: #f8fafc;
            color: var(--admin-danger);
            border: 1px solid var(--admin-border);
        }
        
        .admin-table .actions .delete:hover {
            background-color: var(--admin-danger);
            color: white;
        }
        
        .admin-form-group {
            margin-bottom: 1.5rem;
        }
        
        .admin-form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .admin-form-group input,
        .admin-form-group select,
        .admin-form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--admin-border);
            border-radius: 4px;
            font-family: inherit;
            font-size: inherit;
        }
        
        .admin-form-group textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .admin-form-group .checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .admin-form-group .checkbox input {
            width: auto;
        }
        
        .admin-tabs {
            display: flex;
            border-bottom: 1px solid var(--admin-border);
            margin-bottom: 1.5rem;
        }
        
        .admin-tab {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .admin-tab.active {
            border-bottom-color: var(--admin-primary);
            color: var(--admin-primary);
        }
        
        .admin-tab:hover:not(.active) {
            background-color: #f8fafc;
        }
        
        .admin-tab-content {
            display: none;
        }
        
        .admin-tab-content.active {
            display: block;
        }
        
        .admin-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .admin-badge-success {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--admin-success);
        }
        
        .admin-badge-danger {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--admin-danger);
        }
        
        .success-message {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--admin-success);
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--admin-success);
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.show {
            display: flex;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 1.5rem;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--admin-border);
        }
        
        .modal-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--admin-text-light);
        }
        
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--admin-border);
        }
    </style>
</head>
<body>
    <!-- Admin Header -->
    <div class="admin-container">
        <div class="admin-header">
            <div class="admin-title">
                <h1>AI Assistant Management</h1>
                <p>Manage AI Assistant questions, answers, and chat history</p>
            </div>
            <div class="admin-nav">
                <a href="admin-panel.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="college-management.php"><i class="fas fa-university"></i> Colleges</a>
                <a href="scholarship-management.php"><i class="fas fa-graduation-cap"></i> Scholarships</a>
                <a href="../index.php"><i class="fas fa-home"></i> Website</a>
            </div>
        </div>
        
        <?php if(isset($success_message)): ?>
        <div class="success-message">
            <?php echo $success_message; ?>
        </div>
        <?php endif; ?>
        
        <!-- Tabs -->
        <div class="admin-tabs">
            <div class="admin-tab active" data-tab="manage-faq">Manage FAQ</div>
            <div class="admin-tab" data-tab="chat-logs">Chat Logs</div>
        </div>
        
        <!-- FAQ Management Tab -->
        <div class="admin-tab-content active" id="manage-faq">
            <!-- FAQ List Panel -->
            <div class="admin-panel">
                <div class="admin-panel-header">
                    <h2 class="admin-panel-title">AI Assistant FAQ List</h2>
                    <div class="admin-panel-actions">
                        <button class="admin-btn admin-btn-primary" id="addFaqBtn">Add New FAQ</button>
                    </div>
                </div>
                
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Category</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($faqs as $faq): ?>
                        <tr>
                            <td><?php echo $faq['faq_id']; ?></td>
                            <td><?php echo htmlspecialchars(substr($faq['question'], 0, 50)) . (strlen($faq['question']) > 50 ? '...' : ''); ?></td>
                            <td><?php echo htmlspecialchars($faq['category']); ?></td>
                            <td><?php echo $faq['display_order']; ?></td>
                            <td>
                                <?php if($faq['is_active']): ?>
                                <span class="admin-badge admin-badge-success">Active</span>
                                <?php else: ?>
                                <span class="admin-badge admin-badge-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td class="actions">
                                <button class="edit" onclick="editFaq(<?php echo $faq['faq_id']; ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="delete" onclick="deleteFaq(<?php echo $faq['faq_id']; ?>)">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($faqs)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No FAQ entries found. Add some to get started!</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Chat Logs Tab -->
        <div class="admin-tab-content" id="chat-logs">
            <div class="admin-panel">
                <div class="admin-panel-header">
                    <h2 class="admin-panel-title">Recent AI Assistant Chat Logs</h2>
                </div>
                
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>User</th>
                            <th>Message</th>
                            <th>Type</th>
                            <th>Response Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($chat_logs as $log): ?>
                        <tr>
                            <td><?php echo date('M d, H:i', strtotime($log['created_at'])); ?></td>
                            <td>
                                <?php if($log['user_id']): ?>
                                <?php echo htmlspecialchars($log['username'] ?? $log['email']); ?>
                                <?php else: ?>
                                Guest (<?php echo substr($log['session_id'], 0, 8); ?>)
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars(substr($log['message'], 0, 50)) . (strlen($log['message']) > 50 ? '...' : ''); ?></td>
                            <td>
                                <?php if($log['is_user_message']): ?>
                                <span class="admin-badge">User</span>
                                <?php else: ?>
                                <span class="admin-badge admin-badge-success">AI</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($log['response_time']): ?>
                                <?php echo round($log['response_time'] * 1000); ?>ms
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($chat_logs)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">No chat logs found yet.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Add/Edit FAQ Modal -->
        <div class="modal" id="faqModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalTitle">Add New FAQ</h3>
                    <button class="modal-close" id="closeModal">&times;</button>
                </div>
                
                <form method="POST" action="">
                    <input type="hidden" name="action" id="formAction" value="add">
                    <input type="hidden" name="faq_id" id="faqId" value="">
                    
                    <div class="admin-form-group">
                        <label for="question">Question</label>
                        <input type="text" id="question" name="question" required>
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="answer">Answer</label>
                        <textarea id="answer" name="answer" required></textarea>
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" required>
                            <?php foreach($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                            <?php endforeach; ?>
                            <option value="new">+ Add New Category</option>
                        </select>
                    </div>
                    
                    <div class="admin-form-group" id="newCategoryGroup" style="display: none;">
                        <label for="newCategory">New Category Name</label>
                        <input type="text" id="newCategory" name="new_category">
                    </div>
                    
                    <div class="admin-form-group">
                        <label for="displayOrder">Display Order</label>
                        <input type="number" id="displayOrder" name="display_order" min="0" value="0">
                    </div>
                    
                    <div class="admin-form-group">
                        <div class="checkbox">
                            <input type="checkbox" id="isActive" name="is_active" checked>
                            <label for="isActive">Active</label>
                        </div>
                    </div>
                    
                    <div class="modal-actions">
                        <button type="button" class="admin-btn admin-btn-secondary" id="cancelBtn">Cancel</button>
                        <button type="submit" class="admin-btn admin-btn-primary">Save FAQ</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Delete Confirmation Modal -->
        <div class="modal" id="deleteModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Confirm Delete</h3>
                    <button class="modal-close" id="closeDeleteModal">&times;</button>
                </div>
                
                <p>Are you sure you want to delete this FAQ? This action cannot be undone.</p>
                
                <form method="POST" action="">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="faq_id" id="deleteFaqId" value="">
                    
                    <div class="modal-actions">
                        <button type="button" class="admin-btn admin-btn-secondary" id="cancelDeleteBtn">Cancel</button>
                        <button type="submit" class="admin-btn admin-btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Tab switching
        document.querySelectorAll('.admin-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.admin-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.admin-tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Show corresponding content
                const tabContentId = this.getAttribute('data-tab');
                document.getElementById(tabContentId).classList.add('active');
            });
        });
        
        // Modal functionality
        const faqModal = document.getElementById('faqModal');
        const deleteModal = document.getElementById('deleteModal');
        const addFaqBtn = document.getElementById('addFaqBtn');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const closeDeleteModal = document.getElementById('closeDeleteModal');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        
        // Category selection change
        const categorySelect = document.getElementById('category');
        const newCategoryGroup = document.getElementById('newCategoryGroup');
        
        categorySelect.addEventListener('change', function() {
            if (this.value === 'new') {
                newCategoryGroup.style.display = 'block';
            } else {
                newCategoryGroup.style.display = 'none';
            }
        });
        
        // Open add FAQ modal
        addFaqBtn.addEventListener('click', function() {
            // Reset form
            document.getElementById('formAction').value = 'add';
            document.getElementById('faqId').value = '';
            document.getElementById('modalTitle').textContent = 'Add New FAQ';
            document.getElementById('question').value = '';
            document.getElementById('answer').value = '';
            document.getElementById('category').value = 'general'; // Default category
            document.getElementById('displayOrder').value = '0';
            document.getElementById('isActive').checked = true;
            newCategoryGroup.style.display = 'none';
            
            // Show modal
            faqModal.classList.add('show');
        });
        
        // Close modals
        closeModal.addEventListener('click', function() {
            faqModal.classList.remove('show');
        });
        
        cancelBtn.addEventListener('click', function() {
            faqModal.classList.remove('show');
        });
        
        closeDeleteModal.addEventListener('click', function() {
            deleteModal.classList.remove('show');
        });
        
        cancelDeleteBtn.addEventListener('click', function() {
            deleteModal.classList.remove('show');
        });
        
        // Edit FAQ
        function editFaq(faqId) {
            // Find the FAQ data from the table
            const rows = document.querySelectorAll('.admin-table tbody tr');
            let faqData = null;
            
            rows.forEach(row => {
                const id = row.querySelector('td:first-child').textContent;
                if (parseInt(id) === faqId) {
                    faqData = {
                        id: faqId,
                        question: row.querySelector('td:nth-child(2)').textContent,
                        category: row.querySelector('td:nth-child(3)').textContent,
                        order: row.querySelector('td:nth-child(4)').textContent,
                        active: row.querySelector('td:nth-child(5) .admin-badge-success') !== null
                    };
                }
            });
            
            if (faqData) {
                // Fetch the full FAQ data via AJAX to get the answer text
                fetch(`get_faq.php?id=${faqId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Set form values
                        document.getElementById('formAction').value = 'update';
                        document.getElementById('faqId').value = faqId;
                        document.getElementById('modalTitle').textContent = 'Edit FAQ';
                        document.getElementById('question').value = faqData.question;
                        document.getElementById('answer').value = data.answer || '';
                        
                        // Check if category exists in the dropdown
                        const categoryExists = Array.from(categorySelect.options).some(option => option.value === faqData.category);
                        
                        if (categoryExists) {
                            categorySelect.value = faqData.category;
                            newCategoryGroup.style.display = 'none';
                        } else {
                            // Add the category temporarily
                            const option = document.createElement('option');
                            option.value = faqData.category;
                            option.textContent = faqData.category;
                            categorySelect.insertBefore(option, categorySelect.lastElementChild);
                            categorySelect.value = faqData.category;
                            newCategoryGroup.style.display = 'none';
                        }
                        
                        document.getElementById('displayOrder').value = faqData.order;
                        document.getElementById('isActive').checked = faqData.active;
                        
                        // Show modal
                        faqModal.classList.add('show');
                    })
                    .catch(error => {
                        console.error('Error fetching FAQ data:', error);
                        alert('Error fetching FAQ data. Please try again.');
                    });
            }
        }
        
        // Delete FAQ
        function deleteFaq(faqId) {
            document.getElementById('deleteFaqId').value = faqId;
            deleteModal.classList.add('show');
        }
        
        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === faqModal) {
                faqModal.classList.remove('show');
            }
            if (event.target === deleteModal) {
                deleteModal.classList.remove('show');
            }
        });
    </script>
</body>
</html> 