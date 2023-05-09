@extends('layout.app')

@section('page')
    @if (session('alert'))
        <div class="row">
            <div class="col-12 mb-4">
                <div class="alert alert-{{ session('alert')['status'] }}" role="alert">
                    {{ session('alert')['message'] }}
                </div>
            </div>
        </div>
    @endif

    {{-- breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active" aria-current="page">Group</li>
        </ol>
    </nav>
    {{-- <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <span class="input-group-text" id="basic-addon2">
                <span class="material-symbols-outlined">search</span>
            </span>
        </div>
    </div> --}}

    {{-- list --}}
    <div class="row">
        @forelse ($groups as $group)
            <div class="col-md-4 mb-3">
                <div class="card" style="height: 200px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $group->name }}</h5>
                        <p class="card-text">{{ Str::limit($group->description, 85) }}</p>
                        <p class="card-text text-secondary">{{ $group->created_at->format('d M Y H:i') }}</p>
                        <p class="text-end">
                            <a href="{{ route('group.todo.show', ['group' => $group->uuid]) }}">
                                <span class="material-symbols-outlined text-secondary">edit_square</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>
@endsection
