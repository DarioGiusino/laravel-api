@extends('layouts.app')

@section('content')
  <section id="project-detail" class="container">
    {{-- top page --}}
    <header class="d-flex justify-content-center align-items-center">

      {{-- project title --}}
      <h2 class="my-4 me-2">{{ $project->title }}</h2>

      {{-- project types badge --}}
      <sup>
        <span class="badge text-black" style="background-color:{{ $project->type?->color }}">
          @if ($project->type)
            {{ $project->type->label }}
          @else
            -
          @endif
        </span>
      </sup>
    </header>

    {{-- content row --}}
    <div class="row row-cols-2">

      {{-- image --}}
      <div class="col d-flex justify-content-center align-items-center">
        <img class="img-fluid"
          src="{{ $project->image ? asset("storage/$project->image") : 'https://marcolanci.it/utils/placeholder.jpg' }}"
          alt="{{ $project->title }}">
      </div>

      {{-- description --}}
      <div class="col p-3">{{ $project->description }}</div>

      <div class="col-12 mt-3">
        <strong>Technologies: </strong>
        @forelse ($project->technologies as $technology)
          <span class="badge rounded-pill"
            style="background-color:{{ $technology->color }}">{{ $technology->label }}</span>
        @empty
          -
        @endforelse
      </div>

    </div>
    <hr>

    {{-- bottom page --}}
    <div class="d-flex align-items-center justify-content-between mb-5">

      {{-- delete button --}}
      <form class="d-inline delete-form" action="{{ route('admin.projects.destroy', $project->id) }}" method="post"
        data-form="{{ $project->title }}">
        @csrf @method('delete')
        <button class="btn btn-sm btn-danger">Delete</button>
      </form>

      {{-- status --}}
      <div>
        <strong>Status: </strong><span
          class="text-{{ $project->is_published ? 'success' : 'danger' }}">{{ $project->is_published ? 'Online' : 'Draft' }}</span>
      </div>

      {{-- edit + go back buttons --}}
      <div>
        <a class="btn btn-sm btn-warning" href="{{ route('admin.projects.edit', $project->id) }}">Edit</a>
        <a class="btn btn-sm btn-secondary" href="{{ route('admin.projects.index') }}">Go back</a>
      </div>
    </div>
  </section>
@endsection
