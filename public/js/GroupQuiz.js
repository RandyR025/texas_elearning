/* Menampilkan Data */
var groupquiztable = $("#datagroupquiz").DataTable({
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
        url: "/datagroupquiz/data",
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
        { data: "nama_group", name: "nama_group" },
        { data: "deskripsi", name: "deskripsi" },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<button value="' +
                    data +
                    '" class="btn btn-xs btn-primary edit_datagroupquiz"><i class="fa fa-edit"></i></button>'
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
                    '" class="btn btn-xs btn-danger delete_datagroupquiz"><i class="fa fa-trash"></i></button>'
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
    $("#datagroupquiz_form").on("submit", function (e) {
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
                    groupquiztable.ajax.reload();
                    $("#datagroupquiz_form")[0].reset();
                    $(".text-danger").text("");
                }
            },
        });
    });
});

/* Edit Data */
$(document).on("click", ".edit_datagroupquiz", function (e) {
    e.preventDefault();
    var groupquiz_id = $(this).val();
    $("#editgroupquizmodal").modal("show");
    $.ajax({
        type: "GET",
        url: "/datagroupquiz/edit/" + groupquiz_id,
        success: function (response) {
            console.log(response);
            if (response.status == 404) {
                $("#success_message").html("");
                $("#success_message").addClass("alert alert-danger");
                $("#success_message").text(response.message);
            } else {
                // $("#edit_id").val(groupquiz_id);
                $("#hidden_id").val(groupquiz_id);
                $("#editnama_group").val(response.modelgroupquiz.nama_group);
                $("#editdeskripsi").val(response.modelgroupquiz.deskripsi);
            }
        },
    });
});
/* Edit Data */

/* Update Data */
$(document).on("submit", "#datagroupquizedit_form", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var groupquiz_id = $("#hidden_id").val();
    let EditformData = new FormData($("#datagroupquizedit_form")[0]);

    $.ajax({
        type: "POST",
        url: "/datagroupquiz/update/" + groupquiz_id,
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
                groupquiztable.ajax.reload();
                $("#editgroupquizmodal").modal("hide");
                $("#datagroupquizedit_form")[0].reset();
            }
        },
    });
});
/* Update Data */

/* Hapus Data */
$(document).on("click", ".delete_datagroupquiz", function (e) {
    e.preventDefault();
    var groupquiz_id = $(this).val();
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
                    url: "/datagroupquiz/delete/" + groupquiz_id,
                    success: function (response) {
                        console.log(response);
                        groupquiztable.ajax.reload();
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

$(document).on("click", ".edit_dataskorquiz", function (e) {
    e.preventDefault();
    var skor_id = $(this).val();
    $("#editpertanyaanmodal").modal("show");
    $.ajax({
        type: "GET",
        url: "/dataskorquiz/edit/" + skor_id,
        success: function (response) {
            console.log(response);
            if (response.status == 404) {
                $("#success_message").html("");
                $("#success_message").addClass("alert alert-danger");
                $("#success_message").text(response.message);
            } else {
                // $("#edit_id").val(skor_id);
                $("#hidden_id").val(skor_id);
                $("#container-input-d").html("");
                $.each(response.modeljawaban, function (key, item) {
                    $("#container-input-d").append(
                        '<div class="form-group">' +
                            '<div class="input-group">' +
                            '<input type="text" class="form-control col-md-4" id="editjumlahjawaban' +
                            (key + 1) +
                            '" name="editjumlahjawaban[]" placeholder="Bobot" value="' +
                            item.jumlah_benar +
                            '" oninput="validasiInputedit(' +
                            (key + 1) +
                            ')">' +
                            '<input type="text" class="form-control col-md-8" id="editskor' +
                            (key + 1) +
                            '" name="editskor[]" value="' +
                            item.skor +
                            '" oninput="validasiInputedit(' +
                            (key + 1) +
                            ')">' +
                            '<span class="input-group-btn">' +
                            '<button type="button" class="btn btn-danger" value="' +
                            item.id +
                            '" onclick="hapusInputedit(this)"><i class="fa fa-trash"></i></button>' +
                            "</span>" +
                            '<input type="hidden" class="form-control col-md-5" id="id" name="id[]" value="' +
                            item.id +
                            '"' +
                            "</div>" +
                            "</div>"
                    );
                });             
            }
        },
    });
});
function hapusInputedit(button) {
    var skorID = button.value;
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
                    url: "/dataskor/delete/" + skorID,
                    success: function (response) {
                        console.log(response);
                    },
                });

                swalWithBootstrapButtons.fire(
                    "Berhasil!",
                    "Data Telah Di Hapus",
                    "success"
                );
                $(button).closest(".form-group").remove();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    "Batal",
                    "Data Anda Aman :D",
                    "error"
                );
            }
        });
}
$(document).on("submit", "#dataskoredit_form", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var skor_id = $("#hidden_id").val();
    let EditformData = new FormData($("#dataskoredit_form")[0]);

    $.ajax({
        type: "POST",
        url: "/dataskor/update/" + skor_id,
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
                $("#editpertanyaanmodal").modal("hide");
                $("#dataskoredit_form")[0].reset();
            }
        },
    });
});