/* Menampilkan Data */
var jadwaltable = $("#datahasilquiz").DataTable({
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
        url: "/datahasilquiz/data",
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
            data: "jumlah_siswa",
            name: "jumlah_siswa",
            render: function (data, type, full, meta) {
                return data + " Siswa";
            },
        },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<a href="/datahasilquiz/detail/' +
                    data +
                    '" class="btn btn-xs btn-danger view_dataquiz"><i class="fa fa-eye"></i></a>'
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

var currentURL = window.location.href;
var urlParts = currentURL.split("/");
var pageID = urlParts[urlParts.length - 1];

var detailhasiltable = $("#detaildatahasilquiz").DataTable({
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
        url: "/detaildatahasilquiz/data/" + pageID,
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
        { data: "nama", name: "nama" },
        { data: "skor", name: "skor" },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<button value="' +
                    data +
                    '" class="btn btn-xs btn-primary edit_hasildataquiz"><i class="fa fa-edit"></i></button>'
                );
            },
            orderable: false,
            searchable: false,
        },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<a href="/detaildatahasilquiz/detail/' +
                    data +
                    '" class="btn btn-xs btn-danger view_hasildataquiz"><i class="fa fa-eye"></i></a>'
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
                    '" class="btn btn-xs btn-danger delete_datahasilquiz"><i class="fa fa-trash"></i></button>'
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

$(document).on("click", ".edit_hasildataquiz", function (e) {
    e.preventDefault();
    var hasilquiz_id = $(this).val();
    $("#editnilaimodal").modal("show");
    $.ajax({
        type: "GET",
        url: "/datahasilquiz/edit/" + hasilquiz_id,
        success: function (response) {
            console.log(response);
            if (response.status == 404) {
                $("#success_message").html("");
                $("#success_message").addClass("alert alert-danger");
                $("#success_message").text(response.message);
            } else {
                $("#hidden_id").val(hasilquiz_id);
                $("#editnilai").val(response.modeldetailhasil.totals);
            }
        },
    });
});

$(document).on("submit", "#datanilaiedit_form", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var hasilquiz_id = $("#hidden_id").val();
    let EditformData = new FormData($("#datanilaiedit_form")[0]);

    $.ajax({
        type: "POST",
        url: "/datahasilquiz/update/" + hasilquiz_id,
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
                detailhasiltable.ajax.reload();
                $("#editnilaimodal").modal("hide");
                $("#datanilaiedit_form")[0].reset();
            }
        },
    });
});

$(document).on("click", ".delete_datahasilquiz", function (e) {
    e.preventDefault();
    var hasilquiz_id = $(this).val();
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
                    url: "/datahasilquiz/delete/" + hasilquiz_id,
                    success: function (response) {
                        console.log(response);
                        detailhasiltable.ajax.reload();
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
