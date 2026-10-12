@csrf
@isset($post)
    @method('PUT')
@endisset

<div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" name="title"
           class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $post->title ?? '') }}">
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Konten</label>
    <textarea name="content" rows="6"
              class="form-control @error('content') is-invalid @enderror">{{ old('content', $post->content ?? '') }}</textarea>
    @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Gambar (opsional)</label>
    <input type="file" name="image"
           class="form-control @error('image') is-invalid @enderror">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @isset($post)
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="img-thumbnail mt-2" width="150">
        @endif
    @endisset
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('posts.index') }}" class="btn btn-secondary">Batal</a>