// timer-worker.js

let timerInterval;
let timer = 0;
let isTimerRunning = false;

self.addEventListener('message', function (e) {
    if (e.data === 'start') {
        startTimer();
    } else if (e.data === 'pause') {
        pauseTimer();
    } else if (e.data === 'reset') {
        resetTimer();
    }
});

function startTimer() {
    if (!isTimerRunning) {
        isTimerRunning = true;
        timerInterval = setInterval(function () {
            if (--timer < 0) {
                postMessage('done');
                clearInterval(timerInterval);
            } else {
                postMessage(timer);
            }
        }, 1000);
    }
}

function pauseTimer() {
    if (isTimerRunning) {
        clearInterval(timerInterval);
        isTimerRunning = false;
    }
}

function resetTimer() {
    pauseTimer();
    timer = timer * 60;
    postMessage(timer);
}
