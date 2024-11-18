@extends('layouts.app')

@section('title', 'Quizz Preview')
@section('content')
<div class="d-flex justify-content-between">
    <a href="/quizz" class="text-white text-decoration-none fw-bold h5">
        <i class="bi bi-arrow-left-circle-fill"></i> Back
    </a>
    <div class="wrapp">
        <h4 class="text-white fw-bold mb-0">
            Javascript Quiz
        </h4>
        <small class="text-end text-white d-block">
            private - class (236283726)
        </small>
        <div class="d-flex justify-content-end">
            <div class="d-flex align-items-center">
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <i class="bi bi-star-fill text-warning"></i>
                <span class="text-white ms-2">5.0</span>
            </div>
        </div>
    </div>
</div>

{{-- desc --}}
<h5 class="text-white fw-bold my-3">Description</h5>
<div class="card card-body">
    <p class="">
        This is a javascript quiz Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cumque debitis necessitatibus nostrum, voluptates maiores aspernatur quo facilis? Libero dolore explicabo voluptate fugiat voluptas voluptates, incidunt optio? Modi, tempore natus? Laboriosam?
    </p>
</div>

<h5 class="text-white fw-bold my-3">Sample Questions</h5>
<div class="">
    <div class="mb-3">
        <h6 class="text-white fw-bold">Question 1</h6>
        <p class="text-white">
            What is const in javascript?
        </p>
    </div>
    <div class="mb-3">
        <h6 class="text-white fw-bold">Question 2</h6>
        <p class="text-white">
            What is difference between let and var in javascript?
        </p>
    </div>
</div>

<div class="d-flex justify-content-center my-3 gap-1">
    <button id="playQuizz" class="btn btn-warning flex-fill">Start</button>
    <button class="btn btn-light tb-btn-danger"><i class="bi bi-bookmark-fill"></i></button>
</div>

@endsection

@section('scripts')
<script>
    // onclick start quiz make screen full
    $('#playQuizz').click(function() {
        window.location.href = '/quizz/1/play';
    });
</script>
@endsection
