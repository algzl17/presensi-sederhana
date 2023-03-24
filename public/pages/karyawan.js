$(function () {
    table = $("#mydata").DataTable({
        processing: true,
        serverSide: true,
        ajax: window.location.href,
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false,
            },
            { data: "jabatan.jabatan", name: "jabatan.jabatan" },
            { data: "nik", name: "nik" },
            { data: "nama", name: "nama" },
            { data: "telp", name: "telp" },
            { data: "status", name: "status" },
            { data: "aksi", name: "aksi", orderable: false, searchable: false },
        ],
        lengthMenu: [10, 20, 50, 100],
        order: [],
        language: {
            searchPlaceholder: "Cari Data..",
            sSearch: "",
            lengthMenu: "_MENU_",
            oPaginate: {
                sNext: '<i class="fa-solid fa-angle-right"></i>',
                sPrevious: '<i class="fa-solid fa-angle-left"></i>',
                sFirst: '<i class="fa-solid fa-angles-left"></i>',
                sLast: '<i class="fa-solid fa-angles-right"></i>',
            },
        },

        drawCallback: function () {
            $("body").tooltip({ selector: '[data-bs-toggle="tooltip"]' });
        },
    });
});

function reload_table() {
    table.ajax.reload(null, false);
}

function addItem() {
    $("#titleModal").text("Tambah Karyawan");
    $("#saveModal").text("Tambah");
    $("#myid").val("add");
    $("#form")[0].reset();
    $("#form").parsley().reset();
    showModal();
}

function editItem(id) {
    axios
        .get(route("karyawan.edit", id))
        .then(function (response) {
            $("#form")[0].reset();
            $("#form").parsley().reset();
            $("#myid").val(response.data.id_karyawan);
            $("[name='id_jabatan']").val(response.data.id_jabatan);
            $("[name='nik']").val(response.data.nik);
            $("[name='nama']").val(response.data.nama);
            $("[name='telp']").val(response.data.telp);
            $("[name=status]").val(response.data.status);
            $("#saveModal").text("Simpan");
            $("#titleModal").text("Sunting Karyawan");
            showModal();
        })
        .catch(function (error) {
            console.log("error");
        });
}

function action() {
    var form = $("#form").parsley();
    if (form.isValid()) {
        var id = $("#myid").val();
        if (id == "add") {
            axios
                .post(route("karyawan.store"), $("#form").serialize())
                .then(function (response) {
                    reload_table();
                    hideModal();
                    Swal.fire({
                        icon: "success",
                        text: "Berhasil tambah data",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                })
                .catch(function (error) {
                    Swal.fire({
                        icon: "error",
                        text: "Ups.. gagal, silakan ulangi lagi!",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                });
        } else {
            axios
                .put(route("karyawan.update", id), $("#form").serialize())
                .then(function (response) {
                    reload_table();
                    hideModal();
                    Swal.fire({
                        icon: "success",
                        text: "Berhasil sunting data",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                })
                .catch(function (error) {
                    Swal.fire({
                        icon: "error",
                        text: "Ups.. gagal, silakan ulangi lagi!",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                });
        }
    } else {
        form.validate();
    }
}

function deleteItem(id) {
    Swal.fire({
        title: "Anda Yakin?",
        text: "ingin menghapus data karyawan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus",
        cancelButtonText: "Tidak, Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .delete(route("karyawan.destroy", id))
                .then(function (response) {
                    reload_table();
                    Swal.close();
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil hapus data",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                })
                .catch(function (error) {
                    Swal.fire({
                        icon: "error",
                        text: "Ups.. gagal, silakan ulangi lagi!",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                });
        }
    });
}

function hideModal() {
    const modal_el = document.getElementById("modal");
    const modal_obj = bootstrap.Modal.getInstance(modal_el);
    if (modal_obj == null) {
        return;
    }
    modal_obj.hide();
}

function showModal() {
    const modal_el = document.getElementById("modal");
    let modal_obj = bootstrap.Modal.getInstance(modal_el);
    if (modal_obj == null) {
        modal_obj = new bootstrap.Modal(modal_el, {
            backdrop: "static",
        });
    }
    modal_obj.show();
}
