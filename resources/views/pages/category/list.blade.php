@extends('layouts.dashboard')
@section('content')
<h1>Hello, world!</h1>
@if($message = Session::get('notif'))
<div class="alert alert-primary" role="alert">
    <strong>{{ $message }}</strong>
  </div>
  @endif
<table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">id</th>
        <th scope="col">name</th>
        <th scope="col">Description</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
        @foreach ( $data as $item )
      <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td>{{ $item->id}}</td>
        <td>{{ $item->name}}</td>
        <td>{{ $item->description}}</td>
        <td>{{ $item->status}}</td>
        <td>
            {{-- <a href="{{route('category.show',['CategoryProduct'=>$item->id]) }}" class="btn btn-primary"> Students</a> --}}
            <a href="{{route('category.edit',['category'=>$item->id]) }}" class="btn btn-primary">edit</a>
            <form action="{{ route('category.destroy',['category'=> $item->id]) }}" method="post">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
      </tr>
      @endforeach
  </table>
@endsection
