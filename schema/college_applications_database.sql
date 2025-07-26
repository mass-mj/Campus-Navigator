-- Use the existing database
USE collegefinder;

-- Create college applications table
CREATE TABLE IF NOT EXISTS college_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    college_id INT NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    high_school VARCHAR(100) NOT NULL,
    high_school_percentage DECIMAL(5,2) NOT NULL,
    program_of_interest VARCHAR(100) NOT NULL,
    entrance_exam VARCHAR(100),
    entrance_score VARCHAR(50),
    achievements TEXT,
    personal_statement TEXT NOT NULL,
    parent_name VARCHAR(100) NOT NULL,
    parent_contact VARCHAR(15) NOT NULL,
    documents_link TEXT,
    status ENUM('Pending', 'Under Review', 'Accepted', 'Waitlisted', 'Rejected') DEFAULT 'Pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (college_id) REFERENCES colleges(id) ON DELETE CASCADE
); 