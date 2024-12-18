@extends('layouts.app')

@section('title', 'Quizzes')
@section('content')
@php
$trending = [
    [
        'title' => 'Javascript Quiz',
        'description' => 'This is a javascript quiz'
    ],
    [
        'title' => 'PHP Quiz',
        'description' => 'This is a PHP quiz'
    ],
    [
        'title' => 'Laravel Quiz',
        'description' => 'This is a Laravel quiz'
    ],
    [
        'title' => 'Vue Quiz',
        'description' => 'This is a Vue quiz'
    ]
];
@endphp
<h5 class="text-white fw-bold my-3">Trending Quizz</h5>
<div class="d-flex overflow-x-auto">
    @foreach($trending as $quiz)
    <div class="card border-0 me-3" style="min-width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">{{ $quiz['title'] }}</h5>
            <p class="card-text">{{ $quiz['description'] }}</p>
            <div class="d-flex justify-content-between align-items-end">
                <a href="/quizz/{{ 1 }}" class="btn btn-warning">Start</a>
                <small class="text-muted">1200 Played</small>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex my-3">
    <input type="text" class="bg-white input-search form-control px-4 py-3 border-0" placeholder="Search Quiz" aria-label="Search Quiz" aria-describedby="button-addon2">
    <button class="btn bg-white btn-search border-0" type="button" id="button-addon2">
        <i class="bi bi-search"></i>
    </button>
</div>
@php
$quizzes = [
    [
        'title' => 'Javascript Quiz',
        'description' => 'This is a javascript quiz',
        'created_at' => '3 days ago',
        'category' => 'Programming'
    ],
    [
        'title' => 'PHP Quiz',
        'description' => 'This is a PHP quiz',
        'created_at' => '5 days ago',
        'category' => 'Programming'
    ],
    [
        'title' => 'Laravel Quiz',
        'description' => 'This is a Laravel quiz',
        'created_at' => '1 week ago',
        'category' => 'Programming'
    ],
    [
        'title' => 'Vue Quiz',
        'description' => 'This is a Vue quiz',
        'created_at' => '2 weeks ago',
        'category' => 'Programming'
    ]
];
@endphp
<div class="d-flex flex-column gap-1">
    @foreach($quizzes as $item)
    <a href="/quizz/1" class="text-decoration-none d-block">
        <div class="card bg-primary bg-white me-2 w-100">
            <div class="card-body">
                <div class="d-flex gap-3 justify-content-between align-items-center">
                    <div class="d-flex flex-column flex-fill" >
                        <h5 class="fw-bold mb-0">{{ $item['title'] }}</h5>
                        <div>
                            <span class="badge bg-primary">{{ $item['category'] }}</span>
                        </div>
                        <span class="text-dark">{{ $item['description'] }}</span>
                    </div>
                    <i class="bi bi-arrow-right-circle-fill text-warning" style="font-size: 2em"></i>
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div>
@endsection
