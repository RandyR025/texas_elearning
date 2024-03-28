<?php

namespace App\Http\Controllers;

use App\Models\DetailHasil;
use App\Models\Quiz;
use Illuminate\Http\Request;
use DataTables;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;
use Illuminate\Support\Facades\Auth;

class HasilQuizSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/siswa/hasilquiz');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $tanggal_mulai)
    {
        $modelquiz = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai]])->get();
        // dd($modelquiz);
        return view('backend/siswa/detailhasilquiz', compact('modelquiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getData()
    {
        $modelquiz = DetailHasil::select('quiz.id', 'quiz.judul_quiz', 'quiz.gambar_quiz', 'jadwalquiz.tanggal_mulai', 'jadwalquiz.tanggal_berakhir', 'jadwalquiz.id as id_jadwal', 'jadwalquiz.group_id', 'quiz_group.nama_group')
            ->join('jadwalquiz', 'jadwalquiz.id', '=', 'detailhasil.jadwal_id')
            ->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')
            ->leftjoin('quiz_group', 'jadwalquiz.group_id', '=', 'quiz_group.id')
            ->where('jadwalquiz.kelas_id', '=', Auth::user()->userSiswa->kelas_id)
            ->orderBy('jadwalquiz.tanggal_mulai', 'asc')
            ->get();

        // Buat dictionary untuk menyimpan data unik
        $dataUnik = [];

        // Loop melalui setiap item data
        foreach ($modelquiz as $item) {
            $group_id = $item->group_id;
            $tanggal_mulai = $item->tanggal_mulai;

            // Buat kunci gabungan untuk menentukan data unik
            $key = $group_id . '-' . $tanggal_mulai;

            // Jika belum ada data untuk kunci ini, tambahkan
            if (!isset($dataUnik[$key])) {
                $total_keseluruhan = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->where([['jadwalquiz.group_id', '=', $item->group_id], ['jadwalquiz.tanggal_mulai', $item->tanggal_mulai]])
                    ->sum('totals');
                $jumlah_keseluruhan = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->where([['jadwalquiz.group_id', '=', $item->group_id], ['jadwalquiz.tanggal_mulai', $item->tanggal_mulai]])
                    ->count();
                $item->total_keseluruhan = number_format($total_keseluruhan / $jumlah_keseluruhan, 1);
                $dataUnik[$key] = $item;
            }
        }

        // Konversi kembali ke collection agar bisa digunakan oleh DataTables
        $filteredData = collect(array_values($dataUnik));

        return DataTables::of($filteredData)->make(true);
    }

    public function getDataDetail($id, $tanggal_mulai)
    {
        $modelquiz = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai]])->get();

        $processedData = $modelquiz->map(function ($item) {
            return [
                'judul_quiz' => $item->judul_quiz,
                'tanggal_mulai' => $item->tanggal_mulai,
                'tanggal_berakhir' => $item->tanggal_berakhir,
                'skor' => $item->totals,
            ];
        });
        return DataTables::of($processedData)->make(true);
    }

    public function cetakToefl($id, $tanggal_mulai)
    {
        $cek = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai]])->first();
        if (strpos($cek->nama_kategori, "TOEFL") !== false) {
            $listening = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai], ['quiz_kategori.nama_kategori', 'LIKE', '%Listening%']])->first();
            if (isset($listening)) {
                $listeningg = $listening->totals;
            }else {
                $listeningg = "-";
            }
            $swe = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai], ['quiz_kategori.nama_kategori', 'LIKE', '%SWE%']])->first();
            if (isset($swe)) {
                $swee = $swe->totals;
            }else {
                $swee = "-";
            }
            $reading = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai], ['quiz_kategori.nama_kategori', 'LIKE', '%Reading%']])->first();
            if (isset($reading)) {
                $readingg = $reading->totals;
            }else {
                $readingg = "-";
            }
            $total_keseluruhan = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', $tanggal_mulai]])
                        ->sum('totals');
                    $jumlah_keseluruhan = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', $tanggal_mulai]])
                        ->count();
                    $total = $total_keseluruhan / $jumlah_keseluruhan;
            $imagePath = public_path('sertifikat/toeflprediction.jpg');
            // dd($listening);
            $tanggal = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', $tanggal_mulai]])
                        ->first();
            // Baca gambar dan konversi ke base64
            $imageData = base64_encode(file_get_contents($imagePath));
    
            // Buat URI data
            $imageUri = 'data:image/jpeg;base64,' . $imageData;
    
            // Buat instance DOMPDF
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true); // Enable PHP support if needed
            $dompdf = new Dompdf($options);
    
            // Muat HTML dengan URI gambar
            $html = '<!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
        @page {
            margin: 0;
        }
        .container {
            position: absolute;
            width: 100%;
            height: 100vh; /* Sesuaikan dengan kebutuhan */
            overflow: hidden;
        }
            .text {
                position: absolute;
                font-size: 24px; /* Ukuran teks */
                font-family: "Times New Roman", Times, serif; /* Font teks */
                z-index: 999; /* Pastikan teks di atas gambar */
                color: black; /* Warna teks */
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <img src="' . $imageUri . '" style="width: 100%;" />
            <div class="text" style="top: 250px; left: 355px; width: 400px;">
                <h1 style="text-align: center;">'.Auth::user()->userSiswa->nama.'</h1>
            </div>
            <div class="text" style="top: 520px; left: 420px;">
                Listening
            </div>
            <div class="text" style="top: 548px; left: 420px;">
                Structure and Written
            </div>
            <div class="text" style="top: 575px; left: 420px;">
                Reading
            </div>
            <div class="text" style="top: 520px; left: 670px;">
            '. $listeningg .'
            </div>
            <div class="text" style="top: 548px; left: 502;">
            ' . $swee . '
            </div>
            <div class="text" style="top: 575px; left: 502;">
            ' . $readingg . '
            </div>
            <div class="text" style="top: 602px; left: 502;">
            '. number_format($total, 1) .'
            </div>
            <div class="text" style="top: 669px; left: 100;">
            <h1 style="font-size: 16px;">'. strftime('%d %B %Y', strtotime($tanggal->tanggal_mulai)) .'</h1>
            </div>
        </div>
    </body>
    </html>';
    
            // Load HTML ke DOMPDF
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
    
            // Render PDF
            $dompdf->render();
    
            return $dompdf->stream();
        } elseif (strpos($cek->nama_kategori, "IELTS") !== false) {
            $listening = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai], ['quiz_kategori.nama_kategori', 'LIKE', '%Listening%']])->first();
            if (isset($listening)) {
                $listeningg = $listening->totals;
            }else {
                $listeningg = "-";
            }
            $reading = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai], ['quiz_kategori.nama_kategori', 'LIKE', '%Reading%']])->first();
            if (isset($reading)) {
                $readingg = $reading->totals;
            }else {
                $readingg = "-";
            }
            $writing = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai], ['quiz_kategori.nama_kategori', 'LIKE', '%Writing%']])->first();
            if (isset($writing)) {
                $writingg = $writing->totals;
            }else {
                $writingg = "-";
            }
            $speaking = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai], ['quiz_kategori.nama_kategori', 'LIKE', '%Speaking%']])->first();
            if (isset($speaking)) {
                $speakingg = $speaking->totals;
            }else {
                $speakingg = "-";
            }
            $total_keseluruhan = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', $tanggal_mulai]])
                        ->sum('totals');
                    $jumlah_keseluruhan = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', $tanggal_mulai]])
                        ->count();
                    $total = $total_keseluruhan / $jumlah_keseluruhan;
            $imagePath = public_path('sertifikat/ieltssimulation.jpg');
            // dd($listening);
            $tanggal = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', $tanggal_mulai]])
                        ->first();
            // Baca gambar dan konversi ke base64
            $imageData = base64_encode(file_get_contents($imagePath));
    
            // Buat URI data
            $imageUri = 'data:image/jpeg;base64,' . $imageData;
    
            // Buat instance DOMPDF
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true); // Enable PHP support if needed
            $dompdf = new Dompdf($options);
    
            // Muat HTML dengan URI gambar
            $html = '<!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
        @page {
            margin: 0;
        }
        .container {
            position: absolute;
            width: 100%;
            height: 100vh; /* Sesuaikan dengan kebutuhan */
            overflow: hidden;
        }
            .text {
                position: absolute;
                font-size: 24px; /* Ukuran teks */
                font-family: "Times New Roman", Times, serif; /* Font teks */
                z-index: 999; /* Pastikan teks di atas gambar */
                color: black; /* Warna teks */
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <img src="' . $imageUri . '" style="width: 100%;" />
            <div class="text" style="top: 250px; left: 355px; width: 400px;">
                <h1 style="text-align: center;">'.Auth::user()->userSiswa->nama.'</h1>
            </div>
            <div class="text" style="top: 494px; left: 420px;">
                Speaking
            </div>
            <div class="text" style="top: 520px; left: 420px;">
                Listening
            </div>
            <div class="text" style="top: 548px; left: 420px;">
                Structure and Written
            </div>
            <div class="text" style="top: 575px; left: 420px;">
                Reading
            </div>
            <div class="text" style="top: 494px; left: 670px;">
            '. $speakingg .'
            </div>
            <div class="text" style="top: 520px; left: 670px;">
            '. $listeningg .'
            </div>
            <div class="text" style="top: 548px; left: 502;">
            ' . $writingg . '
            </div>
            <div class="text" style="top: 575px; left: 502;">
            ' . $readingg . '
            </div>
            <div class="text" style="top: 602px; left: 502;">
            '. number_format($total, 1) .'
            </div>
            <div class="text" style="top: 669px; left: 100;">
            <h1 style="font-size: 16px;">'. strftime('%d %B %Y', strtotime($tanggal->tanggal_mulai)) .'</h1>
            </div>
        </div>
    </body>
    </html>';
    
            // Load HTML ke DOMPDF
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
    
            // Render PDF
            $dompdf->render();
    
            return $dompdf->stream();
        } elseif (strpos($cek->nama_kategori, "TOEIC") !== false) {
            $listening = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai], ['quiz_kategori.nama_kategori', 'LIKE', '%Listening%']])->first();
            if (isset($listening)) {
                $listeningg = $listening->totals;
            }else {
                $listeningg = "-";
            }
            $reading = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', '=', $tanggal_mulai], ['quiz_kategori.nama_kategori', 'LIKE', '%Reading%']])->first();
            if (isset($reading)) {
                $readingg = $reading->totals;
            }else {
                $readingg = "-";
            }
            $total_keseluruhan = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', $tanggal_mulai]])
                        ->sum('totals');
                    $jumlah_keseluruhan = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', $tanggal_mulai]])
                        ->count();
                    $total = $total_keseluruhan / $jumlah_keseluruhan;
            $imagePath = public_path('sertifikat/toeicprediction.jpg');
            // dd($listening);
            $tanggal = DetailHasil::join('jadwalquiz', 'detailhasil.jadwal_id', '=', 'jadwalquiz.id')->where([['jadwalquiz.group_id', '=', $id], ['jadwalquiz.tanggal_mulai', $tanggal_mulai]])
                        ->first();
            // Baca gambar dan konversi ke base64
            $imageData = base64_encode(file_get_contents($imagePath));
    
            // Buat URI data
            $imageUri = 'data:image/jpeg;base64,' . $imageData;
    
            // Buat instance DOMPDF
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true); // Enable PHP support if needed
            $dompdf = new Dompdf($options);
    
            // Muat HTML dengan URI gambar
            $html = '<!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
        @page {
            margin: 0;
        }
        .container {
            position: absolute;
            width: 100%;
            height: 100vh; /* Sesuaikan dengan kebutuhan */
            overflow: hidden;
        }
            .text {
                position: absolute;
                font-size: 24px; /* Ukuran teks */
                font-family: "Times New Roman", Times, serif; /* Font teks */
                z-index: 999; /* Pastikan teks di atas gambar */
                color: black; /* Warna teks */
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <img src="' . $imageUri . '" style="width: 100%;" />
            <div class="text" style="top: 250px; left: 355px; width: 400px;">
                <h1 style="text-align: center;">'.Auth::user()->userSiswa->nama.'</h1>
            </div>
            <div class="text" style="top: 520px; left: 420px;">
                Listening
            </div>
            <div class="text" style="top: 553px; left: 420px;">
                Reading
            </div>
            <div class="text" style="top: 520px; left: 670px;">
            '. $listeningg .'
            </div>
            <div class="text" style="top: 553px; left: 502;">
            ' . $readingg . '
            </div>
            <div class="text" style="top: 580px; left: 502;">
            '. number_format($total, 1) .'
            </div>
            <div class="text" style="top: 669px; left: 100;">
            <h1 style="font-size: 16px;">'. strftime('%d %B %Y', strtotime($tanggal->tanggal_mulai)) .'</h1>
            </div>
        </div>
    </body>
    </html>';
    
            // Load HTML ke DOMPDF
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
    
            // Render PDF
            $dompdf->render();
    
            return $dompdf->stream();
        }
    }
}
