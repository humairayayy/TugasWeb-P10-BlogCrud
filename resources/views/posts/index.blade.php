@extends('layouts.app')

@section('title', 'Daftar Post')

@section('content')
    <form method="GET" action="{{ route('posts.index') }}" class="input-group mb-3">
        <input type="text" name="search" class="form-control"
               placeholder="Cari post..." value="{{ request('search') }}">
        <button class="btn btn-outline-secondary">Cari</button>
    </form>

    @forelse($posts as $post)
        <x-card :title="$post->title">
            <div class="row">
                @if($post->image)
                    <div class="col-md-2">
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded">
                    </div>
                @endif
                <div class="col">
                    <p>{{ Str::limit($post->content, 150) }}</p>
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    <div class="mt-2 d-flex gap-1">
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus post ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </x-card>
    @empty
        <x-alert type="warning">Belum ada post.</x-alert>
    @endforelse

    {{ $posts->links() }}
@endsection