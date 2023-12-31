@extends('layouts.app')

@section('title', 'Norma Hasil')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    @include('components.sekretaris-header')
    @include('components.sekretaris-sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Norma Hasil</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/sekretaris/dashboard">Dashboard</a></div>
                    <div class="breadcrumb-item active"><a href="/sekretaris/norma-hasil">Norma Hasil</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="pt-1 pb-1 m-4">
                                    <form action="/sekretaris/norma-hasil/{{ $usulan->id }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $usulan->id }}">
                                        <input type="hidden" name="status" value="2">
                                        <input type="hidden" name="edit" value="1">
                                        <div class="form-group">
                                            <div class="control-label">Backdate</div>
                                            <div class="custom-switches-stacked mt-2">
                                                <label class="custom-switch">
                                                    <input type="radio"
                                                        name="is_backdate"
                                                        value="1"
                                                        class="custom-switch-input"
                                                        {{ old('is_backdate', $usulan->is_backdate) == '1' ? 'checked' : '' }}
                                                        onchange="toggleBackdateInput(this)">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Ya</span>
                                                </label>
                                                <label class="custom-switch">
                                                    <input type="radio"
                                                        name="is_backdate"
                                                        value="0"
                                                        class="custom-switch-input"
                                                        {{ old('is_backdate', $usulan->is_backdate) == '0' ? 'checked' : '' }}
                                                        onchange="toggleBackdateInput(this)">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Tidak</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" id="tanggalInputContainer" style="display: none;">
                                            <label>Tanggal</label>
                                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal', $usulan->tanggal) }}">
                                            @error('tanggal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="st_kinerja_id">ST Kinerja</label>
                                            <select class="form-control select2 @error('st_kinerja_id') is-invalid @enderror" id="st_kinerja_id" name="st_kinerja_id">
                                                <option value="">Pilih st kinerja</option>
                                                @foreach ($stks as $stk)
                                                    <option value="{{ $stk->id }}" {{ old('st_kinerja_id', $usulan->st_kinerja_id) == $stk->id ? 'selected' : '' }}>{{ $stk->no_surat }}</option>
                                                @endforeach
                                            </select>
                                            @error('st_kinerja_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="hal">Hal</label>
                                            <input type="text" class="form-control @error('hal') is-invalid @enderror" id="hal" name="hal" value="{{ old('hal', $usulan->hal) }}">
                                            @error('hal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="draft">Upload draft</label>
                                            <input type="file" class="form-control @error('draft') is-invalid @enderror" name="draft" accept=".docx, .doc" id="draft" value="{{ old('draft') }}">
                                            @error('draft')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset() }}"></script> --}}
    {{-- <script src="{{ asset() }}"></script> --}}
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                var tanggalInputContainer = document.getElementById('tanggalInputContainer');
                var isBackdateInput = document.querySelector('input[name="is_backdate"]:checked');
                toggleBackdateInput(isBackdateInput, tanggalInputContainer);
        });

        function toggleBackdateInput(input, tanggalInputContainer) {
            var tanggalInputContainer = document.getElementById('tanggalInputContainer');
        
            if (input.value === '1') {
                tanggalInputContainer.style.display = 'block';
            } else {
                tanggalInputContainer.style.display = 'none';
            }
        }        
    </script>
@endpush
