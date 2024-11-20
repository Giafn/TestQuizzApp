@extends('layouts.app')

@section('title', 'Classes')
@section('content')
<div class="d-flex mb-4">
    <h5 class="text-white fw-bold">Your Classes</h5>
    {{-- modal create --}}
    <button type="button" class="btn btn-light btn-sm ms-auto" data-bs-toggle="modal" data-bs-target="#createOrJoinClass">
        <i class="bi bi-plus"></i> Create or Join Class
    </button>
</div>

<div class="d-flex flex-wrap">
    @forelse ($classes as $class)
    <div class="w-100 p-1">
        <div class="card border-0 bg-white">
            <div class="card-body">
                <div class="d-flex gap-3">
                    <div class="d-flex justify-content-center align-items-center" style="width: 50px">
                        <img src="https://api.dicebear.com/9.x/shapes/svg?seed=class{{ $class->code }}" alt="Class" class="w-100 rounded-circle">
                    </div>
                    <div class="flex-fill">
                        <h5 class="card-title">{{ $class->name }}</h5>
                        <p class="card-text">{{ $class->desc }}</p>
                        <div class="d-flex gap-2 align-items-end justify-content-between">
                            <small class="text-secondary">
                                <i class="bi bi-person me-1"></i>{{ $class->number_of_member }}
                            </small>
                            <a href="/classes/{{ $class->id }}" class="btn btn-sm btn-primary">Open</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center text-white w-100">
        <h5>You don't have any class</h5>
    </div>
    @endforelse
</div>

{{-- modal create or join class --}}
<div class="modal fade" id="createOrJoinClass" tabindex="-1" aria-labelledby="createOrJoinClassLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOrJoinClassLabel">Create or Join Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button id="joinClassModalBtn" type="button" class="btn btn-warning w-100 mb-3">Join Class</button>
                <button id="createClassModalBtn" type="button" class="btn btn-primary w-100">Create Class</button>
            </div>
        </div>
    </div>
</div>

{{-- modal join class --}}
<div class="modal fade" id="joinClass" tabindex="-1" aria-labelledby="joinClassLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="joinClassLabel">Join Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="classCode" class="form-label">Class Code</label>
                        <input id="searchClassCode" type="text" class="form-control" id="classCode" placeholder="Enter class code" required>
                    </div>
                    <div id="wrap-result" class="mb-3">
                        <div class="card border-0 bg-white shadow-lg d-none">
                            <div class="card-body">
                                <div class="d-flex gap-3">
                                    <div class="d-flex justify-content-center align-items-center" style="width: 50px">
                                        <img id="imgFoundClass" src="https://api.dicebear.com/9.x/initials/svg?seed=Gia" alt="Class" class="w-100 rounded-circle">
                                    </div>
                                    <div class="flex-fill">
                                        <h5 id="nameFoundClass" class="card-title"></h5>
                                        <p id="descFoundClass" class="card-text"></p>
                                        <a id="btnJoinFoundClass" class="btn btn-sm btn-warning">Join</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <a id="checkClassCodeBtn" class="btn btn-primary d-flex gap-1 align-items-center">
                            <div id="loadingCheck" class="spinner-border d-none" style="width: 20px; height: 20px" role="status">
                                <span class="visually-hidden">Loading...</span>
                              </div>
                            Check
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal create class --}}
<div class="modal fade" id="createClass" tabindex="-1" aria-labelledby="createClassLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClassLabel">Create Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/classes" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="className" class="form-label">Class Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter class name" required>
                    </div>
                    <div class="mb-3">
                        <label for="classDesc" class="form-label">Description</label>
                        <textarea class="form-control" name="desc" rows="3" placeholder="Enter class description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // on click join class modal
    $('#joinClassModalBtn').click(function() {
        $('#createOrJoinClass').modal('hide');
        $('#joinClass').modal('show');
    });

    // on click create class modal
    $('#createClassModalBtn').click(function() {
        $('#createOrJoinClass').modal('hide');
        $('#createClass').modal('show');
    });

    $('#checkClassCodeBtn').click(function(e) {
        e.preventDefault();
        $('#loadingCheck').removeClass('d-none');
        $('#wrap-result').find('.card').addClass('d-none');
        const code = $('#searchClassCode').val();
        findClass(code).then(data => {
            $('#loadingCheck').addClass('d-none');
            if (data.status == "success") {
                $('#imgFoundClass').attr('src', `https://api.dicebear.com/9.x/initials/svg?seed=${data.data.name}`);
                $('#nameFoundClass').text(data.data.name);
                $('#descFoundClass').text(data.data.desc);
                $('#btnJoinFoundClass').attr('href', `/classes/${data.data.id}/join`);
                $('#wrap-result').find('.card').removeClass('d-none');
            } else {
                toastr.error(data.message);
            }
        });
    });

    async function findClass(code) {
        const response = await fetch(`/classes/find/${code}`);
        const data = await response.json();
        return data;
    }
</script>
@endsection
