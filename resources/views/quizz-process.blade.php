@extends('layouts.guest')

@section('title', 'Quizz Preview')
@section('content')
<div class="px-5 py-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <a href="/quizz/1" class="text-decoration-none text-white h3">
            <i class="bi bi-arrow-left-circle-fill"></i>
        </a>
        <div class="flex-grow-1 text-end">
            <span class="text-white">Time Left</span>
            <h4 id="timer" class="fw-bold text-white">00:00</h4>
        </div>
    </div>
    <div class="d-flex justify-content-between my-3">
        <p style="color: rgba(255, 255, 255, 0.7)">
            <span class="fw-bold h3">Soal <span id="questionNumber"></span></span>/<span id="totalQuestion"></span>
        </p>
        <button class="btn btn-outline-light ms-3" data-bs-toggle="modal" data-bs-target="#mapQuestionModal">
            <i class="bi bi-calendar3-fill"></i>
        </button>
    </div>
    <div class="question my-5">
        <h1 class="text-white fw-bold">What is const in javascript?</h1>
    </div>
    <div class="answers-multiple d-none">
        <div class="py-1">
            <button class="btn btn-outline-light w-100">...</button>
        </div>
        <div class="py-1">
            <button class="btn btn-outline-light w-100">...</button>
        </div>
        <div class="py-1">
            <button class="btn btn-outline-light w-100">...</button>
        </div>
        <div class="py-1">
            <button class="btn btn-outline-light w-100">...</button>
        </div>
    </div>
    <div class="answer-text d-none">
        <textarea id="answer-text" class="form-control" placeholder="Your Answer" rows="5"></textarea>
    </div>
    <div class="d-flex justify-content-between my-5">
        <button id="previous-btn" class="btn btn-outline-light">Previous</button>
        <button id="next-btn" class="btn btn-warning">Next</button>
    </div>
</div>

<div class="modal fade" id="mapQuestionModal" tabindex="-1" aria-labelledby="mapQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapQuestionModalLabel">Map Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="map-number" class="d-flex">

                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal request fullscreen --}}
