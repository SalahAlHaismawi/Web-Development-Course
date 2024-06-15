<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Non-Academic Counselor Booking FAQs</title>
    <link rel="stylesheet" href="faq.css">
</head>
<body>
    <header>
        <h1>Your Well-Being Matters - Non-Academic Counseling</h1>
    </header>
    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Our Counselors</a></li>
            <li><a href="#">FAQs</a></li>
            <li><a href="#">Book Now</a></li>
        </ul>
    </nav>
    <main>
        <h1>Frequently Asked Questions (FAQs)</h1>
        <?php
        // Sample FAQ data (replace with your actual data)
        $faqs = array(
            "Q1: What types of non-academic concerns do your counselors address?" => "A1: Our counselors can support you with a variety of concerns, including stress management, relationships, career exploration, and more...",
            "Q2: How do I book an appointment with a counselor?" => "A2: Booking is easy! You can schedule an appointment directly through our website or by calling us at [Phone Number].",
            "Q3: What is the cost of a counseling session?" => "A3: We offer flexible pricing options. Please visit our pricing page for details, or contact us for a personalized quote.",
            "Q4: Is confidentiality maintained during counseling sessions?" => "A4: Absolutely. We prioritize your privacy and confidentiality is of utmost importance to us.",
        );
        
        // Loop through each FAQ and display question and answer
        foreach ($faqs as $question => $answer) {
            echo "<h3>$question</h3>";
            echo "<p>$answer</p>";
        }
        ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Your Well-Being Matters</p>
    </footer>
</body>
</html>
