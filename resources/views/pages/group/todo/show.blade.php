@extends('layout.app')

@section('page')
    {{-- breadcrumb --}}
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ route('group.show') }}" class="text-decoration-none">Group</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $group->name }}</li>
        </ol>
    </nav>
    @if (session('alert'))
        <div class="row">
            <div class="col-12 mb-4">
                <div class="alert alert-{{ session('alert')['status'] }}" role="alert">
                    {{ session('alert')['message'] }}
                </div>
            </div>
        </div>
    @endif

    {{-- list --}}
    <div class="row">
        @forelse ($todos as $status => $todo)
            <div class="col-md-3">
                <div class="d-flex justify-content-between mb-3">
                    <h5>{{ $status }}</h5>
                    <a href="{{ route('group.todo.add', [
                        'group' => $group->uuid,
                        'status' => $todo[0]->status->uuid,
                    ]) }}"
                        type="button" class="btn btn-sm btn-primary">
                        ADD
                    </a>
                </div>
                <ul class="list-group">
                    @forelse ($todo as $item)
                        <li class="list-group-item">
                            {{ $item->title }}
                            <p class="text-end">
                                <a
                                    href="{{ route('group.todo.edit', [
                                        'group' => $group->uuid,
                                        'status' => $item->status->uuid,
                                        'todo' => $item->uuid,
                                    ]) }}">
                                    <span class="material-symbols-outlined text-secondary">edit_square</span>
                                </a>
                            <form class="text-end" method="POST"
                                action="{{ route('group.todo.delete', [
                                    'group' => $group->uuid,
                                    'todo' => $item->uuid,
                                ]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <span class="material-symbols-outlined text-white">delete</span>
                                </button>
                            </form>
                            </p>
                        </li>
                    @empty
                    @endforelse
                </ul>
            </div>
        @empty
        @endforelse
    </div>
@endsection
