var questions = document.querySelectorAll('.custom-question'); // Updated class name here
var prevClauseButton = document.getElementById('prevClauseButton');
var nextClauseButton = document.getElementById('nextClauseButton');
var currentQuestionIndex = 0;
// console.log(questions);
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

function goToNextQuestion() {
    if (currentQuestionIndex < questions.length - 1) {
        hideQuestion(currentQuestionIndex);
        currentQuestionIndex++;
        showQuestion(currentQuestionIndex);
        updateButtons();
    }
}

function updateButtons() {
    prevClauseButton.disabled = currentQuestionIndex === 0;
    nextClauseButton.disabled = currentQuestionIndex === questions.length - 1;
}

// Initially show the first question
showQuestion(currentQuestionIndex);
updateButtons();

// Add click event listeners to the Previous and Next buttons
prevClauseButton.addEventListener('click', goToPreviousQuestion);
nextClauseButton.addEventListener('click', goToNextQuestion);


// Save response to localStorage

// function saveProgress() {
//     var mainCustomRadioYes = document.querySelector("input[name='q<?php echo $mainQuestion['questionId']; ?>']:checked");
//     var subQuestionCustomRadioYes = document.querySelector("input[name='q<?php echo $subQuestion['questionId']; ?>']:checked");
//     var responseText = document.getElementById('response_text').value;

//     var clientResponse = {
//         mainQuestion: mainCustomRadioYes ? mainCustomRadioYes.value : '',
//         subQuestion: subQuestionCustomRadioYes ? subQuestionCustomRadioYes.value : '',
//         responseText: responseText
//     }

//     var jsonString = JSON.stringify(clientResponse);

//     localStorage.setItem('client', jsonString);

//     // Checking if the client responses have been saved successfully
//     var storedData = localStorage.getItem('client');

//     storedData ? console.log('Progress saved successfully', storedData) : console.log("Error occurred while saving data");
// }

// document.getElementById("nextButton").addEventListener('click', saveProgress);

