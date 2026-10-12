@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <x-card title="Edit Post">
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @include('posts._form')
        </form>
    </x-card>
@endsection