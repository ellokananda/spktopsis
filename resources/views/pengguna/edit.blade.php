@extends('main')

@section('content')
<div class="container">
    <h2>Edit Pengguna</h2>
    <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="admin" {{ old('role', $pengguna->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="koordinator bk" {{ old('role', $pengguna->role) == 'koordinator bk' ? 'selected' : '' }}>Koordinator BK</option>
                <option value="siswa" {{ old('role', $pengguna->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
            </select>
            @error('role')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $pengguna->username) }}" required>
            @error('username')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Password (biarkan kosong jika tidak ingin diubah)</label>
            <input type="password" name="password" class="form-control">
            <small class="form-text text-muted">Jika Anda tidak ingin mengubah password, biarkan kosong.</small>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
