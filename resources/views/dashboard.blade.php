@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Selamat datang, {{ Auth::user()->name }}!</h4>
                    
                    <div class="mt-4">
                        <h5>Informasi Akun:</h5>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Nama:</strong> {{ Auth::user()->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Username:</strong> {{ Auth::user()->username }}
                            </li>
                            <li class="list-group-item">
                                <strong>Email:</strong> {{ Auth::user()->email }}
                            </li>
                            <li class="list-group-item">
                                <strong>No. WhatsApp:</strong> {{ Auth::user()->phone }}
                            </li>
                            <li class="list-group-item">
                                <strong>Status:</strong> 
                                <span class="badge bg-success">Aktif</span>
                            </li>
                            <li class="list-group-item">
                                <strong>Role:</strong> {{ Auth::user()->role }}
                            </li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
