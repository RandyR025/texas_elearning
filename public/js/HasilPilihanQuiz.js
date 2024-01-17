function handleClick(myRadio, myPertanyaan, myTanggal) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var optionID = myRadio.value;
    var pengisianID = myPertanyaan;
    var tanggalID = myTanggal;
    var s = {
        option_id: optionID,
        pengisian_id: pengisianID,
        tanggal_id: tanggalID,
    };
    $.ajax({
        url: "/hasilpilihanquiz",
        type: "POST",
        data: s,
        success: function (data) {
            console.log(data);
        },
    });
}

function waktuHabis(Quiz, Jadwal) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var quizID = Quiz;
    var jadwalID = Jadwal;
    $.ajax({
        url: "/totalnilai/"+quizID+"/"+jadwalID,
        type: "GET",
        success: function (data) {
            console.log(data);
            window.location.href = "/quizsiswa";
        },
    });
}

function textSavedata(data,jawaban_id, pertanyaan_id, jadwal_id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var Data = data.value;
    var jawabanID = jawaban_id;
    var pertanyaanID = pertanyaan_id;
    var jadwalID = jadwal_id;
    var s = {
        jawaban_id: jawabanID,
        pertanyaan_id: pertanyaanID,
        jadwal_id: jadwalID,
        data: Data,
    };
    $.ajax({
        url: "/hasiltextquiz",
        type: "POST",
        data: s,
        success: function (data) {
            // console.log(data);
        },
    });
}
