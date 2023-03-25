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
                <input type="text" class="form-control text-center" onkeypress="runinput(event)" placeholder="QRCODE"
                    autocomplete="off" id="qr">
                <ul class="list-group mt-4 mb-2 mx-3 text-center">
                    <li class="list-group-item">
                        <b id="labelnama" class="text-uppercase">Nama</b>
                    </li>
                    <li class="list-group-item" id="labeljabatan">Jabatan</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="mdQrcodeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">SUNTING ABSENSI</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <input type="hidden" id="labidk">
                                <small>NIK</small>
                                <div class="fw-bold" id="lab_nik">-</div>
                            </li>
                            <li class="list-group-item">
                                <small>Nama</small>
                                <div class="fw-bold" id="lab_nama">-</div>
                            </li>
                            <li class="list-group-item">
                                <small>Jabatan</small>
                                <div class="fw-bold" id="lab_jabatan">-</div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Presensi</label>
                            <select name="status" class="form-control" id="ket" onchange="updateku(this.value)">
                                <option value="">BELUM</option>
                                <option value="H" disabled>HADIR</option>
                                <option value="I">IZIN</option>
                                <option value="A">ALPHA</option>
                            </select>
                        </div>
                        <ol class="list-group mt-2">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">MASUK</div>
                                    <span id="lab_masuk">-</span>
                                </div>
                                <a href="javascript:void(0);" onclick="batal('masuk')" hidden id="btnmasuk"><i
                                        class="fa-regular fa-circle-xmark text-danger"></i></a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">PULANG</div>
                                    <span id="lab_pulang">-</span>
                                </div>
                                <a href="javascript:void(0);" onclick="batal('pulang')" hidden id="btnpulang"><i
                                        class="fa-regular fa-circle-xmark text-danger"></i></a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
