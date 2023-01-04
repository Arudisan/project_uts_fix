@extends('admin.layouts.index')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaction detail #bf256bc4-dde2-4d8b-a754-acbd3a3b7c71</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <h5>Nama Pembeli : {{ $transaction->customer }}</h5>
                <h5>Alamat : {{ $transaction->address }}</h5>
                <h5>Total Harga : {{ @currency($transaction->total_amount) }}</h5>

            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>QTY</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($details as $detail)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $detail->product_id }}</td>
                                <td>{{ $detail->product->title }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ $detail->amount }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
