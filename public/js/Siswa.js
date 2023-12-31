/* Menampilkan Data */
var siswatable = $("#datasiswa").DataTable({
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
        url: "/datasiswa/data",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    },
    columns: [
        { data: "nama", name: "nama" },
        { data: "tanggal_lahir", name: "tanggal_lahir" },
        { data: "alamat", name: "alamat" },
        { data: "no_telp", name: "no_telp" },
        { data: "kelas", name: "kelas" },
        { data: "kursus", name: "kursus" },
        {
            data: "id",
            render: function (data, type, full, meta) {
                return (
                    '<button value="' +
                    data +
                    '" class="btn btn-xs btn-primary edit_datasiswa"><i class="fa fa-edit"></i></button>'
                );
            },
            orderable: false,
            searchable: false,
        },
    ],
});
/* Menampilkan Data */


/* Edit Data */
$(document).on("click", ".edit_datasiswa", function (e) {
    e.preventDefault();
    var siswa_id = $(this).val();
    $("#editsiswamodal").modal("show");
    $.ajax({
        type: "GET",
        url: "/datasiswa/edit/" + siswa_id,
        success: function (response) {
            console.log(response);
            if (response.status == 404) {
                $("#success_message").html("");
                $("#success_message").addClass("alert alert-danger");
                $("#success_message").text(response.message);
            } else {
                // $("#edit_id").val(siswa_id);
                $("#hidden_id").val(siswa_id);
                $("#editnama").val(response.modelsiswa.nama);
                $("#edittanggal_lahir1").val(response.modelsiswa.tanggal_lahir);
                $("#editalamat").val(response.modelsiswa.alamat);
                $("#editno_telp").val(response.modelsiswa.no_telp);
                $("#editkelas")
                    .val(response.modelsiswa.kelas_id)
                    .trigger("change");
                $("#editkursus")
                    .val(response.modelsiswa.kursus_id)
                    .trigger("change");
                $("#editusername")
                    .val(response.modelsiswa.user_id)
                    .trigger("change");
            }
        },
    });
});
/* Edit Data */

/* Update Data */
$(document).on("submit", "#datasiswaedit_form", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var siswa_id = $("#hidden_id").val();
    let EditformData = new FormData($("#datasiswaedit_form")[0]);

    $.ajax({
        type: "POST",
        url: "/datasiswa/update/" + siswa_id,
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
                siswatable.ajax.reload();
                $("#editsiswamodal").modal("hide");
                $("#datasiswaedit_form")[0].reset();
            }
        },
    });
});
/* Update Data */