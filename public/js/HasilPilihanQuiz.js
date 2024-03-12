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
            var questionBox = $(".question-box[data-pertanyaan-id='" + pengisianID + "']");
            
            // Hapus kelas bg-light dan tambahkan kelas bg-success
            questionBox.removeClass("bg-light").addClass("bg-success");
        },
    });
}

function waktuHabis() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var whiteContainer = document.querySelector(".white-container");
    var quizID = whiteContainer.getAttribute("data-quiz-id");
    var jadwalID = whiteContainer.getAttribute("data-jadwal");
    var s = {
        jadwal: jadwalID,
        id: quizID,
    };
    $.ajax({
        url: "/totalnilai",
        type: "POST",
        data: s,
        success: function (data) {
            console.log(data);
            window.location.href = "/quizsiswa";
        },
    });
}

// function textSavedata(data, jawaban_id, pertanyaan_id, jadwal_id) {
//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },
//     });
//     var Data = data.value;
//     var jawabanID = jawaban_id;
//     var pertanyaanID = pertanyaan_id;
//     var jadwalID = jadwal_id;
//     var s = {
//         jawaban_id: jawabanID,
//         pertanyaan_id: pertanyaanID,
//         jadwal_id: jadwalID,
//         data: Data,
//     };
//     $.ajax({
//         url: "/hasiltextquiz",
//         type: "POST",
//         data: s,
//         success: function (data) {
//             // console.log(data);
//         },
//     });
// }

function textSavedata(data, jawaban_id, pertanyaan_id, jadwal_id) {
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
        url: "/hasilblankquiz",
        type: "POST",
        data: s,
        success: function (data) {
            // console.log(data);
        },
    });
}

function saveToDatabase() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var whiteContainer = document.querySelector(".white-container");
    var quizId = whiteContainer.getAttribute("data-quiz-id");
    var jadwal = whiteContainer.getAttribute("data-jadwal");
    var textareas = document.querySelectorAll("textarea[data-jawaban-id]");
    textareas.forEach(function (textarea) {
        var jawabanId = textarea.getAttribute("data-jawaban-id");
        var pertanyaanId = textarea.getAttribute("data-pertanyaan-id");
        var content = textarea.value;

        // Kirim konten ke server untuk disimpan di database
        var s = {
            jawaban_id: jawabanId,
            data: content,
            pertanyaan_id: pertanyaanId,
            jadwal_id: jadwal,
        };
        $.ajax({
            type: "POST",
            url: "/hasiltextquiz",
            data: s,
            success: function (data) {
                console.log(data);
            },
        });
    });
}

function finishAndClearCookies() {
    saveToDatabase();
    waktuHabis();
    clearCookies();
}

function clearCookies() {
    localStorage.clear();
}
