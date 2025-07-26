-- Create colleges table in the existing collegefinder database
USE collegefinder;

CREATE TABLE IF NOT EXISTS colleges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    country VARCHAR(50) NOT NULL DEFAULT 'India',
    category VARCHAR(100) NOT NULL, -- india, international, engineering, medicine, etc.
    ranking INT NOT NULL,
    tuition INT NOT NULL,
    acceptance_rate DECIMAL(5,2) NOT NULL,
    grade VARCHAR(10) NOT NULL,
    description TEXT NOT NULL,
    logo_url VARCHAR(255) NOT NULL,
    tags VARCHAR(255) NOT NULL
);

-- Insert sample data
INSERT INTO colleges (name, location, city, state, country, category, ranking, tuition, acceptance_rate, grade, description, logo_url, tags) VALUES 
('Indian Institute of Technology, Bombay', 'Mumbai, Maharashtra', 'Mumbai', 'Maharashtra', 'India', 'india engineering science', 1, 250000, 5.00, 'A+', 'IIT Bombay is renowned for providing world-class education in engineering and technology. The institute offers comprehensive undergraduate, postgraduate and doctoral programs.', 'https://placehold.co/80x80?text=IIT+B', 'Engineering,Technology,Research'),

('Indian Institute of Technology, Delhi', 'New Delhi, Delhi', 'New Delhi', 'Delhi', 'India', 'india science engineering', 2, 220000, 7.00, 'A+', 'IIT Delhi is one of India\'s most prestigious engineering institutions known for its cutting-edge research and innovation. The campus offers diverse programs across engineering disciplines.', 'https://placehold.co/80x80?text=IIT+D', 'Engineering,Technology,Innovation'),

('Indian Institute of Science', 'Bangalore, Karnataka', 'Bangalore', 'Karnataka', 'India', 'india science', 3, 200000, 6.00, 'A++', 'IISc Bangalore is India\'s premier research institution focusing on scientific research and higher education. It offers advanced degrees in sciences, engineering, design, and management.', 'https://placehold.co/80x80?text=IISc', 'Research,Science,Technology'),

('All India Institute of Medical Sciences', 'New Delhi, Delhi', 'New Delhi', 'Delhi', 'India', 'india medicine', 4, 120000, 15.00, 'A++', 'AIIMS is India\'s leading public medical school and hospital complex. It offers undergraduate, postgraduate and doctoral programs in medicine and related fields.', 'https://placehold.co/80x80?text=AIIMS', 'Medicine,Healthcare,Research'),

('Massachusetts Institute of Technology', 'Cambridge, USA', 'Cambridge', 'Massachusetts', 'USA', 'international engineering science', 1, 4500000, 4.00, 'QS 1', 'MIT is a world-renowned private research university focused on scientific, technological, and other areas of scholarship. Known for pioneering research and producing notable alumni.', 'https://placehold.co/80x80?text=MIT', 'Technology,Engineering,Research'),

('Harvard University', 'Cambridge, USA', 'Cambridge', 'Massachusetts', 'USA', 'international arts science', 2, 4200000, 5.00, 'QS 3', 'Harvard is one of the most prestigious universities globally, offering excellence across disciplines from humanities to sciences. The university has an unparalleled legacy in education.', 'https://placehold.co/80x80?text=Harvard', 'Liberal Arts,Research,Business'); 