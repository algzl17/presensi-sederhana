<x-layouts title="Absensi">
    <div class="d-flex justify-content-start gap-3 mb-3">
        <button class="btn btn-danger rounded-pill" onclick="qrcode()">
            <i class="ti ti-qrcode me-2"></i>QR code
        </button>
        <div class="form-group">
            <select class="form-control" id="pilih" onchange="pilih(this.value)">
                <option {{ session('absen') == 'masuk' ? 'selected' : '' }} value="masuk">MASUK</option>
                <option {{ session('absen') == 'pulang' ? 'selected' : '' }} value="pulang">PULANG</option>
            </select>
        </div>
    </div>
    <div class="card card-body">
        <table class="table table-striped w-100" id="mydata">
            <thead>
                <tr>
                    <th width="10%">No.</th>
                    <th>Jabatan</th>
                    <th>Nama Pegawai</th>
                    <th>Status</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th width="3%">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

    @pushOnce('scripts')
        <script src="{{ assets('pages/presensi.js') }}"></script>
    @endPushOnce
</x-layouts>

<div class="modal fade" id="mdQrcode" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="mdQrcodeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 mx-auto" id="mdQrcodeLabel">ABSENSI QRCODE</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control text-center" placeholder="QRCODE" autocomplete="off"
                    id="qr">
                <ul class="list-group mt-4 mb-2 mx-3 text-center">
                    <li class="list-group-item">Nama - Jabatan</li>
                    <li class="list-group-item">
                        <div class="d-grid">
                            <button class="btn btn-warning" disabled type="button">BATAL</button>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>
