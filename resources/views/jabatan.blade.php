<x-layouts title="Jabatan">
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
                    <th>Jabatan</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

    @pushOnce('scripts')
        <script src="{{ assets('pages/jabatan.js') }}"></script>
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
                        <input type="text" class="form-control" required name="jabatan">
                    </div>
                </form>
                <button class="btn btn-primary" id="saveModal" onclick="action()">SIMPAN</button>
            </div>
        </div>
    </div>
</div>
