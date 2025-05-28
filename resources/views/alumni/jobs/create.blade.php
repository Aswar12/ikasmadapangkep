@extends('layouts.alumni')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Buat Lowongan Kerja Baru</h1>
    
    <form action="{{ route('alumni.jobs.store') }}" method="POST" class="max-w-2xl mx-auto">
        @csrf
        
        <div class="mb-4">
            <label for="position" class="block text-sm font-medium text-gray-700 mb-2">Posisi</label>
            <input type="text" id="position" name="position" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        
        <div class="mb-4">
            <label for="company" class="block text-sm font-medium text-gray-700 mb-2">Perusahaan</label>
            <input type="text" id="company" name="company" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Pekerjaan</label>
            <textarea id="description" name="description" rows="6" required
                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>
        
        <div class="mb-4">
            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Batas Waktu</label>
            <input type="date" id="deadline" name="deadline" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Simpan Lowongan
            </button>
        </div>
    </form>
</div>
@endsection
