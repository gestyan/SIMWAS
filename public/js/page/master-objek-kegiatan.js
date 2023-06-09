let table = $("#master-objek-kegiatan");

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
                    exportOptions: {
                        columns: [0, 1],
                    },
                },
                {
                    extend: "pdf",
                    className: "btn-danger",
                    exportOptions: {
                        columns: [0, 1],
                    },
                },
            ],
        })
        .buttons()
        .container()
        .appendTo("#master-objek-kegiatan_wrapper .col-md-6:eq(0)");
});

$("#kode_unitkerja").on("change", function (e) {
    e.preventDefault();
    let kodeunitkerja = $("#kode_unitkerja").val();

    $.ajax({
        type: "GET",
        url: `/admin/objek-kegiatan/count/${kodeunitkerja}`,
        cache: false,
        success: function (response) {
            $("#nama_unitkerja").val(
                $("#kode_unitkerja option:selected").text()
            );
            let count = response.data.count;
            let kodekegiatanvalue = $("#kode_kegiatan").val();
            if (Number(count) < 10) {
                kodekegiatanvalue = kodeunitkerja.concat("0", Number(count));
                $("#kode_kegiatan").val(kodekegiatanvalue);
            }
            console.log(Number(count));
        },
        error: function (error) {
            console.log(error);
        },
    });
    console.log();
});

$(".edit-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    $.ajax({
        url: `/admin/objek-kegiatan/${dataId}`,
        type: "GET",
        cache: false,
        success: function (response) {
            $("#edit-nama_unitkerja").val(response.data[0].nama_unitkerja);
            $("#edit-kode_unitkerja").val(response.data[0].kode_unitkerja);
            $("#edit-kode_kegiatan").val(response.data[0].kode_kegiatan);
            $("#edit-nama").val(response.data[0].nama);

            console.log(response.data[0]);
        },
    });
});

$("#btn-edit-submit").on("click", function (e) {
    e.preventDefault();

    let token = $("meta[name='csrf-token']").attr("content");

    let nama_unitkerja = $("#edit-nama_unitkerja").val();
    let kode_unitkerja = $("#edit-kode_unitkerja").val();
    let kode_kegiatan = $("#edit-kode_kegiatan").val();
    let nama = $("#edit-nama").val();

    $.ajax({
        url: `/admin/objek-kegiatan/${kode_kegiatan}`,
        type: "PUT",
        cache: false,
        data: {
            _token: token,
            nama_unitkerja: nama_unitkerja,
            kode_unitkerja: kode_unitkerja,
            kode_kegiatan: kode_kegiatan,
            nama: nama,
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

            let satuankerja = `
                <tr id="index_${response.data[0].kode_kegiatan}">
                    <td>${response.data[0].kode_kegiatan}</td>
                    <td>${response.data[0].nama_unitkerja}</td>
                    <td>${response.data[0].nama}</td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-warning edit-btn"
                            data-id="${response.data[0].kode_kegiatan}" style="width: 42px"
                            data-toggle="modal" data-target="#modal-edit-objekkegiatan">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger delete-btn"
                            data-id="${response.data[0].kode_kegiatan}" style="width: 42px">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            `;

            $(`#index_${response.data[0].kode_kegiatan}`).replaceWith(
                satuankerja
            );
            $("#modal-edit-objekkegiatan").modal("hide");
        },
        error: function (error) {
            console.log(error.responseJSON);
        },
    });
});

// Delete Data
$(".delete-btn").on("click", function () {
    let dataId = $(this).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Data tidak dapat dipulihkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#394eea",
        cancelButtonColor: "#fc544b",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/objek-kegiatan/${dataId}`,
                type: "DELETE",
                cache: false,
                data: {
                    _token: token,
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
                    $(`#index_${dataId}`).remove();
                },
                error: function (e) {
                    console.log(e);
                },
            });
        }
    });
});
