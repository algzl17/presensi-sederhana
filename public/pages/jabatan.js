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
            { data: "jabatan", name: "jabatan" },
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
    $("#titleModal").text("Tambah Jabatan");
    $("#saveModal").text("Tambah");
    $("#myid").val("add");
    $("#form")[0].reset();
    $("#form").parsley().reset();
    showModal();
}

function editItem(id) {
    axios
        .get(route("jabatan.edit", id))
        .then(function (response) {
            $("#form")[0].reset();
            $("#form").parsley().reset();
            $("#myid").val(response.data.id_jabatan);
            $("[name='jabatan']").val(response.data.jabatan);
            $("#saveModal").text("Simpan");
            $("#titleModal").text("Sunting jabatan");
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
                .post(route("jabatan.store"), $("#form").serialize())
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
                        text: "Ups, gagal, silakan ulangi lagi!",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                });
        } else {
            axios
                .put(route("jabatan.update", id), $("#form").serialize())
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
                        text: "Ups, gagal, silakan ulangi lagi!",
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
        text: "ingin menghapus data jabatan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus",
        cancelButtonText: "Tidak, Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .delete(route("jabatan.destroy", id))
                .then(function (response) {
                    reload_table();
                    Swal.close();
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Berhasil hapus data",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                })
                .catch(function (error) {
                    Swal.fire({
                        icon: "error",
                        text: "Ups, gagal, silakan ulangi lagi!",
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
