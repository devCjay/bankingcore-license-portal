@extends('layouts.app')
@section('title', 'Login - License Portal')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mt-5">
                <div class="card-body p-4">
                    <h1 class="h3 fw-bold mb-2">License Portal</h1>
                    <p class="text-muted mb-4">Enter the portal password to manage banking app licenses.</p>
                    <form method="post" action="{{ route('login.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg" required autofocus>
                        </div>
                        <button class="btn btn-primary w-100 btn-lg" type="submit">Login</button>
                    </form>
                    <p class="small text-muted mt-3 mb-0">Default password is set by LICENSE_PORTAL_PASSWORD in .env.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
