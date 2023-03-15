@extends('layouts.app')

@section('content')
  <section id="types-list" class="container">
    {{-- page title --}}
    <header>
      <h3 class="text-center my-4">Types List</h3>
    </header>

    {{-- types table --}}
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Label</th>
          <th scope="col">Color</th>
          <th scope="col" class="text-end">Commands</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($types as $type)
          <tr>
            {{-- type id --}}
            <th scope="row">{{ $type->id }}</th>

            {{-- type label --}}
            <td>{{ $type->label }}</td>

            {{-- type color --}}
            <td>
              <form class="d-flex align-items-center" action="{{ route('admin.types.patch', $type->id) }}" method="post"
                class="color-form">
                @method('PATCH')
                @csrf
                <input type="color" name="color" value="{{ $type->color }}" class="color-field">
                {{-- <button type="submit" class="btn btn-sm btn-primary ms-2 p-1">Patch</button> --}}
              </form>
            </td>

            {{-- type buttons --}}
            <td class="text-end">
              <a class="btn btn-sm btn-warning" href="{{ route('admin.types.edit', $type->id) }}">Edit</a>
              <form class="d-inline delete-form" action="{{ route('admin.types.destroy', $type->id) }}" method="post"
                data-form="{{ $type->label }}">
                @csrf @method('delete')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          {{-- if no types --}}
          <h1 class="text-center">Types list is empty</h1>
        @endforelse
      </tbody>
    </table>
    <hr>
    {{-- add new type button --}}
    <div class="text-end">
      <a class="btn btn-sm btn-success me-2" href="{{ route('admin.types.create') }}">Add</a>
    </div>
  </section>
@endsection


@section('scripts')
  <script>
    const colorFields = document.querySelectorAll('.color-field');

    colorFields.forEach(f => {
      f.addEventListener('change', () => {
        // console.log(f.parentElement)
        f.parentElement.submit();
      })
    })
  </script>
@endsection
