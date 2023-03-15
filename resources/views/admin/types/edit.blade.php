@extends('layouts.app')

@section('content')
  <section id="type-edit" class="container">
    {{-- page title --}}
    <header>
      <h3 class="text-center my-4">Edit '{{ $type->label }}'</h3>
    </header>

    {{-- # edit form --}}
    @include('includes.types.form')
  </section>
@endsection
