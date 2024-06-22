DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS counseling_sessions;
DROP TABLE IF EXISTS Counselors;
DROP TABLE IF EXISTS Admin;
DROP TABLE IF EXISTS Students;
DROP TABLE IF EXISTS users;

CREATE TABLE Students (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) UNIQUE NOT NULL, 
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, 
    role ENUM('student') NOT NULL,
    profile_picture VARCHAR(255) NOT NULL

);

CREATE TABLE Admin (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) UNIQUE NOT NULL, 
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, 
    role ENUM('administrator') NOT NULL,
    profile_picture VARCHAR(255) NOT NULL
);

CREATE TABLE Counselors (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) UNIQUE NOT NULL, 
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, 
    role ENUM('counselor') NOT NULL,
    profile_picture VARCHAR(255) NOT NULL

);

CREATE TABLE counseling_sessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    counselor_id INT NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    status ENUM('pending', 'accepted', 'rejected', 'completed', 'canceled') NOT NULL,
    FOREIGN KEY (student_id) REFERENCES Students(user_id),
    FOREIGN KEY (counselor_id) REFERENCES Counselors(user_id)
);

CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    session_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    FOREIGN KEY (session_id) REFERENCES counseling_sessions(session_id)
    -- Additional fields as needed
);
CREATE TABLE faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL
);




INSERT INTO Admin (username, email, password, role) VALUES ('adminUser', 'admin@example.com', '$2y$10$htmWadLYCOwGlaMbXvZsbuvuZ5BN9V412..uTMF4wl0IwBHTtX4/u', 'administrator');
INSERT INTO faqs (question, answer) VALUES 
("What types of non-academic concerns do your counselors address?", "Our counselors can support you with a variety of concerns, including stress management, relationships, career exploration, and more."),
("How do I book an appointment with a counselor?", "Booking is easy! You can schedule an appointment directly through our website or by calling us at 012-345 6789."),
("What should I expect during my first counseling session?", "Your first session is primarily about understanding your needs and concerns. It's a safe space for you to share what's on your mind, and for us to provide guidance on how we can support you."),
("Is confidentiality maintained during counseling sessions?", "Absolutely. We prioritize your privacy and confidentiality is of utmost importance to us.");