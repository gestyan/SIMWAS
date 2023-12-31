@extends('layouts.app')

@section('title', 'Tambah Master Anggaran')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/dist/sweetalert2.min.css') }}">
@endpush

@section('main')
    @include('components.admin-header')
    @include('components.admin-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Tambah Master Anggaran</h1>
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
                            <form method="POST" action="{{ route('master-anggaran.store') }}" class="needs-validation"
                                novalidate="">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="program">Program</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="program" disabled
                                                value="{{ old('program', $program_manggaran) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="id_kegiatan">Id Kegiatan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="id_kegiatan"
                                                value="{{ old('id_kegiatan') }}" required>
                                            @error('id_kegiatan')
                                                <small class="text-danger">
                                                    {{ trans($message) }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="kegiatan">Kegiatan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="kegiatan"
                                                value="{{ old('kegiatan') }}" required>
                                            @error('kegiatan')
                                                <small class="text-danger">
                                                    {{ trans($message) }}
                                                </small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
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
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/datatables.min.js"></script>
    <script src="{{ asset('library') }}/sweetalert2/dist/sweetalert2.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/admin/master-anggaran.js') }}"></script>
@endpush
