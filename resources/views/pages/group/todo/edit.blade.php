@extends('layout.app')

@section('page')
    {{-- breadcrumb --}}
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('group.show') }}" class="text-decoration-none">Group</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('group.todo.show', ['group' => $group->uuid]) }}"
                    class="text-decoration-none">{{ $group->name }}</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">{{ $status->name }}</li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- form --}}
    <form method="POST"
        action="{{ route('group.todo.update', [
            'group' => $group->uuid,
            'status' => $status->uuid,
            'todo' => $todo->uuid,
        ]) }}">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" value="{{ $todo->title }}" class="form-control" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Assignee to</label>
                    <select class="form-select" name="assignee_id">
                        <option selected value="{{ $todo->assignee->id }}">{{ $todo->assignee->name }}</option>
                        @forelse ($group->members as $member)
                            <option value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" value="{{ $todo->description }}" name="desctription" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Edit</button>
            </div>
        </div>
    </form>
@endsection
