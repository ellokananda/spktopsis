@extends('main')
@section('content')
<div class="container">
    <h2>Tambah Pengguna</h2>
    <form action="{{ route('pengguna.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="admin">Admin</option>
                <option value="koordinator bk">Koordinator BK</option>
                <option value="siswa">Siswa</option>
            </select>
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
