<x-layouts title="Karyawan">
    <div class="card card-body">
        <div class="mb-2">
            <button class="btn btn-sm btn-success rounded-pill" onclick="addItem()">
                <i class="ti ti-plus"></i> TAMBAH
            </button>
        </div>
        <table class="table table-striped w-100" id="mydata">
            <thead>
                <tr>
                    <th width="10%">No.</th>
                    <th width="15%">Jabatan</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Telp</th>
                    <th width="10%">Status</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

    @pushOnce('scripts')
        <script src="{{ assets('pages/karyawan.js') }}"></script>
    @endPushOnce
</x-layouts>

<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="titleModal">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" autocomplete="off">
                    <input type="hidden" name="myid" id="myid">
                    <div class="mb-2">
                        <label class="form-label">Jabatan</label>
                        <select name="id_jabatan" class="form-control" required>
                            @if (count($jabatan) > 0)
                                <option value="">- Pilih -</option>
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item->id_jabatan }}">{{ $item->jabatan }}</option>
                                @endforeach
                            @else
                                <option value="">- Data Jabatan Tidak Ada -</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">NIK</label>
                        <input type="number" class="form-control" required name="nik">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" required name="nama">
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-8 form-group">
                            <label class="form-label">Telepon</label>
                            <input type="number" class="form-control" required name="telp">
                        </div>
                        <div class="col-lg-4 form-group">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </form>
                <button class="btn btn-primary" id="saveModal" onclick="action()">SIMPAN</button>
            </div>
        </div>
    </div>
</div>
