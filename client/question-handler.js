var questions = document.querySelectorAll('.custom-question'); // Updated class name here
var prevButton = document.getElementById('prevButton');
var nextButton = document.getElementById('nextButton');
var currentQuestionIndex = 0;
console.log(questions);
function showQuestion(index) {
    questions[index].classList.add('current');
}

function hideQuestion(index) {
    questions[index].classList.remove('current');
}

function goToPreviousQuestion() {
    if (currentQuestionIndex > 0) {
        hideQuestion(currentQuestionIndex);
        currentQuestionIndex--;
        showQuestion(currentQuestionIndex);
        updateButtons();
    }
}

// function goToNextQuestion() {
//     if (currentQuestionIndex < questions.length - 1) {
//         hideQuestion(currentQuestionIndex);
//         currentQuestionIndex++;
//         showQuestion(currentQuestionIndex);
//         updateButtons();
//     }
// }

function goToNextQuestion() {
    if (currentQuestionIndex < questions.length - 1) {
        // Get the ID of the current active question
        var currentQuestionID = questions[currentQuestionIndex].id;
        alert ("Current Question ID:"currentQuestionID);

        // Hide the current question and move to the next one
        hideQuestion(currentQuestionIndex);
        currentQuestionIndex++;
        showQuestion(currentQuestionIndex);
        updateButtons();
    }
}


function updateButtons() {
    prevButton.disabled = currentQuestionIndex === 0;
    nextButton.disabled = currentQuestionIndex === questions.length - 1;
}

// Initially show the first question
showQuestion(currentQuestionIndex);
updateButtons();

// Add click event listeners to the Previous and Next buttons
prevButton.addEventListener('click', goToPreviousQuestion);
nextButton.addEventListener('click', goToNextQuestion);