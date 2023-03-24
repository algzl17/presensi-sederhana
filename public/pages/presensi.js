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
            { data: "nama", name: "nama" },
            { data: "status", name: "status" },
            { data: "masuk", name: "masuk" },
            { data: "pulang", name: "pulang" },
            {
                data: "aksi",
                name: "aksi",
                orderable: false,
                searchable: false,
            },
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

function qrcode() {
    const label = $("#pilih option:selected").text();
    $("#mdQrcodeLabel").text("Absensi QRcode | " + label);
    $("#qr").focus();
    showModal("mdQrcode");
}

function hideModal(id) {
    const modal_el = document.getElementById(id ?? "modal");
    const modal_obj = bootstrap.Modal.getInstance(modal_el);
    if (modal_obj == null) {
        return;
    }
    modal_obj.hide();
}

function showModal(id) {
    const modal_el = document.getElementById(id ?? "modal");
    let modal_obj = bootstrap.Modal.getInstance(modal_el);
    if (modal_obj == null) {
        modal_obj = new bootstrap.Modal(modal_el, {
            backdrop: "static",
        });
    }
    modal_obj.show();
}

function pilih(v) {
    axios
        .get(route("presensi.pilih", v))
        .then(function (response) {
            reload_table();
        })
        .catch(function (error) {
            console.log("error");
        });
}

$("body").on("shown.bs.modal", "#mdQrcode", function () {
    $("input:visible:enabled:first", this).focus();

    $("#qr").on("keypress", function (event) {
        if (event.which == 13 && !event.shiftKey) {
            const val = $("#qr").val();
            axios
                .get(route("presensi.absen", val))
                .then(function (res) {
                    if (res.data.status) {
                        const data = res.data.result;
                        reload_table();
                        console.log(data);
                    } else {
                        Swal.fire({
                            icon: "error",
                            text: res.data.error,
                            showConfirmButton: false,
                            timer: 1000,
                        });
                    }
                })
                .catch(function (error) {
                    Swal.fire({
                        icon: "error",
                        text: "Ups.. gagal, silakan ulangi lagi!",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                });
            event.preventDefault();
        }
    });
});
