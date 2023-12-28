/* Menampilkan Data */
var jadwaltable = $("#datajadwalquiz").DataTable({
    processing: true,
    serverSide: true,
    paging: true,
    lengthChange: false,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    ajax: {
        url: "/datajadwalquiz/data",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    },
    columns: [
        { data: "judul_quiz", name: "judul_quiz" },
        { data: "tanggal_mulai", name: "tanggal_mulai" },
        { data: "tanggal_berakhir", name: "tanggal_berakhir" },
        {
            data: "waktu_quiz",
            name: "waktu_quiz",
            render: function (data, type, full, meta) {
                return data + " Menit";
            },
        },
        {
            data: "tampilan_soal",
            name: "tampilan_soal",
            render: function (data, type, full, meta) {
                return data + " Soal";
            },
        },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<button value="' +
                    data +
                    '" class="btn btn-xs btn-primary edit_datajadwalquiz"><i class="fa fa-edit"></i></button>'
                );
            },
            orderable: false,
            searchable: false,
        },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<button value="' +
                    data +
                    '" class="btn btn-xs btn-danger delete_datajadwalquiz"><i class="fa fa-trash"></i></button>'
                );
            },
            orderable: false,
            searchable: false,
        },
    ],
});
/* Menampilkan Data */

/* Tambah Data */
$(function () {
    $("#datajadwalquiz_form").on("submit", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: new FormData(this),
            processData: false,
            dataType: "json",
            contentType: false,
            beforeSend: function () {
                $(document).find("span.error-text").text("");
            },
            success: function (response) {
                console.log(response);
                if (response.status == 400) {
                    $("#saveform_errList").html("");
                    $("#saveform_errList").addClass("alert alert-danger");
                    $.each(response.errors, function (prefix, val) {
                        $("span." + prefix + "_error").text(val[0]);
                    });
                } else {
                    Toast.fire({
                        icon: "success",
                        title: "Berhasil Di Tambah!",
                    });
                    jadwaltable.ajax.reload();
                    $("#datajadwalquiz_form")[0].reset();
                    $(".text-danger").text("");
                }
            },
        });
    });
});

/* Edit Data */
$(document).on("click", ".edit_datajadwalquiz", function (e) {
    e.preventDefault();
    var jadwalquiz_id = $(this).val();
    $("#editjadwalquizmodal").modal("show");
    $.ajax({
        type: "GET",
        url: "/datajadwalquiz/edit/" + jadwalquiz_id,
        success: function (response) {
            console.log(response);
            if (response.status == 404) {
                $("#success_message").html("");
                $("#success_message").addClass("alert alert-danger");
                $("#success_message").text(response.message);
            } else {
                // $("#edit_id").val(jadwalquiz_id);
                $("#hidden_id").val(jadwalquiz_id);
                $("#edittanggal_mulai1").val(
                    response.modeljadwalquiz.tanggal_mulai
                );
                $("#edittanggal_berakhir1").val(
                    response.modeljadwalquiz.tanggal_berakhir
                );
                $("#editwaktu_quiz").val(response.modeljadwalquiz.waktu_quiz);
                $("#edittampilan_soal").val(response.modeljadwalquiz.tampilan_soal);
                $("#editnama_quiz")
                    .val(response.modeljadwalquiz.quiz_id)
                    .trigger("change");
            }
        },
    });
});
/* Edit Data */

/* Update Data */
$(document).on("submit", "#datajadwalquizedit_form", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var jadwalquiz_id = $("#hidden_id").val();
    let EditformData = new FormData($("#datajadwalquizedit_form")[0]);

    $.ajax({
        type: "POST",
        url: "/datajadwalquiz/update/" + jadwalquiz_id,
        data: EditformData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(document).find("span.error-text").text("");
        },
        success: function (response) {
            console.log(response);
            if (response.status == 400) {
                $("#saveform_errList").html("");
                $("#saveform_errList").addClass("alert alert-danger");
                $.each(response.errors, function (prefix, val) {
                    $("span." + prefix + "_error").text(val[0]);
                });
            } else {
                $("#saveform_errList").html("");
                Toast.fire({
                    icon: "success",
                    title: "Berhasil Di Update!",
                });
                jadwaltable.ajax.reload();
                $("#editjadwalquizmodal").modal("hide");
                $("#datajadwalquizedit_form")[0].reset();
            }
        },
    });
});
/* Update Data */

/* Hapus Data */
$(document).on("click", ".delete_datajadwalquiz", function (e) {
    e.preventDefault();
    var jadwalquiz_id = $(this).val();
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: true,
    });
    swalWithBootstrapButtons
        .fire({
            title: "Yakin Hapus Data?",
            text: "Anda Tidak Akan Dapat Mengembalikan Data Ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal!",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                });
                $.ajax({
                    type: "DELETE",
                    url: "/datajadwalquiz/delete/" + jadwalquiz_id,
                    success: function (response) {
                        console.log(response);
                        jadwaltable.ajax.reload();
                    },
                });

                swalWithBootstrapButtons.fire(
                    "Berhasil!",
                    "Data Telah Di Hapus",
                    "success"
                );
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    "Batal",
                    "Data Anda Aman :D",
                    "error"
                );
            }
        });
});
/* Hapus Data */
