@extends('layouts.app')

@section('title', 'Tambah Post')

@section('content')
    <x-card title="Tambah Post Baru">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @include('posts._form')
        </form>
    </x-card>
@endsection