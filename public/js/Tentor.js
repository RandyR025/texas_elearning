/* Menampilkan Data */
var tentortable = $("#datatentor").DataTable({
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
        url: "/datatentor/data",
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
        { data: "tanggal_lahir", name: "tanggal_lahir" },
        { data: "alamat", name: "alamat" },
        { data: "no_telp", name: "no_telp" },
        { data: "kursus", name: "kursus" },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<button value="' +
                    data +
                    '" class="btn btn-xs btn-primary edit_datatentor"><i class="fa fa-edit"></i></button>'
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


/* Edit Data */
$(document).on("click", ".edit_datatentor", function (e) {
    e.preventDefault();
    var siswa_id = $(this).val();
    $("#edittentormodal").modal("show");
    $.ajax({
        type: "GET",
        url: "/datatentor/edit/" + siswa_id,
        success: function (response) {
            console.log(response);
            if (response.status == 404) {
                $("#success_message").html("");
                $("#success_message").addClass("alert alert-danger");
                $("#success_message").text(response.message);
            } else {
                // $("#edit_id").val(siswa_id);
                $("#hidden_id").val(siswa_id);
                $("#editnama").val(response.modeltentor.nama);
                $("#edittanggal_lahir1").val(response.modeltentor.tanggal_lahir);
                $("#editalamat").val(response.modeltentor.alamat);
                $("#editno_telp").val(response.modeltentor.no_telp);
                $("#editkelas")
                    .val(response.modeltentor.kelas_id)
                    .trigger("change");
                $("#editkursus")
                    .val(response.modeltentor.kursus_id)
                    .trigger("change");
                $("#editusername")
                    .val(response.modeltentor.user_id)
                    .trigger("change");
            }
        },
    });
});
/* Edit Data */

/* Update Data */
$(document).on("submit", "#datatentoredit_form", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var siswa_id = $("#hidden_id").val();
    let EditformData = new FormData($("#datatentoredit_form")[0]);

    $.ajax({
        type: "POST",
        url: "/datatentor/update/" + siswa_id,
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
                tentortable.ajax.reload();
                $("#edittentormodal").modal("hide");
                $("#datatentoredit_form")[0].reset();
            }
        },
    });
});
/* Update Data */