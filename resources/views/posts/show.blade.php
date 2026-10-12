@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <x-card :title="$post->title">
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded mb-3" style="max-height:300px">
        @endif
        <p>{!! nl2br(e($post->content)) !!}</p>
        <small class="text-muted">Dibuat: {{ $post->created_at->format('d M Y H:i') }}</small>
        <div class="mt-3">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </x-card>
@endsection