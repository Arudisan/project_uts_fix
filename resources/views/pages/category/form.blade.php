@extends('layouts.dashboard')
@section('content')
    <h1>{{ $category->id ? 'Edit' : 'Create' }}</h1>
    @if ($category->id)
        <form action="{{ route('category.update', ['category' => $category->id]) }}" method="post">
            @method('PUT')
        @else
            <form action="{{ route('category.store') }}" method="post">
    @endif
    @csrf
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Nama</label>
        <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="name"
            value="{{ $category->name }}">
        @error('name')
            <div class="text-muted"> {{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="">description</label>
        <textarea id="description" name="description" class="form-control" cols="30" rows="10">{{ $category->description }}</textarea>
        @error('description')
            <div class="text-muted"> {{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">{{ $category->status }}</label>
        <select name="status" id="status">
            <option value="active"> active</option>
            <option value="inactive"> inactive</option>
            <option value="draft"> draft</option>
        </select>
        @error('status')
            <div class="text-muted"> {{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
