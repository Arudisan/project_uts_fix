@extends('admin.layouts.index')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ $product->id ? 'Edit' : 'Create' }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            @if ($product->id)
                                <form action="{{ route('product.update', ['product' => $product->id]) }}" method="post"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                @else
                                    <form action="{{ route('product.store') }}" method="post"
                                        enctype="multipart/form-data">
                            @endif
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="enter your name here" value="{{ $product->title }}">
                                    @error('title')
                                        <div class="text-muted"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-control" id="status">
                                        <option disabled selected>--choose status--</option>
                                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>active
                                        </option>
                                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>
                                            inactive</option>
                                        <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>draft
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="text-muted"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="description" cols="10" rows="5">{{ $product->description }}</textarea>
                                    @error('description')
                                        <div class="text-muted"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category" class="form-label">Category</label>
                                    <select name="category_id" class="form-control" id="category_id">
                                        <option selected disabled>--choose category--</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-muted"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name" class="form-label">Weight</label>
                                    <input type="text" class="form-control" id="weight" name="weight"
                                        value="{{ $product->weight }}">
                                    @error('weight')
                                        <div class="text-muted"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name" class="form-label">Price</label>
                                    <input type="text" class="form-control" id="price" name="price"
                                        value="{{ $product->price }}">
                                    @error('price')
                                        <div class="text-muted"> {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image" class="form-label">Image</label>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input"
                                            id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <img src="/storage/{{ $product->image }}" class="img-thumbnail" width="200px"
                                        height="200px">
                                    @error('image')
                                        <div class="text-muted"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
