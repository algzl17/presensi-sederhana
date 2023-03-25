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
    $("#qr").val(null);
    $("#qr").focus();
    $("#label").text("Nama - Jabatan");
    showModal("mdQrcode");
}

function runinput(event) {
    var x = event.code;
    if (x == "Enter") {
        const val = $("#qr").val();
        axios
            .get(route("presensi.absen", val))
            .then(function (res) {
                if (res.data.status) {
                    $("#labelnama").text(res.data.result.nama);
                    $("#labeljabatan").text(res.data.result.jabatan);
                    Swal.fire({
                        icon: "success",
                        text: "Berhasil presensi",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                    reload_table();
                } else {
                    Swal.fire({
                        icon: "error",
                        text: res.data.error,
                        showConfirmButton: false,
                        timer: 1000,
                    });
                }
                $("#qr").val(null);
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
}

// sunting
function editpre(id) {
    axios
        .get(route("presensi.edit", id))
        .then(function (response) {
            const dt = response.data;
            $("#labidk").val(dt.idk);
            $("#lab_nik").text(dt.nik);
            $("#lab_nama").text(dt.nama);
            $("#lab_jabatan").text(dt.jabatan);
            $("#ket").val(dt.status);
            if (dt.masuk) {
                $("#lab_masuk").text(dt.masuk);
                $("#btnmasuk").attr("hidden", false);
            } else {
                $("#lab_masuk").text("-");
                $("#btnmasuk").attr("hidden", true);
            }
            if (dt.pulang) {
                $("#lab_pulang").text(dt.pulang);
                $("#btnpulang").attr("hidden", false);
            } else {
                $("#lab_pulang").text("-");
                $("#btnpulang").attr("hidden", true);
            }
            showModal();
        })
        .catch(function (error) {
            console.log("error");
        });
}

function updateku(stt) {
    axios
        .get(route("presensi.update", $("#labidk").val()) + "?status=" + stt)
        .then(function (response) {
            reload_table();
            hideModal();
            Swal.fire({
                icon: "success",
                text: "Berhasil merubah keterangan absensi",
                showConfirmButton: false,
                timer: 1000,
            });
        })
        .catch(function (error) {
            console.log("error");
        });
}

function batal(tipe) {
    Swal.fire({
        title: "MEMBATALKAN ABSENSI",
        text: "Anda yakin membatalkan presensi " + tipe,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#DE3333",
        cancelButtonColor: "#919294",
        confirmButtonText: "Yakin",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            const v = $("#labidk").val();
            axios
                .get(route("presensi.batal", v) + "?tipe=" + tipe)
                .then(function (response) {
                    reload_table();
                    editpre(v);
                    Swal.fire({
                        icon: "success",
                        text: "Berhasil batal absensi",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                })
                .catch(function (error) {
                    console.log("error");
                });
        }
    });
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
});
