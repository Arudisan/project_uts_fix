@extends('admin.layouts.index')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DataTables</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Product</h3><br>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <a href="{{ route('product.create') }}" class="btn btn-success mb-2">Tambah Data</a>
                                <table id="example2" class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Weight</th>
                                            <th scope="col">category</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $list)
                                            <tr>
                                                {{-- untuk generate nomer urut otomatis --}}
                                                <th scope="row">
                                                    {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                                </th>
                                                {{-- untuk memanggil data dari database dan di tampilkan --}}
                                                <td>{{ $list->title }}</td>
                                                <td>{{ $list->description }}</td>
                                                <td>
                                                    @if ($list->status == 'active')
                                                        <h5><span class="badge bg-success">{{ $list->status }}</span></h5>
                                                    @elseif ($list->status == 'draft')
                                                        <h5><span class="badge bg-warning">{{ $list->status }}</span></h5>
                                                    @else
                                                        <h5><span class="badge bg-danger">{{ $list->status }}</span></h5>
                                                    @endif
                                                </td>
                                                <td>{{ $list->price }}</td>
                                                <td>{{ $list->weight }}</td>
                                                {{-- ditambahkan name karna untuk memanggil name dari table major yang sebabnya sudah ada belongsto --}}
                                                <td>{{ $list->category->name }}</td>
                                                <td><img src="/storage/{{ $list->image }}" class="img-thumbnail"
                                                        width="200px" height="200px"></td>
                                                <td>
                                                    <a href="{{ route('product.edit', ['product' => $list->id]) }}"
                                                        class="btn btn-warning">Edit</a>
                                                    {{-- untuk hapus data di table --}}
                                                    <form action="{{ route('product.destroy', ['product' => $list->id]) }}"
                                                        class="d-inline" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-success">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Weight</th>
                                            <th scope="col">category</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                {{ $data->withQueryString()->links() }}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
