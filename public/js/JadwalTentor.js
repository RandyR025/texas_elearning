/* Menampilkan Data */
var jadwaltable = $("#datajadwalquiztentor").DataTable({
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
        url: "/datajadwalquiztentor/data",
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
        { data: "judul_quiz", name: "judul_quiz" },
        { data: "kelas", name: "kelas" },
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
                    '" class="btn btn-xs btn-primary edit_datajadwalquiztentor"><i class="fa fa-edit"></i></button>'
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
                    '" class="btn btn-xs btn-danger delete_datajadwalquiztentor"><i class="fa fa-trash"></i></button>'
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
    $("#datajadwalquiztentor_form").on("submit", function (e) {
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
                    $("#datajadwalquiztentor_form")[0].reset();
                    resetselect2();
                    $(".text-danger").text("");
                }
            },
        });
    });
});

/* Edit Data */
$(document).on("click", ".edit_datajadwalquiztentor", function (e) {
    e.preventDefault();
    var jadwalquiz_id = $(this).val();
    $("#editjadwalquizmodal").modal("show");
    $.ajax({
        type: "GET",
        url: "/datajadwalquiztentor/edit/" + jadwalquiz_id,
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
                $("#edittampilan_soal").val(
                    response.modeljadwalquiz.tampilan_soal
                );
                $("#editnama_quiz")
                    .val(response.modeljadwalquiz.quiz_id)
                    .trigger("change");
                $("#editkelas")
                    .val(response.modeljadwalquiz.kelas_id)
                    .trigger("change");
                $("#editquiz_sebelumnya")
                    .val(response.modeljadwalquiz.prev_quiz)
                    .trigger("change");
                

                $('#editquiz_sebelumnya').select2({
                    theme: 'bootstrap4',
                    ajax: {
                        url: '/getquiztentor',
                        dataType: 'json',
                        processResults: function(modelprevquiz){
                            return {
                                results: $.map(modelprevquiz, function(item){
                                    return { id: item.id, text: item.judul_quiz };
                                })
                            };
                        }
                    },
                    initSelection: function (element, callback) {
                        if (!response.modeljadwalquiz.prev_quiz) {
                            // If not available, set the default option as selected
                            callback({ id: '', text: 'Pilih Quiz' });
                        } else {
                            // If available, set the selected option based on the response
                            callback({ id: response.modeljadwalprevious.id, text: response.modeljadwalprevious.judul_quiz });
                        }
                    }
                });
            }
        },
    });
});
/* Edit Data */

/* Update Data */
$(document).on("submit", "#datajadwalquiztentoredit_form", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var jadwalquiz_id = $("#hidden_id").val();
    let EditformData = new FormData($("#datajadwalquiztentoredit_form")[0]);

    $.ajax({
        type: "POST",
        url: "/datajadwalquiztentor/update/" + jadwalquiz_id,
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
                $("#datajadwalquiztentoredit_form")[0].reset();
            }
        },
    });
});
/* Update Data */

/* Hapus Data */
$(document).on("click", ".delete_datajadwalquiztentor", function (e) {
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
                    url: "/datajadwalquiztentor/delete/" + jadwalquiz_id,
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

function resetselect2() {
    $(".nama_quiz").select2("destroy");
    $(".nama_quiz").select2({
        theme: "bootstrap4",
    });
    $(".kelas").select2("destroy");
    $(".kelas").select2({
        theme: "bootstrap4",
    });
    $(".quiz_sebelumnya").select2("destroy");
    $(".quiz_sebelumnya").select2({
        theme: "bootstrap4",
    });
    initQuizSebelumnyaSelect2();
}
function initQuizSebelumnyaSelect2() {
    $('#quiz_sebelumnya').select2({
        theme: 'bootstrap4',
        ajax: {
            url: '/getquiztentor',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // Parameter pencarian yang dikirim ke server
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return { id: item.id, text: item.judul_quiz };
                    })
                };
            },
            cache: true
        },
    });
}
$(document).ready(function () {
    initQuizSebelumnyaSelect2();
});
