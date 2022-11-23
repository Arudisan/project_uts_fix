@extends('layouts.dashboard')
@section('content')
    <h1>{{ $product->id ? 'Edit' : 'Create' }}</h1>
    @if ($product->id)
        <form action="{{ route('product.update', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
        @else
            <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
    @endif
    @csrf
    <body>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Category</label>
            <select name="category_id"class="form-control">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                        {{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-muted"> {{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"> Title </label>
            <input type="text" class="form-control" name="title" id="title" aria-describedby="title"
                value="{{ $product->title }}">
            @error('title')
                <div class="text-muted"> {{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label"> status </label>
            <select name="status" id="status">
                <option value="active"{{ $product->status == 'active' ? 'selected' : '' }}> active</option>
                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}> inactive</option>
                <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}> draft</option>
            </select>
            @error('status')
                <div class="text-muted"> {{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="">description </label>
            <textarea id="description" name="description" class="form-control" cols="30" rows="10">{{ $product->description }}</textarea>
        </div>
        @error('description')
            <div class="text-muted"> {{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputPassword1" class="">Upload file</label>
            @if ($product->image != null)
                <br><img src="/storage/{{ $product->image }}" alt="" width="200px" class="img-thumbnail mb-2">
            @endif
            <input type="file" class="form-control" name="image">
            @error('image')
                <div class="text-muted text-danger">{{ $message }}</div>
            @enderror
        </div>
        @error('image')
            <div class="text-muted"> {{ $message }}</div>
        @enderror
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"> Weight </label>
            <input type="text" class="form-control" name="weight" id="weight" aria-describedby="weight"
                value="{{ $product->weight }}">
            <div class="text-muted"></div>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label"> Price </label>
            <input type="number" class="form-control" name="price" id="price" aria-describedby="price"
                value="{{ $product->price }}">
            <div class="text-muted"></div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </body>

    </html>
@endsection
