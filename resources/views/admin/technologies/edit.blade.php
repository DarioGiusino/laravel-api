@extends('layouts.app')

@section('content')
  <section id="technology-edit" class="container">
    {{-- page title --}}
    <header>
      <h3 class="text-center my-4">Edit '{{ $technology->label }}'</h3>
    </header>

    {{-- # edit form --}}
    @include('includes.technologies.form')
  </section>
@endsection
