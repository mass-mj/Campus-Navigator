<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$isAdmin = $isLoggedIn && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Get current page for active menu highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | ' : ''; ?>Campus Navigator</title>
    <link rel="stylesheet" href="<?php echo $root_path ?? ''; ?>style.css">
    <?php if (isset($additional_css) && is_array($additional_css)): ?>
        <?php foreach ($additional_css as $css): ?>
            <link rel="stylesheet" href="<?php echo $root_path ?? ''; ?><?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <?php if (isset($additional_head)): ?>
        <?php echo $additional_head; ?>
    <?php endif; ?>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
            </svg>
            <h2 class="loading-text">Campus<span>Navigator</span></h2>
        </div>
    </div>

    <!-- Navigation -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="<?php echo $root_path ?? ''; ?>index.php">
                    <h1>Campus<span>Navigator</span></h1>
                </a>
            </div>
            <div class="nav-links" id="navLinks">
                <i class="fas fa-times close-menu" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="<?php echo $root_path ?? ''; ?>navpages/about.php" class="nav-link <?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About</a></li>
                    <li><a href="<?php echo $root_path ?? ''; ?>navpages/college-search.php" class="nav-link <?php echo $current_page == 'college-search.php' ? 'active' : ''; ?>">Find Colleges</a></li>
                    <li><a href="<?php echo $root_path ?? ''; ?>navpages/scholarships.php" class="nav-link <?php echo $current_page == 'scholarships.php' ? 'active' : ''; ?>">Scholarships</a></li>
                    <li><a href="<?php echo $root_path ?? ''; ?>navpages/resources.html" class="nav-link <?php echo $current_page == 'resources.html' ? 'active' : ''; ?>">Resources</a></li>
                    <li><a href="<?php echo $root_path ?? ''; ?>contact/contact.php" class="nav-link <?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
                </ul>
            </div>
            <div class="menu-btn">
                <i class="fas fa-bars" onclick="showMenu()"></i>
            </div>
            <div class="cta-buttons">
                <?php if ($isLoggedIn): ?>
                    <div class="user-dropdown">
                        <button class="user-dropdown-btn">
                            <i class="fas fa-user-circle"></i>
                            <span><?php echo htmlspecialchars($username); ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="user-dropdown-content">
                            <a href="<?php echo $root_path ?? ''; ?>users/user-panel.php">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                            <?php if ($isAdmin): ?>
                            <a href="<?php echo $root_path ?? ''; ?>users/admin-panel.php">
                                <i class="fas fa-cog"></i> Admin Panel
                            </a>
                            <?php endif; ?>
                            <a href="<?php echo $root_path ?? ''; ?>login/logout.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo $root_path ?? ''; ?>login/login.php" class="login-btn magnetic-button">Log In</a>
                    <a href="<?php echo $root_path ?? ''; ?>login/register.php" class="signup-btn magnetic-button">Sign Up</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
</body>
</html>
