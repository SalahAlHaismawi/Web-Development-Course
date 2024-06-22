<?php require_once("includes/header.php")?>
<div class="container">
<h1 class="h1-faq">Frequently Asked Questions (FAQs)</h1>
    <section class="faq">
        <div class="faq-section">
            <?php
            $faqs = array(
                "What types of non-academic concerns do your counselors address?" => "Our counselors can support you with a variety of concerns, including stress management, relationships, career exploration, and more.",
                "How do I book an appointment with a counselor?" => "Booking is easy! You can schedule an appointment directly through our website or by calling us at 012-345 6789.",
                "What is the cost of a counseling session?" => "We offer flexible pricing options. Please visit our pricing page for details, or contact us for a personalized quote.",
                "Is confidentiality maintained during counseling sessions?" => "Absolutely. We prioritize your privacy and confidentiality is of utmost importance to us.",
            );
            $id = 0;
            foreach ($faqs as $question => $answer) {
                echo "<div class='faq-item'>";
                echo "<a href='#faq$id' class='faq-question'><h2>$question</h2></a>";
                echo "<div id='faq$id' class='faq-answer'><p>$answer</p></div>";
                echo "</div>";
                $id++;
            }
            ?>
        </div>
    </section>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(function(question) {
        question.addEventListener('click', function() {
            let answer = this.nextElementSibling;

            // Check if the answer is already expanded by checking if max-height is not '0'
            if (answer.style.maxHeight && answer.style.maxHeight !== '0px') {
                // If expanded, collapse it
                answer.style.maxHeight = '0';
            } else {
                // If collapsed, expand it to its scrollHeight
                answer.style.maxHeight = answer.scrollHeight + "px";
            }
        });
    });
});
</script>
<?php require_once("includes/footer.php")?>
