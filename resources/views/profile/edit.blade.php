{{-- resources/views/profile/edit.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4">Profil Saya</h2>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- 1. Avatar Information --}}
                <div class="card mb-4">
                    <div class="card-header bg-white fw-bold">Foto Profil</div>
                    <div class="card-body">
                        @include('profile.partials.update-avatar-form')
                    </div>
                </div>

                {{-- 2. Profile Information --}}
                <div class="card mb-4">
                    <div class="card-header bg-white fw-bold">Informasi Profil</div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- 3. Update Password --}}
                <div class="card mb-4">
                    <div class="card-header bg-white fw-bold">Update Password</div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- 4. Connected Accounts --}}
                <div class="card mb-4">
                    <div class="card-header bg-white fw-bold">Akun Terhubung</div>
                    <div class="card-body">
                        @include('profile.partials.connected-accounts')
                    </div>
                </div>

                {{-- 5. Delete Account --}}
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white fw-bold">Hapus Akun</div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
