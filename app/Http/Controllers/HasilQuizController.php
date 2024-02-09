<?php

namespace App\Http\Controllers;

use App\Models\DetailHasil;
use App\Models\Jadwal;
use App\Models\Jawaban;
use App\Models\KategoriQuiz;
use App\Models\Pertanyaan;
use App\Models\Quiz;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class HasilQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelquiz = Quiz::all();
        return view('backend/admin/quiz.hasilquiz', compact('modelquiz'));
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
    public function show($id)
    {
        $modelhasilquiz = DetailHasil::where('detailhasil.jadwal_id','=',$id)->first();
        $modelquiz = Jadwal::join('quiz','jadwalquiz.quiz_id','=','quiz.id')->where('jadwalquiz.id','=',$id)->first();
        // if (isset($modelhasilquiz->quiz_id)) {
        //     $modelquiz = Quiz::where('quiz.id','=',$modelhasilquiz->quiz_id)->first();
        // }
        return view('backend/admin/quiz.detailhasilquiz',compact('modelquiz','modelhasilquiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modeldetailhasil = DetailHasil::find($id);
        if ($modeldetailhasil) {
            return response()->json([
                'status' => 200,
                'modeldetailhasil' => $modeldetailhasil,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data Not Found',
            ]);
        }
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
        $validator = Validator::make($request->all(), [
            'editnilai' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modeldetailhasil = DetailHasil::find($id);
            if ($modeldetailhasil) {
                $modeldetailhasil->update([
                    'totals' => $request->input('editnilai'),


                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                    'id' => $id,
                    'modeldetailhasil' => $modeldetailhasil
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data Not Found',
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DetailHasil::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }

    public function getData()
    {
        $jadwal = Jadwal::select('jadwalquiz.id', 'jadwalquiz.quiz_id', 'jadwalquiz.tanggal_mulai', 'jadwalquiz.tanggal_berakhir', 'jadwalquiz.waktu_quiz', 'jadwalquiz.tampilan_soal', 'quiz.judul_quiz', 'kelas.kelas')
            ->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')
            ->join('kelas', 'jadwalquiz.kelas_id', '=', 'kelas.id')
            ->leftJoin('detailhasil', 'jadwalquiz.id', '=', 'detailhasil.jadwal_id') // Left join dengan tabel jawaban_quiz
            ->selectRaw('COUNT(DISTINCT detailhasil.user_id) as jumlah_siswa') // Menghitung jumlah siswa yang sudah mengikuti quiz
            ->groupBy('jadwalquiz.id', 'jadwalquiz.quiz_id', 'jadwalquiz.tanggal_mulai', 'jadwalquiz.tanggal_berakhir', 'jadwalquiz.waktu_quiz', 'jadwalquiz.tampilan_soal', 'quiz.judul_quiz', 'kelas.kelas')
            ->get();

        return DataTables::of($jadwal)->make(true);
    }

    public function getDataDetail($id){
        $detailhasilquiz = DetailHasil::select('detailhasil.id','detailhasil.user_id','detailhasil.jadwal_id','detailhasil.totals','siswa.nama')->join('users','users.id','=','detailhasil.user_id')->join('siswa','siswa.user_id','=','users.id')->where('detailhasil.jadwal_id', $id)->get();

        $processedData = $detailhasilquiz->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'skor' => $item->totals,
            ];
        });
        return DataTables::of($processedData)->make(true);
    }

    public function showDetail(Request $request, $id)
    {
        $modelhasilquiz = DetailHasil::where('detailhasil.id','=',$id)->first();
        $siswa = Siswa::where('siswa.user_id','=',$modelhasilquiz->user_id)->get();
        $halaman = Jadwal::find($modelhasilquiz->jadwal_id);
        $quiz = Pertanyaan::select('pertanyaan.id', 'pertanyaan.pertanyaan', 'pertanyaan.tipe_pertanyaan', 'pertanyaan.quiz_id', 'jadwalquiz.id as jadwal')->join('quiz', 'pertanyaan.quiz_id', '=', 'quiz.id')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->where([['quiz.id', '=', $modelhasilquiz->quiz_id], ['jadwalquiz.id', '=', $modelhasilquiz->jadwal_id], ['pertanyaan.tipe_pertanyaan','!=','Custom Banner']])->orderBy('order_column', 'asc')->paginate($halaman->tampilan_soal);
        // dd($halaman);
        $kotakquiz = Pertanyaan::select('pertanyaan.id', 'pertanyaan.pertanyaan', 'pertanyaan.tipe_pertanyaan', 'pertanyaan.quiz_id', 'jadwalquiz.id as jadwal')->join('quiz', 'pertanyaan.quiz_id', '=', 'quiz.id')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->where([['quiz.id', '=', $modelhasilquiz->quiz_id], ['jadwalquiz.id', '=', $modelhasilquiz->jadwal_id],['pertanyaan.tipe_pertanyaan','!=','Custom Banner']])->orderBy('order_column', 'asc')->get();
        $custom_banner = Pertanyaan::select('pertanyaan.id', 'pertanyaan.pertanyaan', 'pertanyaan.tipe_pertanyaan', 'pertanyaan.quiz_id', 'jadwalquiz.id as jadwal', 'quiz.audio_quiz','jawabanpertanyaan.jawaban')->join('quiz', 'pertanyaan.quiz_id', '=', 'quiz.id')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('jawabanpertanyaan','jawabanpertanyaan.pertanyaan_id','=','pertanyaan.id')->where([['quiz.id', '=', $modelhasilquiz->quiz_id], ['jadwalquiz.id', '=', $modelhasilquiz->jadwal_id],['pertanyaan.tipe_pertanyaan','=','Custom Banner']])->orderBy('order_column', 'asc')->get();
        $kategori = KategoriQuiz::join('quiz','quiz.kategori_id','=','quiz_kategori.id')->where('quiz.id','=',$modelhasilquiz->quiz_id)->first();
        $pilihan = [];
        $jumlahsoal = Pertanyaan::where('quiz_id', '=', $modelhasilquiz->quiz_id)->get()->count();
        foreach ($quiz as $key => $value) {
            $pilihan[$key] = Jawaban::where('pertanyaan_id', '=', $value->id)->get();
        }
        if ($request->ajax()) {
            return view('backend/admin/quiz.hasilquizpaginator', compact('quiz', 'pilihan','jumlahsoal','modelhasilquiz','siswa','kotakquiz','halaman','kategori','custom_banner'));
        }
        // dd($pilihan);
        return view('backend/admin/quiz.detailhasiljawaban', compact('quiz', 'pilihan','jumlahsoal','modelhasilquiz','siswa','kotakquiz','halaman','kategori','custom_banner'));
    }
}
