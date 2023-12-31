/* Menampilkan Data */
var quiztable = $("#dataquiztentor").DataTable({
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
        url: "/dataquiztentor/data",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    },
    columns: [
        { data: "judul_quiz", name: "judul_quiz" },
        { data: "nama_kategori", name: "nama_kategori" },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<button value="' +
                    data +
                    '" class="btn btn-xs btn-primary edit_dataquiztentor"><i class="fa fa-edit"></i></button>'
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
                    '" class="btn btn-xs btn-danger delete_dataquiztentor"><i class="fa fa-trash"></i></button>'
                );
            },
            orderable: false,
            searchable: false,
        },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<a href="/dataquiztentor/pertanyaan/' +
                    data +
                    '" class="btn btn-xs btn-danger view_dataquiztentor"><i class="fa fa-eye"></i></a>'
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
    $("#dataquiztentor_form").on("submit", function (e) {
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
                    quiztable.ajax.reload();
                    $("#dataquiztentor_form")[0].reset();
                    resetselect2();
                    $("#gambar_quiz").val("");
                    $("#audio_quiz").val("");

                    // Reset the image preview
                    $("#image_preview").attr("src", "");
                    $("#image_preview").css("display", "none");

                    $("#audio_preview").attr("src", "");
                    $("#audio_preview").css("display", "none");

                    // Reset the custom file label
                    $("#fileLabel").html("Choose file");
                    $(".text-danger").text("");
                }
            },
        });
    });
});

/* Edit Data */
$(document).on("click", ".edit_dataquiztentor", function (e) {
    e.preventDefault();
    var quiz_id = $(this).val();
    $("#editquizmodal").modal("show");
    $.ajax({
        type: "GET",
        url: "/dataquiztentor/edit/" + quiz_id,
        success: function (response) {
            console.log(response);
            if (response.status == 404) {
                $("#success_message").html("");
                $("#success_message").addClass("alert alert-danger");
                $("#success_message").text(response.message);
            } else {
                // $("#edit_id").val(quiz_id);
                $("#hidden_id").val(quiz_id);
                $("#editjudul_quiz").val(response.modelquiz.judul_quiz);
                $("#editkategori")
                    .val(response.modelquiz.kategori_id)
                    .trigger("change");
                var user_ids = JSON.parse(response.modelquiz.user_id);
                var selectedValues = [];

                $.each(user_ids, function (index, user_id) {
                    selectedValues.push(user_id);
                });
                $("#edittentor").val(selectedValues);
                $("#edittentor").trigger("change");

                if (response.modelquiz.audio_quiz != null) {
                    $("#editaudio_preview").html(
                        '<audio controls id="editaudio_player"></audio>'
                    );
                    $("#editaudio_player").attr(
                        "src",
                        "audios_quiz/" + response.modelquiz.audio_quiz
                    );
                }
                if (response.modelquiz.audio_quiz == null) {
                    $("#editaudio_preview").html("");
                }
                if (response.modelquiz.gambar_quiz != null) {
                    $("#editimage_preview").attr(
                        "src",
                        "images_quiz/" + response.modelquiz.gambar_quiz
                    );
                    $("#editimage_preview").css("display", "block");
                    $("#editgambar_quiz").val(response.modelquiz.gambar_quiz);
                } else {
                    $("#editimage_preview").attr("src", "");
                    $("#editimage_preview").css("display", "block");
                }
            }
        },
    });
});
/* Edit Data */

/* Update Data */
$(document).on("submit", "#dataquiztentoredit_form", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var quiz_id = $("#hidden_id").val();
    let EditformData = new FormData($("#dataquiztentoredit_form")[0]);

    $.ajax({
        type: "POST",
        url: "/dataquiztentor/update/" + quiz_id,
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
                quiztable.ajax.reload();
                $("#editgambar_quiz").val("");

                // Reset the image preview
                $("#editimage_preview").attr("src", "");
                $("#editimage_preview").css("display", "none");

                // Reset the custom file label
                $("#fileLabeledit").html("Choose file");
                $("#editquizmodal").modal("hide");
                $("#dataquiztentoredit_form")[0].reset();
            }
        },
    });
});
/* Update Data */

/* Hapus Data */
$(document).on("click", ".delete_dataquiztentor", function (e) {
    e.preventDefault();
    var quiz_id = $(this).val();
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
                    url: "/dataquiztentor/delete/" + quiz_id,
                    success: function (response) {
                        console.log(response);
                        quiztable.ajax.reload();
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

/* Fungsi */
function resetselect2() {
    $(".kategori").select2("destroy");
    $(".kategori").select2({
        theme: "bootstrap4",
    });
}
/* Fungsi */
