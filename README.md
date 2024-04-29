# Web-Development-Course
##Suggested File structure for our functionality

counselling_app/
│
├── index.php             # Main entry point of the application
├── login.php             # Handles user login
├── register.php          # Handles user registration
├── logout.php            # Handles user logout
├── dashboard.php         # Main dashboard for logged-in users
│
├── admin/                # Admin-specific files
│   ├── users.php         # Manage users (add, delete, view)
│   ├── sessions.php      # View and manage all counselling sessions
│   └── reviews.php       # View all reviews
│
├── counsellor/           # Counsellor-specific files
│   ├── manage_sessions.php # Accept/reject and manage sessions
│   └── my_sessions.php   # View their own sessions
│
├── student/              # Student-specific files
│   ├── book_session.php  # Page to book a new session
│   ├── my_sessions.php   # Page to view and manage booked sessions
│   └── review_session.php # Leave a review for a session
│
├── includes/             # PHP scripts and utilities
│   ├── config.php        # Database configuration
│   ├── db.php            # Database connection script
│   └── utils.php         # Utility functions
│
├── css/                  # CSS files
│   ├── style.css         # Main stylesheet
│   └── admin.css         # Admin-specific styles
│
├── js/                   # JavaScript files
│   ├── main.js           # Main JavaScript functions
│   └── validation.js     # Client-side form validation
│
├── assets/               # Static assets like images and fonts
│   ├── images/           # Image files
│   └── fonts/            # Font files
│
└── .htaccess             # Apache server config file for URL rewriting
