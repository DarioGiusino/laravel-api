@extends('layouts.app')

@section('content')
  <section id="technology-create" class="container">
    {{-- page title --}}
    <header>
      <h3 class="text-center my-4">Add a new Technology</h3>
    </header>

    {{-- # create form --}}
    @include('includes.technologies.form')
  </section>
@endsection
