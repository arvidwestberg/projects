function generateQuizCards() {
    console.log("generateQuizCards() called");
    var q_amount = parseInt(document.getElementById("q_amount").value);
    var quizCardsContainer = document.getElementById("quizCardsContainer");

    // Clear existing quiz cards
    quizCardsContainer.innerHTML = "";

    // Generate new quiz cards 
    for (var i = 1; i <= q_amount; i++) {
        var quizCard = document.createElement("div");
        quizCard.classList.add("quiz-card");

        quizCard.classList.add("userInput", "min-w-200", "mb-20");
        var questionInput = document.createElement("input");
        questionInput.type = "text";
        questionInput.name = "q" + i;
        questionInput.placeholder = "Question " + i;
        questionInput.required = true;

        var answerInputs = [];
        for (var j = 1; j <= 3; j++) {
            var answerInput = document.createElement("input");
            answerInput.type = "text";
            answerInput.name = "q" + i + "a" + j;
            answerInput.placeholder = "Answer " + j;
            answerInput.required = true;
            answerInputs.push(answerInput);
        }
        // select with options
        var correctAnswerSelect = document.createElement("select");
        correctAnswerSelect.name = "q" + i + "correct";
        correctAnswerSelect.required = true;
        for (var j = 1; j <= 3; j++) {
            var option = document.createElement("option");
            option.value = j;
            option.innerText = j;
            correctAnswerSelect.appendChild(option);
        }


        quizCard.appendChild(questionInput);
        answerInputs.forEach(function (answerInput) {
            quizCard.appendChild(answerInput);
        });
        // label for select
        var label = document.createElement("label");
        label.innerText = "Correct answer ";
        quizCard.appendChild(label);
        quizCard.appendChild(correctAnswerSelect);
        quizCardsContainer.appendChild(quizCard);
    }
}

document.addEventListener("DOMContentLoaded", generateQuizCards);