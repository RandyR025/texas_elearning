<?php

namespace App\Http\Controllers;

use App\Models\DetailHasil;
use App\Models\DetailWaktu;
use App\Models\HasilPilihan;
use App\Models\Jadwal;
use App\Models\Jawaban;
use App\Models\KategoriQuiz;
use App\Models\Pertanyaan;
use App\Models\Quiz;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelkategori = KategoriQuiz::all();
        return view('backend/admin/quiz.quiz', compact('modelkategori'));
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
        $validator = Validator::make($request->all(), [
            'judul_quiz' => 'required',
            'kategori' => 'required',
            'gambar_quiz' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modelquiz = new Quiz;
            $modelquiz->judul_quiz = $request->input('judul_quiz');
            $modelquiz->kategori_id = $request->input('kategori');
            if ($request->hasFile('gambar_quiz')) {
                $file = $request->file('gambar_quiz');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images_quiz', $filename);
                $modelquiz->gambar_quiz = $filename;
            }
            $modelquiz->save();

            return response()->json([
                'status' => 200,
                'message' => "Data Berhasil Di Tambahkan !!!",
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelquiz = Quiz::find($id);
        return view('backend/admin/quiz.pertanyaan', compact('modelquiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modelquiz = Quiz::find($id);
        if ($modelquiz) {
            return response()->json([
                'status' => 200,
                'modelquiz' => $modelquiz,
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
            'editjudul_quiz' => 'required',
            'editkategori' => 'required',
            'editgambar_quiz' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modelquiz = Quiz::find($id);
            if ($modelquiz) {
                if ($request->hasFile('editgambar_quiz')) {
                    File::delete('images_quiz/' . $modelquiz->gambar_quiz);
                    $file = $request->file('editgambar_quiz');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images_quiz', $filename);
                    $modelquiz->update([
                        'judul_quiz' => $request->input('editjudul_quiz'),
                        'kategori_id' => $request->input('editkategori'),
                        'gambar_quiz' => $filename,

                    ]);
                } else {
                    $modelquiz->update([
                        'judul_quiz' => $request->input('editjudul_quiz'),
                        'kategori_id' => $request->input('editkategori'),

                    ]);
                }
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                    'id' => $id,
                    'modelquiz' => $modelquiz
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
        Quiz::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }

    public function getData()
    {
        $siswa = Quiz::select('quiz.id', 'quiz.judul_quiz', 'quiz.kategori_id', 'quiz_kategori.nama_kategori', 'quiz_kategori.deskripsi')
            ->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')
            ->get();

        return DataTables::of($siswa)->make(true);
    }

    public function quizSiswa()
    {
        $modelquiz = Quiz::select('quiz.id', 'quiz.judul_quiz', 'quiz.gambar_quiz', 'jadwalquiz.tanggal_mulai', 'jadwalquiz.tanggal_berakhir', 'jadwalquiz.id as id_jadwal')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->get();
        foreach ($modelquiz as $key => $value) {
            $jumlahsoal = Pertanyaan::where('quiz_id', '=', $value->id)->get()->count();
        }
        $tanggal = Carbon::now('Asia/Jakarta');
        $now = $tanggal->toDateString();
        $future = $tanggal->addWeek();
        return view('backend/siswa.quiz', compact('modelquiz', 'jumlahsoal', 'now'));
    }
    public function quizDetail(Request $request, $id, $jadwal)
    {
        $quiz = Pertanyaan::select('pertanyaan.id', 'pertanyaan.pertanyaan', 'pertanyaan.quiz_id', 'jadwalquiz.id as jadwal')->join('quiz', 'pertanyaan.quiz_id', '=', 'quiz.id')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->where([['quiz.id', '=', $id], ['jadwalquiz.id', '=', $jadwal]])->paginate(1);
        $pilihan = [];
        $cekstatus = $datawaktu = DetailWaktu::where([['user_id','=',Auth::user()->id],['quiz_id','=',$id],['jadwal_id','=',$jadwal]])->get()->count();
        // dd($cekstatus);
        if ($cekstatus == 0) {
            $waktu_quiz = Jadwal::find($jadwal);
            $waktu = new DetailWaktu;
            $waktu->waktu_end = now()->addMinutes($waktu_quiz->waktu_quiz);
            $waktu->user_id = Auth::user()->id;
            $waktu->quiz_id = $id;
            $waktu->jadwal_id = $jadwal;
            $waktu->save();
        }
        $datawaktu = DetailWaktu::where([['user_id','=',Auth::user()->id],['quiz_id','=',$id],['jadwal_id','=',$jadwal]])->first();
        $jumlahsoal = Pertanyaan::where('quiz_id', '=', $id)->get()->count();
        foreach ($quiz as $key => $value) {
            $pilihan[$key] = Jawaban::where('pertanyaan_id', '=', $value->id)->get();
        }
        if ($request->ajax()) {
            return view('backend/siswa.quizpaginator', compact('quiz', 'pilihan', 'datawaktu','jumlahsoal'));
        }
        // dd($pilihan);
        return view('backend/siswa.detailquiz', compact('quiz', 'pilihan', 'datawaktu','jumlahsoal'));
    }

    public function HasilPilihanQuiz(Request $request)
    {
        $query = HasilPilihan::where([
            ['user_id', '=', Auth::user()->id],
            ['pertanyaan_id', '=', $request->pengisian_id],
            ['jadwal_id', '=', $request->tanggal_id],
        ])->count();

        if ($query == 0) {
            $hasilpilihan = new HasilPilihan;
            $hasilpilihan->jawaban_id = $request->option_id;
            $hasilpilihan->pertanyaan_id = $request->pengisian_id;
            $hasilpilihan->jadwal_id = $request->tanggal_id;
            $hasilpilihan->user_id = Auth::user()->id;
            $hasilpilihan->save();
        } else {
            HasilPilihan::where([
                ['user_id', '=', Auth::user()->id],
                ['pertanyaan_id', '=', $request->pengisian_id],
                ['jadwal_id', '=', $request->tanggal_id],
            ])->update(['jawaban_id' => $request->option_id]);
        }
    }

    public function totalnilai($id,$jadwal){
        $jawaban = 0;
        $hasil = HasilPilihan::join('jadwalquiz','hasilpilihan.jadwal_id','=','jadwalquiz.id')
        ->join('pertanyaan','hasilpilihan.pertanyaan_id','=','pertanyaan.id')
        ->join('jawabanpertanyaan', 'hasilpilihan.jawaban_id','=','jawabanpertanyaan.id')
        ->select('hasilpilihan.pertanyaan_id','hasilpilihan.jawaban_id','hasilpilihan.jadwal_id','jawabanpertanyaan.point')
        ->where('hasilpilihan.jadwal_id','=',$jadwal)
        ->where('jadwalquiz.quiz_id','=',$id)
        ->where('hasilpilihan.user_id','=',Auth::user()->id)
        ->get();
        $jumlah_soal = Pertanyaan::join('quiz','pertanyaan.quiz_id','=','quiz.id')->join('jadwalquiz','jadwalquiz.quiz_id','=','quiz.id')->where([['quiz.id','=',$id],['jadwalquiz.id','=',$jadwal]])->get()->count();
        foreach ($hasil as $key => $value) {
            if ($value->point == 1) {
                $jawaban++;
            }
        }
        if (!cekQuiz($id,Auth::user()->id,$jadwal)) {
            $jawaban_benar = collect($jawaban);
            $total = (($jawaban_benar[0]/$jumlah_soal)*100);
            $modeldetailhasil = new DetailHasil;
            $modeldetailhasil->user_id = Auth::user()->id;
            $modeldetailhasil->quiz_id = $id;
            $modeldetailhasil->jadwal_id = $jadwal;
            $modeldetailhasil->totals = $total;
            $modeldetailhasil->save();
        }
        // dd($total);
        return redirect()->route('quizsiswa');
    }
}
