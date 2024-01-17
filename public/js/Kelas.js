/* Menampilkan Data */
var kelastable = $("#datakelas").DataTable({
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
        url: "/datakelas/data",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    },
    columns: [
        { data: null, orderable: false, searchable: false,
            render: function (data, type, full, meta) {
                // Menambahkan nomor urut
                return meta.row + 1;
            }
        },
        { data: "kelas", name: "kelas" },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<button value="' +
                    data +
                    '" class="btn btn-xs btn-primary edit_datakelas"><i class="fa fa-edit"></i></button>'
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
                    '" class="btn btn-xs btn-danger delete_datakelas"><i class="fa fa-trash"></i></button>'
                );
            },
            orderable: false,
            searchable: false,
        },
    ],
    createdRow: function (row, data, dataIndex) {
        // Menambahkan kelas untuk memastikan nomor urut sesuai dengan urutan DataTable
        $(row).find('td:eq(0)').addClass('text-center');
    }
});
/* Menampilkan Data */

/* Tambah Data */
$(function () {
    $("#datakelas_form").on("submit", function (e) {
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
                    kelastable.ajax.reload();
                    $("#datakelas_form")[0].reset();
                    $(".text-danger").text("");
                }
            },
        });
    });
});

/* Edit Data */
$(document).on("click", ".edit_datakelas", function (e) {
    e.preventDefault();
    var kelas_id = $(this).val();
    $("#editkelasmodal").modal("show");
    $.ajax({
        type: "GET",
        url: "/datakelas/edit/" + kelas_id,
        success: function (response) {
            console.log(response);
            if (response.status == 404) {
                $("#success_message").html("");
                $("#success_message").addClass("alert alert-danger");
                $("#success_message").text(response.message);
            } else {
                // $("#edit_id").val(kelas_id);
                $("#hidden_id").val(kelas_id);
                $("#editnama_kelas").val(response.modelkelas.kelas);
            }
        },
    });
});
/* Edit Data */

/* Update Data */
$(document).on("submit", "#datakelasedit_form", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var kelas_id = $("#hidden_id").val();
    let EditformData = new FormData($("#datakelasedit_form")[0]);

    $.ajax({
        type: "POST",
        url: "/datakelas/update/" + kelas_id,
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
                kelastable.ajax.reload();
                $("#editkelasmodal").modal("hide");
                $("#datakelasedit_form")[0].reset();
            }
        },
    });
});
/* Update Data */

/* Hapus Data */
$(document).on("click", ".delete_datakelas", function (e) {
    e.preventDefault();
    var kelas_id = $(this).val();
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
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                $.ajax({
                    type: "DELETE",
                    url: "/datakelas/delete/" + kelas_id,
                    success: function (response) {
                        console.log(response);
                        kelastable.ajax.reload();
                    },
                });

                swalWithBootstrapButtons.fire(
                    "Berhasil!",
                    "Data Telah Di Hapus",
                    "success"
                );
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    "Batal",
                    "Data Anda Aman :D",
                    "error"
                );
            }
        });
});
/* Hapus Data */
// $(function () {
//     $("#datasiswa_form").on("submit", function (e) {
//         e.preventDefault();
//         $.ajaxSetup({
//             headers: {
//                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//             },
//         });
//         let formData = new FormData($("#datasiswa_form")[0]);
//         $.ajax({
//             type: "POST",
//             url: "/datasiswa/tambah",
//             data: formData,
//             processData: false,
//             dataType: "json",
//             contentType: false,
//             beforeSend: function () {
//                 $(document).find("span.error-text").text("");
//             },
//             success: function (response) {
//                 console.log(response);
//                 if (response.status == 400) {
//                     $("#saveform_errList").html("");
//                     $("#saveform_errList").addClass("alert alert-danger");
//                     $.each(response.errors, function (prefix, val) {
//                         $("span." + prefix + "_error").text(val[0]);
//                     });
//                 } else {
//                     Toast.fire({
//                         icon: "success",
//                         title: "Berhasil Di Tambah!",
//                     });
//                     siswatable.ajax.reload();
//                     $("#datasiswa_form")[0].reset();
//                     $(".text-danger").text("");
//                 }
//             },
//         });
//     });
// });
/* Tambah Data */
