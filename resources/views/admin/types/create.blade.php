@extends('layouts.app')

@section('content')
  <section id="type-create" class="container">
    {{-- page title --}}
    <header>
      <h3 class="text-center my-4">Add a new Type</h3>
    </header>

    {{-- # create form --}}
    @include('includes.types.form')
  </section>
@endsection
