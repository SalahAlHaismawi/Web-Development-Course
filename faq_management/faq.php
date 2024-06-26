<?php
require_once("../includes/header.php");
require_once('../database_and_services/db_config.php');

// Open database connection
$conn = OpenConnection();

?>
<div class="container">
    <h1 class="h1-faq">Frequently Asked Questions (FAQs)</h1>
    <section class="faq">
        <div class="faq-section">
            <?php
            // Retrieve FAQs from the database
            $query = "SELECT * FROM faqs";
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Loop through each FAQ and display them
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $question = htmlspecialchars($row['question']);
                    $answer = htmlspecialchars($row['answer']);
                    echo "<div class='faq-item'>";
                    echo "<a href='#faq$id' class='faq-question'><h2>$question</h2></a>";
                    echo "<div id='faq$id' class='faq-answer'><p>$answer</p></div>";
                    echo "</div>";
                }
            } else {
                // Display an error message if unable to fetch FAQs
                echo "<p>Unable to fetch FAQs at the moment. Please try again later.</p>";
            }

            // Close database connection
            CloseConnection($conn);
            ?>
        </div>
    </section>
</div>

<script src="../assets/js/faq.js"></script>

<?php require_once("../includes/footer.php"); ?>
