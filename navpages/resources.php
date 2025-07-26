<?php
// Set page-specific variables
$page_title = "Resources & Blog";
$root_path = "../";
$additional_css = ["navpages/resources.css"];
$additional_head = '
<!-- Isotope for filtering -->
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
';

// Include header
include_once "../includes/header.php";
?>

    <!-- Hero Section -->
    <section class="resources-hero">
        <div class="light-beams">
            <div class="beam beam-1"></div>
            <div class="beam beam-2"></div>
            <div class="beam beam-3"></div>
        </div>
        <div class="resources-hero-content">
            <h1>Knowledge <span class="text-gradient">Center</span></h1>
            <p>Discover articles, guides, and resources to help you navigate your college journey</p>
            
            <div class="search-container">
                <input type="text" placeholder="Search for articles, tips, and guides..." id="resourceSearch">
                <button class="search-btn"><i class="fas fa-search"></i></button>
            </div>
            
            <div class="featured-tags">
                <span>Popular Topics:</span>
                <a href="#" class="tag" data-filter=".application">Application Tips</a>
                <a href="#" class="tag" data-filter=".financial">Financial Aid</a>
                <a href="#" class="tag" data-filter=".essays">Essay Writing</a>
                <a href="#" class="tag" data-filter=".interviews">Interviews</a>
            </div>
        </div>
    </section>

    <!-- Resources Filter Section -->
    <section class="filter-section" id="college-advice">
        <!-- ...existing code... -->
    </section>

    <!-- Resources Grid Section -->
    <section class="resources-grid">
        <!-- ...existing code... -->
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <!-- ...existing code... -->
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-top">
            <div class="footer-logo">
                <h2>Campus<span>Navigator</span></h2>
                <p>Your ultimate guide to finding the perfect college match</p>
            </div>
            <!-- Rest of footer content -->
        </div>
        <div class="footer-bottom">
            <p>&copy; 2023 CampusNavigator. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="resources.js"></script>
</body>
</html>