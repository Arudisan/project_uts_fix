@extends('layouts.dashboard')
@section('content')
    <h1>Hello, world!</h1>
    {{-- @if ($message = Session::get('notif'))
        <div class="alert alert-primary" role="alert">
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <form class="row g-3" action="{{ route('products.index') }}" method="GET">
        <div class="col-auto">
            <select name="filter" id="filter" class="form-select">
                <option value="">All</option>
                @foreach ($categorys as $category)
                    <option value="{{ $category->id }}" {{ request('filter') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <label for="search" class="visually-hidden"></label>
            <input type="text" name="search" class="form-control" id="search" placeholder="Search"
                value="{{ request('search') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Cari</button>
        </div>
    </form> --}}
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                {{-- <th scope="col">Category_id</th> --}}
                <th scope="col">title</th>
                <th scope="col">status</th>
                <th scope="col">description</th>
                <th scope="col">image</th>
                <th scope="col">weight</th>
                <th scope="col">price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->description }}</td>
                    <td><img src="/storage/{{ $item->image}}" alt="" width="200px" height="300px"></td>
                    <td>{{ $item->weight }}</td>
                    <td>{{ $item->price }}</td>
                    {{-- <td><img src="/storage/{{ $item->image}}" alt="" width="200px" height="300px"> --}}
                    <td>
                        <a href="{{ route('product.edit', ['product' => $item->id]) }}" class="btn btn-primary">edit</a>
                        <form action="{{ route('product.destroy', ['product' => $item->id]) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {{ $data->links() }} --}}
@endsection
