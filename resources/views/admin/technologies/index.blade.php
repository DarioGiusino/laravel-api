@extends('layouts.app')

@section('content')
  <section id="technologies-list" class="container">
    {{-- page title --}}
    <header>
      <h3 class="text-center my-4">Technologies List</h3>
    </header>

    {{-- technologies table --}}
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
        @forelse ($technologies as $technology)
          <tr>
            {{-- technology id --}}
            <th scope="row">{{ $technology->id }}</th>

            {{-- technology label --}}
            <td>{{ $technology->label }}</td>

            {{-- technology color --}}
            <td>
              <form class="d-flex align-items-center" action="{{ route('admin.technologies.patch', $technology->id) }}"
                method="post" class="color-form">
                @method('PATCH')
                @csrf
                <input type="color" name="color" value="{{ $technology->color }}" class="color-field">
                {{-- <button technology="submit" class="btn btn-sm btn-primary ms-2 p-1">Patch</button> --}}
              </form>
            </td>

            {{-- technology buttons --}}
            <td class="text-end">
              <a class="btn btn-sm btn-warning" href="{{ route('admin.technologies.edit', $technology->id) }}">Edit</a>
              <form class="d-inline delete-form" action="{{ route('admin.technologies.destroy', $technology->id) }}"
                method="post" data-form="{{ $technology->label }}">
                @csrf @method('delete')
                <button technology="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          {{-- if no technologies --}}
          <h1 class="text-center">Technologies list is empty</h1>
        @endforelse
      </tbody>
    </table>
    <hr>
    {{-- add new technology button --}}
    <div class="text-end">
      <a class="btn btn-sm btn-success me-2" href="{{ route('admin.technologies.create') }}">Add</a>
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
