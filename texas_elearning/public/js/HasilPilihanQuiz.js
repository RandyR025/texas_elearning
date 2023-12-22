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
