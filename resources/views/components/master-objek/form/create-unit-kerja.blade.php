<div class="modal fade" id="modal-create-unitkerja" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal-create-unitkerja-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-create-unitkerja-label">Form Tambah Unit Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('master-unit-kerja.store') }}" enctype="multipart/form-data"
                class="needs-validation" novalidate="">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="kode_wilayah">Kode Wilayah</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="kode_wilayah"
                                value="{{ old('kode_wilayah') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="kode_unitkerja">Kode Unit Kerja</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="kode_unitkerja"
                                value="{{ old('kode_unitkerja') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" value="{{ old('nama') }}"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
