@extends('layouts.app')

@section('content')
  <section id="project-create" class="container">
    {{-- page title --}}
    <header>
      <h3 class="text-center my-4">Add a new project</h3>
    </header>

    {{-- # create form --}}
    @include('includes.projects.form')
  </section>
@endsection
