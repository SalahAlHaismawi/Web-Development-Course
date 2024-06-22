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