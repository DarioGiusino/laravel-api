@if ($technology->exists)
  <form class="mb-5" action="{{ route('admin.technologies.update', $technology->id) }}" method="post"
    enctechnology="multipart/form-data" novalidate>
    {{-- * method helper --}}
    @method('PUT')
  @else
    <form class="mb-5" action="{{ route('admin.technologies.store') }}" method="post" enctechnology="multipart/form-data"
      novalidate>
@endif
{{-- ! cross-site request forgery --}}
@csrf

<div class="row">
  {{-- label --}}
  <div class="col-6">
    <div class="mb-3">
      <label for="label" class="form-label">Label</label>
      <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label"
        value="{{ old('label', $technology->label) }}" required>
      @error('label')
        <div class="invalid-feedback">{{ $message }}</div>
      @else
        <div class="form-text">Add a technology label</div>
      @enderror
    </div>
  </div>

  {{-- color --}}
  <div class="col-6">
    <div class="mb-3">
      <label for="color" class="form-label">Color</label>
      <input type="color" class="form-control @error('color') is-invalid @enderror" id="color" name="color"
        value="{{ old('color', $technology->color) }}">
      @error('color')
        <div class="invalid-feedback">{{ $message }}</div>
      @else
        <div class="form-text">Select a color</div>
      @enderror
    </div>
  </div>

  <hr>

  {{-- buttons --}}
  <div class="text-end">
    <button class="btn btn-sm btn-success">Save</button>
    <a class="btn btn-sm btn-secondary" href="{{ route('admin.technologies.index') }}">Go back</a>
  </div>
