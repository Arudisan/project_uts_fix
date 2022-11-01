@extends('layouts.dashboard')
@section('content')
    <h3> Jurusan {{ $categoryProduct->name }} </h3>
    <p>Jumlah siswa {{ count($categoryProduct->products) }}</p>
    <p>Jumlah siswa {{ $categoryProduct->products->count() }}</p>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Siswa </th>
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
