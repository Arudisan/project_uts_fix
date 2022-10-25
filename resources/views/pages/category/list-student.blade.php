@extends('layouts.dashboard')
@section('content')
<h3> Jurusan {{ $major->name }}   </h3>
<p>Jumlah siswa {{count($major->students)  }}</p>
<p>Jumlah siswa {{$major->students->count()  }}</p>
<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Siswa </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($major->students as $student)
        <tr>
            <th scope="row">{{ $loop->iteration }} </th>
            <td>{{ $student->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
