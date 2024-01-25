function generateQuizCards() {
  console.log("generateQuizCards() called");
  var q_amount = parseInt(document.getElementById("q_amount").value);
  var quizCardsContainer = document.getElementById("quizCardsContainer");

  // Clear existing quiz cards
  quizCardsContainer.innerHTML = "";

  // Generate new quiz cards
  for (var i = 1; i <= q_amount; i++) {
    var quizCard = document.createElement("div");
    quizCard.classList.add(
      "col-sm-8",
      "col-md-8",
      "col-lg-6",
      "border-0",
      "m-auto",
      "p-4",
      "h-100",
      "bg-body-tertiary",
      "mb-3",
      "rounded-3",
      "shadow-sm"
    );

    var divInputQuestion = document.createElement("div");
    divInputQuestion.classList.add("form-floating", "mb-2");

    var questionInput = document.createElement("input");
    questionInput.type = "text";
    questionInput.name = "q" + i;
    questionInput.placeholder = "Question " + i;
    questionInput.required = true;
    questionInput.setAttribute("maxlength", "30");
    questionInput.classList.add("form-control");
    questionInput.id = "q" + i;

    var labelQuestion = document.createElement("label");
    labelQuestion.innerText = "Question " + i;
    labelQuestion.setAttribute("for", "q" + i);

    divInputQuestion.appendChild(questionInput);
    divInputQuestion.appendChild(labelQuestion);

    quizCard.appendChild(divInputQuestion);

    var answerInputs = [];
    for (var j = 1; j <= 3; j++) {
      var divInput = document.createElement("div");
      divInput.classList.add("form-floating", "mb-2");

      var answerInput = document.createElement("input");
      answerInput.type = "text";
      answerInput.name = "q" + i + "a" + j;
      answerInput.placeholder = "Answer " + j;
      answerInput.id = "q" + i + "a" + j;
      answerInput.required = true;
      answerInput.setAttribute("maxlength", "30");
      answerInput.classList.add("form-control");

      var label = document.createElement("label");
      label.innerText = "Answer " + j;
      label.setAttribute("for", "q" + i + "a" + j);

      divInput.appendChild(answerInput);
      divInput.appendChild(label);
      answerInputs.push(divInput);
    }

    var divInputCorrectAnswer = document.createElement("div");
    divInputCorrectAnswer.classList.add("form-floating", "mb-2");

    var correctAnswerSelect = document.createElement("select");
    correctAnswerSelect.name = "q" + i + "correct";
    correctAnswerSelect.required = true;
    correctAnswerSelect.classList.add("form-select");
    for (var j = 1; j <= 3; j++) {
      var option = document.createElement("option");
      option.value = j;
      option.innerText = j;
      correctAnswerSelect.appendChild(option);
    }

    var labelCorrectAnswer = document.createElement("label");
    labelCorrectAnswer.innerText = "Correct answer";
    labelCorrectAnswer.setAttribute("for", "q" + i + "correct");

    divInputCorrectAnswer.appendChild(correctAnswerSelect);
    divInputCorrectAnswer.appendChild(labelCorrectAnswer);

    quizCard.appendChild(divInputQuestion);
    answerInputs.forEach(function (divInput) {
      quizCard.appendChild(divInput);
    });
    quizCard.appendChild(divInputCorrectAnswer);
    quizCardsContainer.appendChild(quizCard);
  }
  // Update the amount of questions displayed
  var qAmountDisplay = document.getElementById("q_amount");
  qAmountDisplay.innerText = q_amount;
}

document.addEventListener("DOMContentLoaded", function () {
  generateQuizCards();

  // Add event listener to the input field
  var qAmountInput = document.getElementById("q_amount");
  qAmountInput.addEventListener("input", generateQuizCards);
});

function incrementQAmount() {
  var qAmountInput = document.getElementById("q_amount");
  var currentValue = parseInt(qAmountInput.value);
  var maxValue = parseInt(qAmountInput.max);

  if (currentValue < maxValue) {
    qAmountInput.value = currentValue + 1;
    generateQuizCards();
  }
}

function decrementQAmount() {
  var qAmountInput = document.getElementById("q_amount");
  var currentValue = parseInt(qAmountInput.value);
  var minValue = parseInt(qAmountInput.min);

  if (currentValue > minValue) {
    qAmountInput.value = currentValue - 1;
    generateQuizCards();
  }
}
