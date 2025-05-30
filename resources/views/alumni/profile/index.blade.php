@extends('layouts.alumni')

@section('page-title', 'Profil Saya')

@section('content')
<div class="container mx-auto py-8 px-4 font-poppins text-gray-900">
    <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg p-8">
        <div class="flex flex-col md:flex-row md:space-x-8">
            <!-- Profile Photo and Basic Info -->
            <div class="md:w-1/3 flex flex-col items-center border-r border-gray-200 pr-8">
                @if(isset($user) && $user->profile_photo_url)
                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-40 h-40 object-cover rounded-full shadow-md mb-4 border-4 border-blue-500">
                @else
                    <div class="w-40 h-40 bg-blue-100 rounded-full flex items-center justify-center mb-4 border-4 border-blue-500 shadow-md">
                        <i class="fas fa-user fa-6x text-blue-600"></i>
                    </div>
                @endif
                <h2 class="text-2xl font-bold mb-1">{{ $user->name }}</h2>
                <p class="text-blue-600 font-semibold mb-2">Alumni Angkatan {{ $profile->graduation_year ?? '-' }}</p>
                <a href="{{ route('alumni.profile.edit') }}" class="inline-block px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-md hover:from-blue-700 hover:to-blue-900 transition shadow-md">
                    <i class="fas fa-edit mr-2"></i>Edit Profil
                </a>
            </div>

            <!-- Profile Details -->
            <div class="md:w-2/3 mt-8 md:mt-0">
                <!-- Personal Information -->
                <section class="mb-8">
                    <h3 class="text-xl font-semibold text-blue-700 mb-4 border-b-2 border-blue-500 pb-2 flex items-center">
                        <i class="fas fa-user mr-3"></i>Informasi Pribadi
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Nama Lengkap</p>
                            <p>{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Email</p>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Nomor WhatsApp</p>
                            <p>{{ $user->whatsapp_formatted ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Jenis Kelamin</p>
                            <p>{{ $profile->gender ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Tempat Lahir</p>
                            <p>{{ $profile->birth_place ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Tanggal Lahir</p>
                            <p>{{ $profile->birth_date ? date('d M Y', strtotime($profile->birth_date)) : '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-semibold text-gray-500">Alamat</p>
                            <p>{{ $profile->address ?? '-' }}</p>
                        </div>
                    </div>
                </section>

                <!-- Academic Information -->
                <section class="mb-8">
                    <h3 class="text-xl font-semibold text-blue-700 mb-4 border-b-2 border-blue-500 pb-2 flex items-center">
                        <i class="fas fa-graduation-cap mr-3"></i>Informasi Akademik
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
                        <div>
                            <p class="text-sm font-semibold text-gray-500">NISN</p>
                            <p>{{ $profile->national_student_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Tahun Masuk</p>
                            <p>{{ $profile->entry_year ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Tahun Lulus</p>
                            <p>{{ $profile->graduation_year ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Nomor Ijazah</p>
                            <p>{{ $profile->diploma_number ?? '-' }}</p>
                        </div>
                    </div>
                </section>

                <!-- Family Information -->
                <section>
                    <h3 class="text-xl font-semibold text-blue-700 mb-4 border-b-2 border-blue-500 pb-2 flex items-center">
                        <i class="fas fa-users mr-3"></i>Informasi Keluarga
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Nama Ayah</p>
                            <p>{{ $profile->father_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Pekerjaan Ayah</p>
                            <p>{{ $profile->father_occupation ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Nama Ibu</p>
                            <p>{{ $profile->mother_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500">Pekerjaan Ibu</p>
                            <p>{{ $profile->mother_occupation ?? '-' }}</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
