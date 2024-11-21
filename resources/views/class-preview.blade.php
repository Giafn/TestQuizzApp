@extends('layouts.app')

@section('title', 'Class - ' . $class->code)
@section('content')
<div class="mb-4">
    <a href="/classes" class="text-white text-decoration-none fw-bold h5">
        <i class="bi bi-arrow-left-circle-fill"></i> Back
    </a>
</div>
<h4 class="text-white fw-bold my-3">
    {{ $class->name }}
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
            <td>{{ $class->name }}</td>
        </tr>
        <tr>
            <th>Owner</th>
            <td>{{ $class->owner->name }}</td>
        </tr>
        {{-- class code --}}
        <tr>
            <th>Class Code</th>
            <td>
                <span id="classCode">{{ $class->code }}</span><i class="bi bi-clipboard ms-1" style="cursor: pointer" onclick="copyToClipboard('#classCode')"></i>
            </td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $class->created_at->diffForHumans() }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $class->desc }}</td>
        </tr>
    </table>
</div>

<div class="d-flex mb-3 justify-content-between">
    @if (auth()->user()->id == $class->owner->id)
    <a href="/classes/{{ $class->id }}/setting" class="btn btn-light btn-sm">
        <i class="bi bi-gear"></i> Setting
    </a>
    @endif
    <div class="d-flex gap-1">
        @if (auth()->user()->id == $class->owner->id)
        <button type="button" class="btn btn-light btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#createQuizz">
            <i class="bi bi-plus"></i> Create
        </button>
        @endif
        <button type="button" class="btn btn-light btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#showMember">
            <i class="bi bi-person me-1"></i> Member
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
@if (auth()->user()->id == $class->owner->id)
<div class="modal fade" id="createQuizz" tabindex="-1" aria-labelledby="createQuizzLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createQuizzLabel">Create Quizz</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/quizz/create" method="POST">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <div class="mb-3">
                        <label for="quizzTitle" class="form-label">Title<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizzDescription" class="form-label">Description<span class="text-secondary text-xs"> - optional</span></label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="quizzCategory" class="form-label">Category<span class="text-danger">*</span></label>
                        <select id="categorySelect" class="form-select" name="category" required>
                            <option selected disabled>Select Category</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quizzDuration" class="form-label">Duration<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="duration" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizzPassingGrade" class="form-label">Passing Grade (%)<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="passing_grade" required>
                    </div>
                    <div class="mb-3">
                        <label for="quizzStart" class="form-label">Quizz Start<span class="text-secondary text-xs"> - optional</span></label>
                        <input type="datetime-local" class="form-control" name="quizz_start">
                    </div>
                    <div class="mb-3">
                        <label for="quizzEnd" class="form-label">Quizz End<span class="text-secondary text-xs"> - optional</span></label>
                        <input type="datetime-local" class="form-control" name="quizz_end">
                    </div>
                    <div class="mb-3">
                        <label for="quizzVisibility" class="form-label">Visibility<span class="text-danger">*</span></label>
                        <select class="form-select" name="visibility" required>
                            <option selected disabled>Select Visibility</option>
                            <option value="public">Public</option>
                            <option value="private">Member Only</option>
                        </select>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal -->
<div class="modal fade" id="showMember" tabindex="-1" aria-labelledby="showMemberLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="showMemberLabel">Member</h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="memberList" style="height: 500px">
                <div class="mb-3">
                    <div class="input-group">
                        <input id="searchMemberInput" type="text" class="form-control" placeholder="Search member">
                        <button id="btnSubmitSearch" class="btn btn-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="d-flex flex-wrap" id="memberList">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        loadMember();
        loadCategory();
        $('#btnSubmitSearch').click(function() {
            loadMember($('#searchMemberInput').val());
        });
        $('#searchMemberInput').focus(function() {
            $(this).keypress(function(e) {
                if(e.which == 13) {
                    loadMember($(this).val());
                }
            });
        });
    });

    function loadMember(search = '') {
        $.ajax({
            url: '/classes/{{ $class->id }}/members',
            method: 'GET',
            dataType: 'json',
            data: {
                search: search
            },
            success: function(response) {
                if (response.status == 'success') {
                    drawMemberList(response.data.data);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    }

    function loadCategory() {
        $.ajax({
            url: '/category/all',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    drawCategory(response.data);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    }

    function drawCategory(data) {
        let categoryList = '';
        data.forEach(category => {
            categoryList += `<option value="${category.id}">${category.name}</option>`;
        });
        $('#categorySelect').append(categoryList);
    }

    function drawMemberList(data) {
        let memberList = '';
        data.forEach(member => {
            memberList += `
            <div class="bg-white rounded shadow-sm p-2 w-100 member-list mb-1">
                <div class="d-flex gap-3 align-items-center">
                    <img src="https://api.dicebear.com/9.x/dylan/svg?seed=${member.name}" alt="${member.name}" class="rounded-circle" style="width: 50px; height: 50px">
                    <div class="flex-fill">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-fill">
                                <div class="d-flex flex-column align-items-start w-100">
                                    <span class="fw-bold">${member.name}</span>
                                    ${member.is_owner ? 
                                    '<span class="badge bg-warning d-inline">Owner</span>' 
                                    : '<span class="text-secondary">join at ' + member.joined_at + '</span>'}
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        });
        $('.member-list').remove();
        $('.no-member').remove();
        $('#memberList').append(memberList);

        if (data.length == 0) {
            $('#memberList').append('<div class="text-center text-white w-100 no-member">No member found</div>');
        }
    }

    function copyToClipboard(element) {
        const text = document.querySelector(element).innerText;
        const input = document.createElement('input');
        input.value = text;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);

        toastr.success('Class code copied to clipboard');
    }
</script>
@endsection
