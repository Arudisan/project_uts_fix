@extends('admin.layouts.index')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">My Charts</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>QTY</th>
                            <th>Total</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['products'] as $product)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $product['id'] }}</td>
                                @foreach ($products as $pro)
                                    @if ($pro->id == $product['id'])
                                        <td>{{ $pro['title'] }}</td>
                                    @endif
                                @endforeach
                                <td>{{ $product['qty'] }}</td>
                                @foreach ($products as $pro)
                                    @if ($pro->id == $product['id'])
                                        <td>{{ $pro['price'] * $product['qty'] }}</td>
                                        <td>Gambar</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>QTY</th>
                            <th>Total</th>
                            <th>Image</th>
                        </tr>
                    </tfoot>
                </table>
                <br>
                <h5>Total Harga : Rp. {{ $totalHarga }}</h5>
            </div>
            <!-- /.card-body -->
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" placeholder="Enter name" name="customer" value="">
                        @error('customer')
                            <div class="text-muted text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @foreach ($data['products'] as $product)
                        <input type="hidden" name="product_id[]" value="{{ $product['id'] }}">
                        <input type="hidden" name="qty[]" value="{{ $product['qty'] }}">
                        @foreach ($products as $p)
                            @if ($p->id == $product['id'])
                                <input type="hidden" name="price[]" value="{{ $p['price'] * $product['qty'] }}">
                            @endif
                        @endforeach
                        <input type="hidden" name="total" value="{{ $totalHarga }}">
                    @endforeach
                    <div class="form-group">
                        <label for="exampleInputEmail1">Alamat</label>
                        <textarea name="address" class="form-control" cols="30" rows="10"></textarea>
                        @error('address')
                            <div class="text-muted text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                     <div class="form-group">
                        <label for="exampleInputEmail1">Email </label>
                         <input type="text" class="form-control" placeholder="Email example@mail" name="email" value="">
                        @error('email')
                            <div class="text-muted text-danger">{{ $message }}</div>
                        @enderror
                    </div> 
                    <button class="btn btn-danger">Bayar</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
@endsection
