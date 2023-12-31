@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.css">
@endpush

@section('main')
    @include('components.admin-header')
    @include('components.admin-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Tambah Pegawai</h1>
            </div>
            <div class="row">
                <div class=" col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 pb-0">
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="javascript(0);" id="btn-back">
                                        <i class="fas fa-chevron-circle-left mr-2"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <form method="POST" action="/admin/master-pegawai" class="needs-validation" novalidate="">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="name">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="name" required
                                                value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="email">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="email" required
                                                value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="nip">NIP</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="nip" required value="{{ old('nip') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="pangkat">Pangkat</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="pangkat" required>
                                                @foreach ($pangkat as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('pangkat') == $key ? 'selected' : '' }}>{{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="unit_kerja">Unit Kerja</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="unit_kerja" required>
                                                @foreach ($unit_kerja as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('unit_kerja') == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="jabatan">Jabatan</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="jabatan" required>
                                                @foreach ($jabatan as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('jabatan') == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @foreach ($role as $key => $value)
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Sebagai {{ $value }}</label>
                                            <div class="col-sm-9 d-flex align-items-center">
                                                <div class="form-check form-check-inline mr-4">
                                                    <input class="form-check-input" type="radio"
                                                        name="{{ $key }}" id="{{ $key }}_true"
                                                        value="1" {{ old($key) === '1' ? 'checked="checked"' : '' }}
                                                        required>
                                                    <Label class="form-check-label"
                                                        for="{{ $key }}_true">Ya</Label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="{{ $key }}" id="{{ $key }}_false"
                                                        value="0" {{ old($key) === '0' ? 'checked="checked"' : '' }}>
                                                    <Label class="form-check-label"
                                                        for="{{ $key }}_false">Tidak</Label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-save"></i>
                                            Simpan
                                        </button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/admin/master-pegawai.js') }}"></script>
@endpush
