-- Use the existing database
USE collegefinder;

-- Create scholarships table
CREATE TABLE IF NOT EXISTS scholarships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    organization VARCHAR(100) NOT NULL,
    amount VARCHAR(50) NOT NULL,
    deadline DATE NOT NULL,
    description TEXT NOT NULL,
    eligibility TEXT NOT NULL,
    min_gpa DECIMAL(3,2),
    category VARCHAR(50) NOT NULL,
    country VARCHAR(50) DEFAULT 'India',
    required_documents TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create scholarship applications table
CREATE TABLE IF NOT EXISTS scholarship_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    scholarship_id INT NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    institution VARCHAR(100) NOT NULL,
    current_gpa DECIMAL(3,2) NOT NULL,
    current_year VARCHAR(20) NOT NULL,
    field_of_study VARCHAR(100) NOT NULL,
    annual_income VARCHAR(50) NOT NULL,
    documents_link TEXT,
    status ENUM('Pending', 'Under Review', 'Approved', 'Rejected') DEFAULT 'Pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (scholarship_id) REFERENCES scholarships(id) ON DELETE CASCADE
);

-- Insert sample scholarships data
INSERT INTO scholarships (name, organization, amount, deadline, description, eligibility, min_gpa, category, country, required_documents) VALUES 
('National Merit Scholarship', 'Ministry of Education', '₹50,000 - ₹1,00,000', '2024-10-30', 'The National Merit Scholarship is awarded to high-achieving students who demonstrate exceptional academic ability and potential.', 'Must be a citizen of India. Must be pursuing undergraduate studies. Must have scored at least 90% in 12th standard.', 3.5, 'Academic', 'India', 'Identity proof, Academic transcripts, Recommendation letter, Income certificate'),

('STEM Excellence Award', 'TechFuture Foundation', '₹75,000', '2024-09-15', 'This scholarship aims to encourage students pursuing careers in Science, Technology, Engineering and Mathematics fields.', 'Open to undergraduate and graduate students in STEM fields. Must demonstrate financial need. Must have completed at least one year of college education.', 3.2, 'STEM', 'India', 'Academic records, Research proposal or project description, Letter of recommendation from faculty'),

('Arts and Humanities Grant', 'Cultural Heritage Society', '₹40,000', '2024-08-20', 'Supporting students with exceptional talents in arts, literature, history, philosophy, and other humanities disciplines.', 'Open to students studying arts and humanities. Must submit a portfolio or sample work. Must demonstrate financial need.', 3.0, 'Arts', 'India', 'Portfolio of work, Academic transcripts, Statement of purpose, Financial documents'),

('First-Generation Student Scholarship', 'Education For All Trust', '₹60,000', '2024-11-10', 'Designed to support students who are the first in their family to attend college, helping to break the cycle of limited education opportunities.', 'Must be first in family to attend college/university. Family income should be below ₹5,00,000 per annum. Must maintain good academic standing.', 2.8, 'Need-based', 'India', 'Parent education declaration, Income certificate, Academic records, Statement of purpose'); 