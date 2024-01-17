/* Menampilkan Data */
var currentURL = window.location.href;
var urlParts = currentURL.split("/");
var pageID = urlParts[urlParts.length - 1];
var pertanyaantable = $("#datapertanyaan").DataTable({
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
        url: "/datapertanyaan/data/" + pageID,
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
        {
            data: "pertanyaan",
            name: "pertanyaan",
            render: function (data, type, row) {
                return data.substring(0, 100);
            },
        },
        { data: "tipe_pertanyaan", name: "tipe_pertanyaan" },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<button value="' +
                    data +
                    '" class="btn btn-xs btn-primary edit_datapertanyaan"><i class="fa fa-edit"></i></button>'
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
                    '" class="btn btn-xs btn-danger delete_datapertanyaan"><i class="fa fa-trash"></i></button>'
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
    $("#datapertanyaan_form").on("submit", function (e) {
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
                    pertanyaantable.ajax.reload();
                    if ($("#tipe_pertanyaan").val() == "Pilihan") {
                        $("#datapertanyaan_form")[0].reset();
                    }
                    $("#datapertanyaan_form").find("textarea").val("");
                    $('#summernote').summernote('code', '');
                    if($("#tipe_pertanyaan").val() == "Pilihan"){
                        $("#submitBtn").attr("disabled", "disabled");
                    }
                    if($("#tipe_pertanyaan").val() == "Teks"){
                        $("#submitBtn").prop("disabled", false);
                    }
                    $(".text-danger").text("");
                }
            },
        });
    });
});

/* Edit Data */
$(document).on("click", ".edit_datapertanyaan", function (e) {
    e.preventDefault();
    var pertanyaan_id = $(this).val();
    $("#editpertanyaanmodal").modal("show");
    $.ajax({
        type: "GET",
        url: "/datapertanyaan/edit/" + pertanyaan_id,
        success: function (response) {
            console.log(response);
            if (response.status == 404) {
                $("#success_message").html("");
                $("#success_message").addClass("alert alert-danger");
                $("#success_message").text(response.message);
            } else {
                // $("#edit_id").val(pertanyaan_id);
                $("#hidden_id").val(pertanyaan_id);
                $("#summernote2").summernote(
                    "code",
                    response.modelpertanyaan.pertanyaan
                    );
                $("#edittipe_pertanyaan").val(response.modelpertanyaan.tipe_pertanyaan).trigger("change");
                $("#tipe").val(response.modelpertanyaan.tipe_pertanyaan);
                if (response.modelpertanyaan.tipe_pertanyaan == "Pilihan") {
                    $("#container-input-d").html("");
                $.each(response.modeljawaban, function (key, item) {
                    $("#container-input-d").append(
                        '<div class="form-group">' +
                            '<div class="input-group">' +
                            '<input type="text" class="form-control col-md-1" id="editbobot' +
                            (key + 1) +
                            '" name="editbobot[]" placeholder="Bobot" value="' +
                            item.point +
                            '" oninput="validasiInputedit(' +
                            (key + 1) +
                            ')">' +
                            '<input type="text" class="form-control col-md-5" id="editjawaban' +
                            (key + 1) +
                            '" name="editjawaban[]" value="' +
                            item.jawaban +
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
                }else if (response.modelpertanyaan.tipe_pertanyaan == "Teks") {
                    if (response.modeljawaban[0].jawaban == null) {
                        $("#edittextbobot").val(response.modeljawaban[0].point);
                        $("#edittextjawaban").val();
                        $("#textid").val(response.modeljawaban[0].id);
                    }else{
                        $("#edittextbobot").val(response.modeljawaban[0].point);
                        $("#edittextjawaban").val(response.modeljawaban[0].jawaban);
                        $("#textid").val(response.modeljawaban[0].id);

                    }
                }
                
            }
        },
    });
});
// /* Edit Data */

// /* Update Data */
$(document).on("submit", "#datapertanyaanedit_form", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var pertanyaan_id = $("#hidden_id").val();
    let EditformData = new FormData($("#datapertanyaanedit_form")[0]);

    $.ajax({
        type: "POST",
        url: "/datapertanyaan/update/" + pertanyaan_id,
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
                pertanyaantable.ajax.reload();
                $("#editpertanyaanmodal").modal("hide");
                $("#datapertanyaanedit_form")[0].reset();
            }
        },
    });
});
// /* Update Data */

// /* Hapus Data Pertanyaan*/
$(document).on("click", ".delete_datapertanyaan", function (e) {
    e.preventDefault();
    var pertanyaan_id = $(this).val();
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
                    url: "/datapertanyaan/delete/" + pertanyaan_id,
                    success: function (response) {
                        console.log(response);
                        pertanyaantable.ajax.reload();
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
/* Hapus Data Pertanyaan */

/* Hapus Data Jawaban */
function hapusInputedit(button) {
    var jawabanID = button.value;
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
                    url: "/datajawaban/delete/" + jawabanID,
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
/* Hapus Data Jawaban */
$(document).ready(function() {
    
});
