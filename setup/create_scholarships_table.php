<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting setup process...<br>";

// Database configuration (direct connection for better error handling)
$servername = "localhost";
$username = "root";
$password = ""; // XAMPP usually has empty password
$dbname = "collegefinder";

echo "Attempting to connect to database '$dbname'...<br>";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . " (Error code: " . mysqli_connect_errno() . ")<br>");
}

echo "Connected successfully to database.<br>";

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS scholarships (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    organization VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    eligibility TEXT NOT NULL,
    amount DECIMAL(10,2) UNSIGNED NOT NULL,
    application_deadline DATE NOT NULL,
    url VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    type VARCHAR(50) NOT NULL,
    min_gpa DECIMAL(3,2) NOT NULL DEFAULT 0.00,
    education_level VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

echo "Attempting to create table 'scholarships'...<br>";

// Execute query
if (mysqli_query($conn, $sql)) {
    echo "Table 'scholarships' created successfully.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// Check if table is empty, if so, insert sample data
$check_query = "SELECT COUNT(*) as count FROM scholarships";
echo "Checking if table contains data...<br>";

$result = mysqli_query($conn, $check_query);
if (!$result) {
    echo "Error checking table: " . mysqli_error($conn) . "<br>";
} else {
    $row = mysqli_fetch_assoc($result);
    echo "Found " . $row['count'] . " existing rows.<br>";

    if ($row['count'] == 0) {
        echo "Adding sample scholarship data...<br>";
        
        // Sample scholarships data
        $insert_sql = "INSERT INTO scholarships 
        (name, organization, description, eligibility, amount, application_deadline, url, category, type, min_gpa, education_level) VALUES
        
        ('Merit Excellence Scholarship', 'National Education Foundation', 'The Merit Excellence Scholarship rewards academic achievement and leadership potential. Recipients demonstrate exceptional academic performance and community involvement.', 'Open to high school seniors with strong academic records and demonstrated leadership. Must maintain a 3.5 GPA throughout college.', 15000.00, '2024-09-30', 'https://example.com/scholarship1', 'Academic', 'merit-based', 3.50, 'undergraduate'),
        
        ('Future Engineers Scholarship', 'Engineering Society of America', 'Supports outstanding students pursuing degrees in engineering fields. The program aims to increase diversity in engineering disciplines.', 'Applicants must be accepted into an accredited engineering program. Preference given to women and underrepresented minorities.', 8000.00, '2024-08-15', 'https://example.com/scholarship2', 'STEM', 'merit-based', 3.20, 'undergraduate'),
        
        ('First Generation College Fund', 'Education Access Initiative', 'Provides financial support to first-generation college students from low-income backgrounds. Aims to support educational equity and access.', 'Must be first in family to attend college. Demonstrated financial need required. Minimum GPA of 2.8.', 5000.00, '2024-07-31', 'https://example.com/scholarship3', 'Need-Based', 'need-based', 2.80, 'undergraduate')";
        
        if (mysqli_query($conn, $insert_sql)) {
            echo "Sample scholarship data added successfully.<br>";
            
            // Add remaining sample data in a separate query to avoid too long query
            $insert_sql2 = "INSERT INTO scholarships 
            (name, organization, description, eligibility, amount, application_deadline, url, category, type, min_gpa, education_level) VALUES
            
            ('Global Leaders Scholarship', 'International Education Council', 'Supports international students who demonstrate leadership potential and academic excellence. Recipients join a global network of scholars.', 'Open to international students pursuing undergraduate or graduate degrees. Requires essays and recommendation letters.', 12000.00, '2024-09-15', 'https://example.com/scholarship4', 'International', 'merit-based', 3.30, 'undergraduate, graduate'),
            
            ('Healthcare Heroes Grant', 'Medical Professionals Foundation', 'Supports students pursuing careers in healthcare fields, with emphasis on those planning to serve in underserved communities.', 'Students accepted to accredited nursing, medical, or allied health programs. Commitment to community service required.', 10000.00, '2024-08-01', 'https://example.com/scholarship5', 'Health Sciences', 'merit-based', 3.00, 'undergraduate, graduate'),
            
            ('Arts & Humanities Fellowship', 'Creative Futures Foundation', 'Supports talented students in arts, humanities, and creative fields. Recipients demonstrate exceptional creative ability and academic achievement.', 'Portfolio review required. Open to students majoring in visual arts, performing arts, creative writing, or humanities.', 7500.00, '2024-10-15', 'https://example.com/scholarship6', 'Arts', 'merit-based', 3.00, 'undergraduate')";
            
            if (mysqli_query($conn, $insert_sql2)) {
                echo "Additional scholarship data added successfully.<br>";
                
                // Add remaining sample data in a third query
                $insert_sql3 = "INSERT INTO scholarships 
                (name, organization, description, eligibility, amount, application_deadline, url, category, type, min_gpa, education_level) VALUES
                
                ('Community Service Scholarship', 'Community Impact Alliance', 'Rewards students who have made significant contributions to their communities through volunteer service and civic engagement.', 'Minimum 200 hours of documented community service within the past two years. Essay describing impact required.', 5000.00, '2024-08-30', 'https://example.com/scholarship7', 'Service', 'merit-based', 3.00, 'undergraduate'),
                
                ('STEM Diversity Scholarship', 'Tech Inclusion Initiative', 'Promotes diversity in STEM fields by supporting underrepresented students pursuing degrees in science, technology, engineering, or mathematics.', 'Open to women, Black, Hispanic/Latino, Indigenous students pursuing STEM degrees. Essay required.', 9000.00, '2024-07-15', 'https://example.com/scholarship8', 'STEM', 'need-based', 3.00, 'undergraduate'),
                
                ('Graduate Research Fellowship', 'Advanced Studies Foundation', 'Supports graduate students conducting innovative research in their fields. Aims to advance knowledge and support future academic leaders.', 'Open to PhD candidates with approved research proposals. Strong academic recommendations required.', 20000.00, '2024-11-30', 'https://example.com/scholarship9', 'Research', 'merit-based', 3.70, 'graduate')";
                
                if (mysqli_query($conn, $insert_sql3)) {
                    echo "Final scholarship data added successfully.<br>";
                } else {
                    echo "Error inserting final data: " . mysqli_error($conn) . "<br>";
                }
            } else {
                echo "Error inserting additional data: " . mysqli_error($conn) . "<br>";
            }
        } else {
            echo "Error inserting sample data: " . mysqli_error($conn) . "<br>";
        }
    } else {
        echo "Table already contains data. No sample data was added.<br>";
    }
}

// Close connection
mysqli_close($conn);
echo "Setup process completed. <a href='../navpages/scholarships.php'>Go to scholarships page</a>";
?> 