<div class="modal fade" id="requestFullscreenModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="requestFullscreenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Click start to play quiz</h4>
            </div>
            <div class="modal-footer">
                <a href="/quizz/1" class="btn btn-secondary">Close</a>
                <button id="startQuiz" type="button" class="btn btn-primary">Start</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const Questions = [
        {
            id: 1,
            type: 'multiple',
            question: 'What is const in javascript?',
            answers: ['Constant', 'Variable', 'Function', 'Object'],
        },
        {
            id: 2,
            type: 'multiple',
            question: 'What is difference between let and var in javascript?',
            answers: ['Scope', 'Reassign', 'Hoisting', 'Block'],
        },
        {
            id: 3,
            type: 'answer',
            question: 'What is the output of 2 + 2?',
        }
    ]

    let currentQuestion = 0
    $(document).ready(function() {
        $('#requestFullscreenModal').modal('show')

        localStorage.removeItem('answers')
        $('#totalQuestion').text(Questions.length)
        $('#questionNumber').text(currentQuestion + 1)
        $('#previous-btn').attr('disabled', true)
        

        renderQuestion(currentQuestion, true)
        loadAnswersMap()

        // timer 1 menit / soal
        let time = 60 * Questions.length
        const timer = setInterval(() => {
            time--
            const minutes = Math.floor(time / 60)
            const seconds = time % 60
            $('#timer').text(`${minutes}:${seconds}`)
            if (time <= 0) {
                clearInterval(timer)
                // send to server
                // hapus local storage
                localStorage.removeItem('answers')
                window.location.href = '/quizz/1'
                // TODO Aksi jika waktu habis
            }
        }, 1000)
    })

    $('.answers-multiple button').click(function(e) {
        e.preventDefault()
        const id = $(this).attr('id')
        const answerId = id.replace('answer_', '')
        // remove all btn-warning and text-dark to all .answers-multiple button
        $('.answers-multiple button').each((i, el) => {
            $(el).removeClass('btn-light text-dark')
        })
        $(this).addClass('btn-light text-dark')
        saveAnswer(currentQuestion + 1, answerId)
    })

    $('#next-btn').click(function(e) {
        e.preventDefault()
        if (!$('.answer-text').hasClass('d-none')) {
            const answer = $('#answer-text').val()
            saveAnswer(currentQuestion + 1, answer)
        }
        const isFinish = $(this).attr('data-finish')
        if (isFinish === 'true') {
            const responses = JSON.parse(localStorage.getItem('answers'))
            // send to server
            return
        }
        changeQuestion('next')
    })

    $('#previous-btn').click(function(e) {
        e.preventDefault()
        if (!$('.answer-text').hasClass('d-none')) {
            const answer = $('#answer-text').val()
            saveAnswer(currentQuestion + 1, answer)
        }
        changeQuestion('previous')
    })

    // on open modal
    $('#mapQuestionModal').on('show.bs.modal', function (e) {
        $('#map-number').empty()
        loadAnswersMap()
    })

    $('#startQuiz').click(function() {
        $('#requestFullscreenModal').modal('hide')
        requestFullscreen()
    })

    // on close modal
    $('#mapQuestionModal').on('hidden.bs.modal', function (e) {
        checkFullscreen()
    })

    $(document).on("fullscreenchange webkitfullscreenchange mozfullscreenchange MSFullscreenChange", onFullscreenChange);

    function onFullscreenChange() {
        if (!document.fullscreenElement && !document.webkitFullscreenElement) {
            resetAllQuestion()
            // TODO Aksi Jika keluar dari fullscreen
            $('#requestFullscreenModal').modal('show')
        }
    }

    const renderQuestion = (index, init = false) => {
        const question = Questions[index]
        $('.question h1').text(question.question)
        if (question.type === 'answer') {
            $('.answers-multiple').addClass('d-none')
            $('.answer-text').removeClass('d-none')
        } else {
            $('.answers-multiple').removeClass('d-none')
            $('.answer-text').addClass('d-none')
            const answers = JSON.parse(localStorage.getItem('answers')) || []
            const answer = answers.find(a => a.questionId === question.id)
            $('.answers-multiple button').each((i, el) => {
                $(el).text(question.answers[i])
                $(el).attr('id', "answer_" + i)
                // if answer is already selected
                
                $(el).removeClass('btn-light text-dark')
                if (answer) {
                    if (answer.answer == i) {
                        $(el).addClass('btn-light text-dark')
                    }
                }
            })
            if (answer) {
                if (answer.type !== 'multiple') {
                    $('#answer-text').val(answer.answer)
                }
            }
            if (!init) {
                checkFullscreen()
            }
        }
        $('#questionNumber').text(index + 1)
    }

    const changeQuestion = (typeChange) => {
        if (typeChange === 'next') {
            currentQuestion++
        } else {
            if (currentQuestion === 0) {
                return
            }
            currentQuestion--
        }
        $('#questionNumber').text(currentQuestion + 1)
        if (currentQuestion === 0) {
            $('#previous-btn').attr('disabled', true)
        } else {
            $('#previous-btn').attr('disabled', false)
            if (currentQuestion === Questions.length - 1) {
                $('#next-btn').text('Finish')
                $('#next-btn').attr('data-finish', true)
            } else {
                $('#next-btn').text('Next')
                $('#next-btn').attr('data-finish', false)
            }
        }
        renderQuestion(currentQuestion)
    }

    const saveAnswer = (questionId, answer, type = "multiple") => {
        // save to local storage
        let answers = JSON.parse(localStorage.getItem('answers')) || []
        const index = answers.findIndex(a => a.questionId === questionId)
        if (answer == '') {
            return
        }
        if (index === -1) {
            answers.push({ questionId, answer, type})
        } else {
            answers[index] = { questionId, answer, type}
        }
        if (checkFullscreen()) {
            localStorage.setItem('answers', JSON.stringify(answers))
        }
    }

    const loadAnswersMap = () => {
        const questions = Questions
        questions.forEach((q, i) => {
            const questionNumber = i + 1
            // cek if question is already answered
            const answers = JSON.parse(localStorage.getItem('answers')) || []
            const answer = answers.find(a => a.questionId === q.id)
            if (answer) {
                $('#map-number').append(`
                    <button class="btn btn-warning text-dark me-2" data-question="${questionNumber}">${questionNumber}</button>
                `)
            } else {
                // cek jika question id sama dengan current question
                if (q.id === currentQuestion + 1) {
                    $('#map-number').append(`
                        <button class="btn btn-primary me-2" data-question="${questionNumber}">${questionNumber}</button>
                    `)
                } else {
                    $('#map-number').append(`
                        <button class="btn btn-outline-dark  me-2" data-question="${questionNumber}">${questionNumber}</button>
                    `)
                }
            }
        })
        $('#map-number button').click(function(e) {
            e.preventDefault()
            const questionNumber = $(this).attr('data-question')
            currentQuestion = questionNumber - 1
            $('#questionNumber').text(currentQuestion + 1)
            renderQuestion(currentQuestion)
            if (currentQuestion === 0) {
                $('#previous-btn').attr('disabled', true)
            } else {
                $('#previous-btn').attr('disabled', false)
            }
            if (currentQuestion === Questions.length - 1) {
                $('#next-btn').text('Finish')
                $('#next-btn').attr('data-finish', true)
            } else {
                $('#next-btn').text('Next')
                $('#next-btn').attr('data-finish', false)
            }
            if (!$('.answer-text').hasClass('d-none')) {
                const answer = $('#answer-text').val()
                if (answer !== '') {
                    saveAnswer(currentQuestion + 1, answer)
                }
            }
            $('#mapQuestionModal').modal('hide')
        })
    }

    const checkFullscreen = () => {
        onFullscreenChange()
        return document.fullscreenElement && document.webkitFullscreenElement
    }

    const requestFullscreen = () => {
        let element = document.documentElement;
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen(); // Safari
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen(); // Firefox
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen(); // Internet Explorer
        }
    }

    const resetAllQuestion = () => {
        localStorage.removeItem('answers')
        currentQuestion = 0
        renderQuestion(currentQuestion, true)
        $('#previous-btn').attr('disabled', true)
        $('#next-btn').text('Next')
        $('#next-btn').attr('data-finish', false)
    }


</script>
@endsection
