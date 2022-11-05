@extends('layouts.dashboard')
@section('content')
    <h1 style="color:aliceblue">Hello, world!</h1>
    @if ($message = Session::get('notif'))
        <div class="alert alert-primary" role="alert">
            <strong>{{ $message }}</strong>
        </div>
    @endif
    <h3> Kategori {{ $categoryProduct->name }} </h3>
    <p>Jumlah Produk {{ count($categoryProduct->products) }}</p>
    <p>Jumlah Jumlah Produk {{ $categoryProduct->products->count() }}</p>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Produk </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categoryProduct->products as $product)
                <tr>
                    <th scope="row">{{ $loop->iteration }} </th>
                    <td>{{ $product->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
