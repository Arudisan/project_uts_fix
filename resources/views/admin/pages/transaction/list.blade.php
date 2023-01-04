@extends('admin.layouts.index')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $list)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $list->id }}</td>
                                <td>{{ $list->customer }}</td>
                                <td>{{ @currency($list->total_amount) }} </td>
                                <td>
                                    <a href="{{ route('transaction.show', ['transaction' => $list->id]) }}"
                                        class="btn btn-primary">detail</a>
                                </td>
                            </tr>
                        @endforeach
                </table>
                <br>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
