/* Menampilkan Data */
var jadwaltable = $("#datahasilquizsiswa").DataTable({
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
        url: "/datahasilquizsiswa/data",
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
        { data: null, 
            render: function (data, type, full, meta) {
                // Jika ada group_id, tampilkan nama_group, jika tidak, tampilkan judul_quiz
                return full.group_id ? full.nama_group : full.judul_quiz;
            } },
        { data: "tanggal_mulai", name: "tanggal_mulai" },
        { data: "tanggal_berakhir", name: "tanggal_berakhir" },
        { data: "total_keseluruhan", name: "total_keseluruhan" },
        {
            data: "id",
            render: function (data, type, full, meta) {
                var group_id = full.group_id;
                var tanggal_mulai = full.tanggal_mulai;
                if (group_id){
                return (
                    '<div><a href="/datahasilquizsiswa/detail/' +
                    group_id + "/" + tanggal_mulai +
                    '" class="btn btn-xs btn-danger view_dataquiz"><i class="fa fa-eye"></i></a></div>'+
                    '<div><a href="/cetaktoefl/' +
                    group_id + "/" + tanggal_mulai +
                    '" class="btn btn-xs btn-primary cetak_toefl"><i class="fa fa-file-pdf"></i></a></div>'
                );
                }else {
                    return (
                        '<a href="/datahasilquizsiswa/detail/' +
                        data +
                        '" class="btn btn-xs btn-danger view_dataquiz disabled"><i class="fa fa-eye"></i></a>'
                    );
                }
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
var pageID = urlParts[urlParts.length - 2];
var pageID2 = urlParts[urlParts.length - 1];

var detailhasiltable = $("#detaildatahasilquizsiswa").DataTable({
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
        url: "/detaildatahasilquizsiswa/data/" + pageID + "/" + pageID2,
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
        { data: "tanggal_mulai", name: "tanggal_mulai" },
        { data: "tanggal_berakhir", name: "tanggal_berakhir" },
        { data: "skor", name: "skor" },
    ],
    createdRow: function (row, data, dataIndex) {
        // Menambahkan kelas untuk memastikan nomor urut sesuai dengan urutan DataTable
        $(row).find('td:eq(0)').addClass('text-center');
    }
});
