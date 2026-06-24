@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-4">
        <form action="{{ route('admin.candidates.store') }}" method="POST" enctype="multipart/form-data" class="card p-3 shadow-sm">
            @csrf
            <h5>Tambah Calon</h5>
            <input type="text" name="name" class="form-control mb-2" placeholder="Nama Calon" required>
            <input type="file" name="photo" class="form-control mb-2" required>
            <button class="btn btn-primary w-100">Simpan</button>
        </form>
    </div>
    <div class="col-md-8">
        <table class="table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($candidates as $c)
                <tr>
                    <td><img src="{{ asset('storage/'.$c->photo) }}" width="50"></td>
                    <td>{{ $c->name }}</td>
                    <td>
                        <form action="/admin/candidates/{{ $c->id }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
