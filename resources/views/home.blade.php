@extends('layouts.app')

@section('title', 'Home')
@section('content')
<div class="rounded-3 p-3 bg-white mb-2">
    <div class="row">
        <div class="col-6">
            <div class="d-flex">
                <div class="flex-shrink-0">
                    <i class="bi bi-arrow-up-right-circle-fill text-primary" style="font-size: 3em"></i>
                </div>
                <div class="flex-grow-1 ms-3 d-flex justify-content-center flex-column">
                    <span class="text-secondary">Your Poin</span>
                    <h4 class="fw-bold">90 pts </h4>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="d-flex">
                <div class="flex-shrink-0">
                    <i class="bi bi-award-fill text-warning" style="font-size: 3em"></i>
                </div>
                <div class="flex-grow-1 ms-3 d-flex justify-content-center flex-column">
                    <span class="text-secondary">Your Rank</span>
                    <h4 class="fw-bold">1st</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex my-3">
    <input type="text" class="bg-white input-search form-control px-4 py-3 border-0" placeholder="Search Quiz" aria-label="Search Quiz" aria-describedby="button-addon2">
    <button class="btn bg-white btn-search border-0" type="button" id="button-addon2">
        <i class="bi bi-search"></i>
    </button>
</div>
@php
$category = [
    [
    'icon_url' => '/icon/math.png',
    'name' => 'Math',
    'total_quizzes' => 20
    ],
    [
    'icon_url' => '/icon/programming.png',
    'name' => 'Programming',
    'total_quizzes' => 10
    ],
    [
    'icon_url' => '/icon/science.png',
    'name' => 'Science',
    'total_quizzes' => 15
    ],
    [
    'icon_url' => '/icon/sport.png',
    'name' => 'Sport',
    'total_quizzes' => 5
    ]

];  
@endphp
<h5 class="fw-bold text-white my-3">Quizz Category</h5>
<div class="overflow-x-auto">
    <div class="d-flex">
        @foreach($category as $item)
        <a href="" class="text-decoration-none">
            <div class="card bg-primary bg-white me-2" style="min-width: 200px">
                <div class="card-body">
                    <div class="d-flex gap-1 justify-content-between align-items-center">
                        <div class="d-flex flex-column" style="max-width: 150px">
                            <h5 class="fw-bold">{{ $item['name'] }}</h5>
                            <p class="text-dark">{{ $item['total_quizzes'] }} Quizzes</p>
                        </div>
                        <img src="{{ $item['icon_url'] }}" alt="icon-{{ $item['name'] }}" style="width: 60px">
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
{{-- last quizz played --}}
@php
$lastQuizz = [
    [
    'name' => 'PHP TEST',
    'category' => "Programming",
    'score' => 90
    ],
    [
    'name' => 'Math Test',
    'category' => "Math",
    'score' => 80
    ],
    [
    'name' => 'Science Test',
    'category' => "Science",
    'score' => 70
    ],
    [
    'name' => 'Sport Test',
    'category' => "Sport",
    'score' => 60
    ]
];
@endphp
<h5 class="fw-bold text-white my-3">Last quizzes Finished</h5>
<div class="">
    <div class="w-100 d-flex flex-column gap-1">
        @foreach($lastQuizz as $item)
        <a href="" class="text-decoration-none d-block">
            <div class="card bg-primary bg-white me-2 w-100">
                <div class="card-body">
                    <div class="d-flex gap-3 justify-content-between align-items-center">
                        <div class="d-flex flex-column flex-fill">
                            <h5 class="fw-bold">{{ $item['name'] }}</h5>
                            <span class="text-dark">{{ $item['category'] }}</span>
                            <span class="text-dark">Score: {{ $item['score'] }}</span>
                        </div>
                        <i class="bi bi-check-circle-fill text-warning" style="font-size: 2em"></i>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>

@endsection
