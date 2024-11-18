@extends('layouts.app')

@php
$kode = 723767223;
@endphp

@section('title', 'Class - ' . $kode)
@section('content')
<h4 class="text-white fw-bold my-3">
    Javascript Class
</h4>
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
<div class="">
    <table class="table table-borderless">
        <tr>
            <th>Class Name</th>
            <td>Javascript Class</td>
        </tr>
        <tr>
            <th>Owner</th>
            <td>John Doe</td>
        </tr>
        {{-- class code --}}
        <tr>
            <th>Class Code</th>
            <td>
                <span id="classCode">723767223</span><i class="bi bi-clipboard ms-1" style="cursor: pointer" onclick="copyToClipboard('#classCode')"></i>
            </td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>3 days ago</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>This is a javascript class</td>
        </tr>
    </table>
</div>

<div class="d-flex mb-3 justify-content-end">
    <div class="d-flex gap-1">
        <button type="button" class="btn btn-light btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#createQuizz">
            <i class="bi bi-plus"></i> Create
        </button>
        <button type="button" class="btn btn-light btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#showMember">
            <i class="bi bi-person me-1"></i> 1200
        </button>
    </div>
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

<!-- Modal -->
<div class="modal fade" id="createQuizz" tabindex="-1" aria-labelledby="createQuizzLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createQuizzLabel">Create Quizz<span class="text-danger">*</span></h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="mb-3">
                        <label for="quizzTitle" class="form-label">Quizz Title<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="quizzTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizzDescription" class="form-label">Quizz Description<span class="text-secondary text-xs"> - optional</span></label>
                        <textarea class="form-control" id="quizzDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="quizzCategory" class="form-label">Quizz Category<span class="text-danger">*</span></label>
                        <select class="form-select" id="quizzCategory" required>
                            <option selected disabled>Select Category</option>
                            <option value="1">Programming</option>
                            <option value="2">Math</option>
                            <option value="3">Science</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quizzDuration" class="form-label">Quizz Duration<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="quizzDuration" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizzPassingGrade" class="form-label">Quizz Passing Grade (%)<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="quizzPassingGrade" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizzStart" class="form-label">Quizz Start<span class="text-secondary text-xs"> - optional</span></label>
                        <input type="datetime-local" class="form-control" id="quizzStart" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizzEnd" class="form-label">Quizz End<span class="text-secondary text-xs"> - optional</span></label>
                        <input type="datetime-local" class="form-control" id="quizzEnd" required>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="showMember" tabindex="-1" aria-labelledby="showMemberLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="showMemberLabel">Member</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="memberList" style="height: 500px">
                {{-- search member --}}
                <div class="d-flex my-3">
                    <input type="text" class="bg-white input-search form-control px-4 py-3" style="border: 1px solid #ced4da !important" placeholder="Search Member" aria-label="Search Member" aria-describedby="button-addon2">
                    <button class="btn bg-white btn-search" type="button" style="border: 1px solid #ced4da !important" id="button-addon2">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    @for($i = 0; $i < 100; $i++)
                    <div class="bg-white rounded shadow-sm p-2 w-100">
                        <div class="d-flex gap-3 align-items-center">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=random" alt="John Doe" class="rounded-circle" style="width: 50px; height: 50px">
                            <div class="flex-fill">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">John Doe</span>
                                    <span class="text-secondary">
                                        90 pts
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
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
