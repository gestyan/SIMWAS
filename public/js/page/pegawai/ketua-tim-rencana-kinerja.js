let table = $("#tim-kerja");
// Index Rencana Kinerja
$(function () {
    table
        .DataTable({
            dom: "Bfrtip",
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: [
                {
                    extend: "excel",
                    className: "btn-success",
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    },
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#master-iku_wrapper .col-md-6:eq(0)");
});

// Show rencana kinerja
$("#btn-modal-create-tugas").on("click", function () {
    $("#error-tugas").text("");
    $("#error-mulai").text("");
    $("#error-selesai").text("");
    $("#error-hasilkerja").text("");
});

$("#create-hasilkerja").on("change", function () {
    let dataId = $("#create-hasilkerja option:selected").val();
    $.ajax({
        url: `/admin/master-hasil/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            console.log(response);
            $("#create-unsur").val(response.data[0].unsur);
            $("#create-subunsur1").val(response.data[0].subunsur1);
            $("#create-subunsur2").val(response.data[0].subunsur2);
            $("#create-kategori_pelaksana").val(
                response.data[0].kategori_pelaksana
            );
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#btn-tambah-tugas").on("click", function (e) {
    e.preventDefault();
    $("#error-tugas").text("");
    $("#error-mulai").text("");
    $("#error-selesai").text("");
    $("#error-hasilkerja").text("");
    let token = $("meta[name='csrf-token']").attr("content");
    let id_timkerja = $("#id_timkerja").val();
    let tugas = $("#create-tugas").val();
    let mulai = $("#create-mulai").val();
    let selesai = $("#create-selesai").val();
    let hasilkerja = $("#create-hasilkerja").val();
    let kategori_pelaksana = $("#create-kategori_pelaksana").val();

    $.ajax({
        url: `/ketua-tim/rencana-kinerja`,
        type: "POST",
        cache: false,
        data: {
            _token: token,
            id_timkerja: id_timkerja,
            tugas: tugas,
            mulai: mulai,
            selesai: selesai,
            hasilkerja: hasilkerja,
            kategori_pelaksana: kategori_pelaksana,
        },
        success: function (response) {
            location.reload();
        },
        error: function (error) {
            console.log(error);
            let errorResponses = error.responseJSON;
            let errors = Object.entries(errorResponses.errors);

            errors.forEach(([key, value]) => {
                let errorMessage = document.getElementById(`error-${key}`);
                errorMessage.innerText = `${value}`;
            });
        },
    });
});

$("#id_hasilkerja").on("change", function () {
    let dataId = $("#id_hasilkerja option:selected").val();
    console.log(dataId);
    $.ajax({
        url: `/admin/master-hasil/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            console.log(response);
            $("#subunsur1").val(response.data[0].subunsur1);
            $("#subunsur2").val(response.data[0].subunsur2);
            $("#kategori_hasilkerja").val(response.data[0].kategori_hasilkerja);
            $("#kategori_pelaksana").val(response.data[0].kategori_pelaksana);
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#id_sasaran").on("change", function () {
    let idtujuan = $("#id_sasaran option:selected").data("idtujuan");
    $("#id_tujuan").val(idtujuan);
});

$("#edit-id_sasaran").on("change", function () {
    let id_tujuan = $("#edit-id_sasaran option:selected").data("idtujuan");
    $("#edit-id_tujuan").val(id_tujuan);
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    dataId = JSON.stringify(dataId);
    let url = "/pegawai/tim-pelaksana/" + dataId;
    console.log(url);
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let id_tujuan = $("#edit-id_tujuan").val();
    let id_sasaran = $("#edit-id_sasaran").val();
    let id_iku = $("#edit-id_iku").val();
    let iku = $("#edit-iku").val();

    $.ajax({
        url: `/admin/master-iku/${id_iku}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            id_iku: id_iku,
            id_sasaran: id_sasaran,
            iku: iku,
        },
        success: function (response) {
            Swal.fire({
                type: "success",
                icon: "success",
                title: "Berhasil!",
                text: `${response.message}`,
                showConfirmButton: false,
                timer: 3000,
            });

            $("#modal-edit-masteriku").modal("hide");
            setTimeout(location.reload(), 1000);
            console.log(response.data[0]);
        },
        error: function (error) {
            console.log(error.responseJSON);
        },
    });
});

// Delete Data
$(".delete-btn").on("click", function (e) {
    e.preventDefault();
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data tidak dapat dipulihkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/ketua-tim/rencana-kinerja/${dataId}`,
                type: "DELETE",
                cache: false,
                data: {
                    _token: token,
                },
                success: function (response) {
                    location.reload();
                },
            });
        }
    });
});

$("#btn-send-rencana-kerja").on("click", function (e) {
    e.preventDefault();
    let id_timkerja = $("#id_timkerja").val();
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Rencana Kerja yang telah dikirim tidak dapat diubah kembali!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/ketua-tim/rencana-kinerja/send/${id_timkerja}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    id_timkerja: id_timkerja,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});

$("#btn-admin-submit-rk").on("click", function (e) {
    e.preventDefault();
    let id_timkerja = $("#id_timkerja").val();
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Rencana Kerja yang telah dikirim tidak dapat diubah kembali!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/rencana-kinerja/send/${id_timkerja}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    id_timkerja: id_timkerja,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});

$("#btn-admin-send-back").on("click", function (e) {
    e.preventDefault();
    let id_timkerja = $("#id_timkerja").val();
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Rencana Kerja akan dikembalikan untuk direvisi!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--primary)",
        cancelButtonColor: "var(--danger)",
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/rencana-kinerja/return/${id_timkerja}`,
                type: "PUT",
                cache: false,
                data: {
                    _token: token,
                    id_timkerja: id_timkerja,
                },
                success: function (response) {
                    location.reload();
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});

// Taruh dipaling bawah, Soalnya nanti ngaruh ke function yang laen
let rupiah = document.getElementsByClassName("rupiah");
for (i = 0; i <= rupiah.length - 1; i++) {
    let tmp = rupiah[i].innerText.toString();
    rupiah[i].innerText = formatRupiah(tmp, "Rp. ");
}
