@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class="fw-bold mb-0">Profil Saya</h3>
                    <span class="text-muted small">Kelola akun & keamanan</span>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        {{-- Tabs Navigation --}}
                        <ul class="nav nav-pills mb-4 gap-2" id="profileTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#avatar">
                                    Foto Profil
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#info">
                                    Informasi
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#password">
                                    Password
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#accounts">
                                    Akun Terhubung
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link text-danger" data-bs-toggle="pill" data-bs-target="#delete">
                                    Hapus Akun
                                </button>
                            </li>
                        </ul>

                        {{-- Tabs Content --}}
                        <div class="tab-content">

                            <div class="tab-pane fade show active" id="avatar">
                                @include('profile.partials.update-avatar-form')
                            </div>

                            <div class="tab-pane fade" id="info">
                                @include('profile.partials.update-profile-information-form')
                            </div>

                            <div class="tab-pane fade" id="password">
                                @include('profile.partials.update-password-form')
                            </div>

                            <div class="tab-pane fade" id="accounts">
                                @include('profile.partials.connected-accounts')
                            </div>

                            <div class="tab-pane fade" id="delete">
                                <div class="border border-danger rounded p-3">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
