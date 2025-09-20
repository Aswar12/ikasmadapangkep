@extends('layouts.dashboard')

@section('page-title', 'Edit Pengguna')

@section('navigation')
    @include('admin.menu')
@endsection

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-6">
        <h1 class="text-4xl font-extrabold text-gray-900">Edit Pengguna</h1>
        <p class="text-lg text-gray-600 mt-2">Perbarui informasi pengguna dengan mudah dan cepat.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 shadow-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-sm font-medium">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white shadow-lg rounded-lg p-8 max-w-3xl mx-auto">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                    class="w-full border border-gray-300 rounded-md px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Masukkan nama lengkap">
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                    class="w-full border border-gray-300 rounded-md px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Masukkan alamat email">
            </div>

            <div>
                <label for="role" class="block text-gray-700 font-semibold mb-2">Peran Pengguna</label>
                <select name="role" id="role" required
                    class="w-full border border-gray-300 rounded-md px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="sub_admin" {{ old('role', $user->role) == 'sub_admin' ? 'selected' : '' }}>Sub Admin</option>
                    <option value="department_coordinator" {{ old('role', $user->role) == 'department_coordinator' ? 'selected' : '' }}>Koordinator Departemen</option>
                    <option value="alumni" {{ old('role', $user->role) == 'alumni' ? 'selected' : '' }}>Alumni</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-gray-700 font-semibold mb-2">Status Pengguna</label>
                <select name="status" id="status" required
                    class="w-full border border-gray-300 rounded-md px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    <option value="approved" {{ old('status', $user->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ old('status', $user->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password <span class="text-sm font-normal text-gray-500">(Kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password" id="password"
                    class="w-full border border-gray-300 rounded-md px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" autocomplete="new-password" placeholder="Masukkan password baru">
            </div>

            <div class="md:col-span-2">
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full border border-gray-300 rounded-md px-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" autocomplete="new-password" placeholder="Konfirmasi password baru">
            </div>
        </div>

        <div class="mt-8 flex justify-between items-center">
            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                &larr; Kembali ke Daftar Pengguna
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
