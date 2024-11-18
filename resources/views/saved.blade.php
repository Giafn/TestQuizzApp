@extends('layouts.app')

@section('title', 'Saved Quizzes')
@section('content')

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
                        <small class="text-muted">
                            public
                        </small>
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

@section('scripts')
<script>
    function copyToClipboard(element) {
        const text = document.querySelector(element).innerText;
        const input = document.createElement('input');
        input.value = text;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);

        alert('Copied to clipboard');
    }
</script>
@endsection
