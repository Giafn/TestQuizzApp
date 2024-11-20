@extends('layouts.app')

@section('title', 'Setting Class')
@section('content')
<div class="mb-4">
    <a href="/classes/{{ $class->id }}" class="text-white text-decoration-none fw-bold h5">
        <i class="bi bi-arrow-left-circle-fill"></i> Back
    </a>
</div>
<h4 class="text-white fw-bold my-3">
    General
</h4>
<form id="generalUpdateForm" action="/classes/{{ $class->id }}/update" method="post">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="classCode" class="form-label text-white">Class Code</label>
        <div class="input-group">
            <input type="text" class="form-control" id="classCode"  value="{{ $class->code }}" disabled readonly>
            <button class="btn btn-secondary" type="button" onclick="copyToClipboard('{{ $class->code }}')">
                <i class="bi bi-clipboard"></i>
            </button>
        </div>
    </div>
    <div class="mb-3">
        <label for="className" class="form-label text-white">Class Name</label>
        <input type="text" class="form-control" id="className" name="name" value="{{ $class->name }}">
    </div>
    <div class="mb-3">
        <label for="classDesc" class="form-label text-white">Description</label>
        <textarea class="form-control" id="classDesc" name="desc" rows="3" >{{ $class->desc }}</textarea>
    </div>
</form>
<div class="d-flex justify-content-between">
    <button id="saveUpdate" class="btn btn-warning">Save</button>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteClass">
        Delete this Class
    </button>
</div>
<h4 class="text-white fw-bold my-3">
    Members
</h4>
{{-- search --}}
<div class="mb-3">
    <div class="input-group">
        <input id="searchMemberInput" type="text" class="form-control" placeholder="Search member">
        <button id="btnSubmitSearch" class="btn btn-secondary" type="button">
            <i class="bi bi-search"></i>
        </button>
    </div>
</div>
<div class="d-flex gap-2 flex-wrap" id="memberList">
    
</div>

{{-- modal delete class --}}
<div class="modal fade" id="deleteClass" tabindex="-1" aria-labelledby="deleteClassLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteClassLabel">Delete Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure want to delete this class?

                <p class="text-secondary mt-3">
                    All data in this class will be lost and cannot be recovered.
                </p>
                <label for="classCode" class="form-label-text">Type class code here</label>
                <input id="confirmDeleteInputCode" type="text" class="form-control mt-3" placeholder="Type class code here">
                <small class="text-secondary">type <strong>{{ $class->code }}</strong> to confirm</small>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="/classes/{{ $class->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button id="btnConfirmDelete" type="submit" class="btn btn-danger" disabled>Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal detail member --}}
<div class="modal fade" id="detailMember" tabindex="-1" aria-labelledby="detailMemberLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailMemberLabel">Member Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex gap-3">
                    <img id="imgMemberDetail" src="https://ui-avatars.com/api/?name=John+Doe&background=random" alt="John Doe" class="rounded-circle" style="width: 100px; height: 100px">
                    <div class="flex-fill">
                        <h5 class="fw-bold" id="detailMemberName"></h5>
                        <span id="detailOwnerBadge" class="badge bg-warning d-none">Owner</span>
                        <p id="detailMemberJoinAt" class="text-secondary">join at <span id="detailMemberJoinAtText"></span>

                    </div>
                </div>
                {{-- remove member --}}
                <div class="d-flex justify-content-end gap-1">
                    <button id="removeBtnDetailMember" class="btn btn-danger d-none">Remove</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // document ready
    $(document).ready(function() {
        loadMember();
    });

    // on focus search member input
    $('#searchMemberInput').focus(function() {
        $(this).keypress(function(e) {
            if(e.which == 13) {
                loadMember($(this).val());
            }
        });
    });

    // on click submit search
    $('#btnSubmitSearch').click(function() {
        loadMember($('#searchMemberInput').val());
    });

    $('#saveUpdate').click(function(e) {
        e.preventDefault();
        $('#generalUpdateForm').submit();
    });

    // body on click .member-list
    $('body').on('click', '.member-list', function() {
        loadMemberDetail($(this).data('id'));
    });

    // on input confirm delete class
    $('#confirmDeleteInputCode').on('input', function() {
        if($(this).val() == '{{ $class->code }}') {
            $('#btnConfirmDelete').prop('disabled', false);
        } else {
            $('#btnConfirmDelete').prop('disabled', true);
        }
    });

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text);
        toastr.success('Class code copied to clipboard');
    }

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

    function loadMemberDetail(id) {
        $.ajax({
            url: '/classes/{{ $class->id }}/member/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    drawMemberDetail(response.data);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    }

    function drawMemberList(data) {
        let memberList = '';
        data.forEach(member => {
            memberList += `
            <div class="bg-white rounded shadow-sm p-2 w-100 member-list" style="cursor: pointer" data-id="${member.id}">
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

    function drawMemberDetail(member) {
        $('#imgMemberDetail').attr('src', 'https://api.dicebear.com/9.x/dylan/svg?seed=' + member.name);
        $('#detailMemberName').text(member.name);
        if (member.is_owner) {
            $('#detailOwnerBadge').removeClass('d-none');
            $('#removeBtnDetailMember').addClass('d-none');
        } else {
            $('#detailOwnerBadge').addClass('d-none');
            $('#removeBtnDetailMember').removeClass('d-none');
        }
        $('#detailMemberJoinAtText').text(member.joined_at);
        $('#detailMember').modal('show');
    }
</script>
@endsection
