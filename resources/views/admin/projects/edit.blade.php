@extends('layouts.app')

@section('content')
  <section id="project-edit" class="container">
    {{-- page title --}}
    <header>
      <h3 class="text-center my-4">Edit '{{ $project->title }}'</h3>
    </header>

    {{-- # edit form --}}
    @include('includes.projects.form')
  </section>
@endsection
