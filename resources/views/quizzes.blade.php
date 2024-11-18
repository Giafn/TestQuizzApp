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
            <a href="/quizz/{{ 1 }}" class="btn btn-primary">Start</a>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex my-3">
    <input type="text" class="input-search form-control px-4 py-3 border-0" placeholder="Search Quiz" aria-label="Search Quiz" aria-describedby="button-addon2">
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
<div class="list-group rounded-4">
    @foreach($quizzes as $quiz)
    <a href="/quizz/1" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{ $quiz['title'] }}</h5>
            <small>{{ $quiz['created_at'] }}</small>
        </div>
        <span class="badge bg-primary">{{ $quiz['category'] }}</span>
        <p class="mb-1">{{ $quiz['description'] }}</p>
    </a>
    @endforeach
</div>
@endsection
