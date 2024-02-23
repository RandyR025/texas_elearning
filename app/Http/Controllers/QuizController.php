<?php

namespace App\Http\Controllers;

use App\Models\DetailHasil;
use App\Models\DetailWaktu;
use App\Models\HasilPilihan;
use App\Models\HasilText;
use App\Models\Jadwal;
use App\Models\Jawaban;
use App\Models\KategoriQuiz;
use App\Models\Pertanyaan;
use App\Models\Quiz;
use App\Models\SettingSkor;
use App\Models\Tentor;
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
        $modeltentor = Tentor::join('users', 'tentor.user_id', '=', 'users.id')->where('users.level_id', '=', 2)->get();
        return view('backend/admin/quiz.quiz', compact('modelkategori', 'modeltentor'));
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
            'tentor' => 'required',
            'gambar_quiz' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'audio_quiz' => 'mimes:mp3,wav',

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
            $modelquiz->user_id = json_encode($request->input('tentor'));
            if ($request->hasFile('gambar_quiz')) {
                $file = $request->file('gambar_quiz');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('images_quiz', $filename);
                $modelquiz->gambar_quiz = $filename;
            }
            if ($request->hasFile('audio_quiz')) {
                $file = $request->file('audio_quiz');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('audios_quiz', $filename);
                $modelquiz->audio_quiz = $filename;
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
            'edittentor' => 'required',
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
                if ($request->hasFile('editgambar_quiz') && $request->hasFile('editaudio_quiz')) {
                    File::delete('images_quiz/' . $modelquiz->gambar_quiz);
                    $file = $request->file('editgambar_quiz');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images_quiz', $filename);

                    File::delete('audios_quiz/' . $modelquiz->audio_quiz);
                    $file = $request->file('editaudio_quiz');
                    $extension = $file->getClientOriginalExtension();
                    $filenameaudio = time() . '.' . $extension;
                    $file->move('audios_quiz', $filenameaudio);

                    $modelquiz->update([
                        'judul_quiz' => $request->input('editjudul_quiz'),
                        'kategori_id' => $request->input('editkategori'),
                        'user_id' => json_encode($request->input('edittentor')),
                        'gambar_quiz' => $filename,
                        'audio_quiz' => $filenameaudio,

                    ]);
                } elseif ($request->hasFile('editgambar_quiz')) {
                    File::delete('images_quiz/' . $modelquiz->gambar_quiz);
                    $file = $request->file('editgambar_quiz');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('images_quiz', $filename);
                    $modelquiz->update([
                        'judul_quiz' => $request->input('editjudul_quiz'),
                        'kategori_id' => $request->input('editkategori'),
                        'user_id' => json_encode($request->input('edittentor')),
                        'gambar_quiz' => $filename,

                    ]);
                } elseif ($request->hasFile('editaudio_quiz')) {
                    File::delete('audios_quiz/' . $modelquiz->audio_quiz);
                    $file = $request->file('editaudio_quiz');
                    $extension = $file->getClientOriginalExtension();
                    $filenameaudio = time() . '.' . $extension;
                    $file->move('audios_quiz', $filenameaudio);

                    $modelquiz->update([
                        'judul_quiz' => $request->input('editjudul_quiz'),
                        'kategori_id' => $request->input('editkategori'),
                        'user_id' => json_encode($request->input('edittentor')),
                        'audio_quiz' => $filenameaudio,

                    ]);
                } else {
                    if ($modelquiz->audio_quiz != null && $request->cekaudio == null) {
                        File::delete('audios_quiz/' . $modelquiz->audio_quiz);
                        $modelquiz->update([
                        'judul_quiz' => $request->input('editjudul_quiz'),
                        'kategori_id' => $request->input('editkategori'),
                        'user_id' => json_encode($request->input('edittentor')),
                        'audio_quiz' => null,
                    ]);
                    }else {
                        $modelquiz->update([
                            'judul_quiz' => $request->input('editjudul_quiz'),
                            'kategori_id' => $request->input('editkategori'),
                            'user_id' => json_encode($request->input('edittentor')),
                        ]);
                    }
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
        $modelquiz = Quiz::find($id);
        if ($modelquiz->gambar_quiz != null) {
            File::delete('images_quiz/' . $modelquiz->gambar_quiz);
        }
        if ($modelquiz->audio_quiz != null) {
            File::delete('audios_quiz/' . $modelquiz->audio_quiz);
        }
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
        $user_id = Auth::user()->id;
        $jumlahsoal = [];
        $modelquiz = Quiz::select('quiz.id', 'quiz.judul_quiz', 'quiz.gambar_quiz', 'jadwalquiz.tanggal_mulai', 'jadwalquiz.tanggal_berakhir', 'jadwalquiz.id as id_jadwal', 'jadwalquiz.group_id', 'quiz_group.nama_group')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->leftjoin('quiz_group', 'jadwalquiz.group_id', '=', 'quiz_group.id')->where('jadwalquiz.kelas_id', '=', Auth::user()->userSiswa->kelas_id)
        ->where(function ($query) use ($user_id) {
            $query->where(function ($subquery) use ($user_id) {
                    $subquery->whereJsonContains('jadwalquiz.siswa_id', (string) $user_id)
                        ->orWhereJsonContains('jadwalquiz.siswa_id', json_encode([$user_id]))
                        ->orWhereJsonContains('jadwalquiz.siswa_id', ["all"]);
                });
        })->orderBy('jadwalquiz.id', 'asc')->get()->groupBy(['group_id','tanggal_mulai']);
        // dd($modelquiz);
        foreach ($modelquiz as $keyyy => $valueee) {
            foreach ($valueee as $keyy => $valuee) {
                foreach ($valuee as $key => $value) {
                    $jumlahsoal[$key] = Pertanyaan::where([['quiz_id', '=', $value->id], ['tipe_pertanyaan', '!=', 'Custom Banner']])->get()->count();
                }
            }
        }
        $tanggal = Carbon::now('Asia/Jakarta');
        $now = $tanggal->toDateTimeString();
        $future = $tanggal->addWeek();
        return view('backend/siswa.quiz', compact('modelquiz', 'jumlahsoal', 'now'));
    }

    public function quizSiswaCover($id, $tanggal)
    {
        $user_id = Auth::user()->id;
        $jumlahsoal = [];
        $modelquiz = Quiz::select('quiz.id', 'quiz.judul_quiz', 'quiz.gambar_quiz', 'jadwalquiz.tanggal_mulai', 'jadwalquiz.tanggal_berakhir', 'jadwalquiz.id as id_jadwal', 'jadwalquiz.group_id', 'quiz_group.nama_group')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->leftjoin('quiz_group', 'jadwalquiz.group_id', '=', 'quiz_group.id')->where([['jadwalquiz.kelas_id', '=', Auth::user()->userSiswa->kelas_id],['jadwalquiz.group_id','=',$id],['jadwalquiz.tanggal_mulai','=',$tanggal]])->where(function ($query) use ($user_id) {
            $query->where(function ($subquery) use ($user_id) {
                    $subquery->whereJsonContains('jadwalquiz.siswa_id', (string) $user_id)
                        ->orWhereJsonContains('jadwalquiz.siswa_id', json_encode([$user_id]))
                        ->orWhereJsonContains('jadwalquiz.siswa_id', ["all"]);
                });
        })->orderBy('jadwalquiz.id', 'asc')->get();
        // dd($modelquiz);
        foreach ($modelquiz as $key => $value) {
                    $jumlahsoal[$key] = Pertanyaan::where([['quiz_id', '=', $value->id], ['tipe_pertanyaan', '!=', 'Custom Banner']])->get()->count();
        }
        $tanggal = Carbon::now('Asia/Jakarta');
        $now = $tanggal->toDateTimeString();
        $future = $tanggal->addWeek();
        return view('backend/siswa.quiz', compact('modelquiz', 'jumlahsoal', 'now'));
    }

    public function quizDetail(Request $request, $id, $jadwal)
    {
        $halaman = Jadwal::find($jadwal);
        // dd($halaman->tampilan_soal);
        $quiz = Pertanyaan::select('pertanyaan.id', 'pertanyaan.pertanyaan', 'pertanyaan.tipe_pertanyaan', 'pertanyaan.quiz_id', 'jadwalquiz.id as jadwal', 'quiz.audio_quiz')->join('quiz', 'pertanyaan.quiz_id', '=', 'quiz.id')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->where([['quiz.id', '=', $id], ['jadwalquiz.id', '=', $jadwal],['pertanyaan.tipe_pertanyaan','!=','Custom Banner']])->orderBy('order_column', 'asc')->paginate($halaman->tampilan_soal);
        $jumlahpertanyaan = Pertanyaan::select('pertanyaan.id', 'pertanyaan.pertanyaan', 'pertanyaan.tipe_pertanyaan', 'pertanyaan.quiz_id', 'jadwalquiz.id as jadwal')->join('quiz', 'pertanyaan.quiz_id', '=', 'quiz.id')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->where([['quiz.id', '=', $id], ['jadwalquiz.id', '=', $jadwal]])->orderBy('order_column', 'asc')->count();
        // dd($jumlahpertanyaan);
        $kotakquiz = Pertanyaan::select('pertanyaan.id', 'pertanyaan.pertanyaan', 'pertanyaan.tipe_pertanyaan', 'pertanyaan.quiz_id', 'jadwalquiz.id as jadwal')->join('quiz', 'pertanyaan.quiz_id', '=', 'quiz.id')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->where([['quiz.id', '=', $id], ['jadwalquiz.id', '=', $jadwal],['pertanyaan.tipe_pertanyaan','!=','Custom Banner']])->orderBy('order_column', 'asc')->get();
        $custom_banner = Pertanyaan::select('pertanyaan.id', 'pertanyaan.pertanyaan', 'pertanyaan.tipe_pertanyaan', 'pertanyaan.quiz_id', 'jadwalquiz.id as jadwal', 'quiz.audio_quiz','jawabanpertanyaan.jawaban')->join('quiz', 'pertanyaan.quiz_id', '=', 'quiz.id')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->join('jawabanpertanyaan','jawabanpertanyaan.pertanyaan_id','=','pertanyaan.id')->where([['quiz.id', '=', $id], ['jadwalquiz.id', '=', $jadwal],['pertanyaan.tipe_pertanyaan','=','Custom Banner']])->orderBy('order_column', 'asc')->get();
        $pilihan = [];
        $cekstatus = $datawaktu = DetailWaktu::where([['user_id', '=', Auth::user()->id], ['quiz_id', '=', $id], ['jadwal_id', '=', $jadwal]])->get()->count();
        // dd($cekstatus);
        $kategori = KategoriQuiz::join('quiz','quiz.kategori_id','=','quiz_kategori.id')->where('quiz.id','=',$id)->first();
        if ($cekstatus == 0) {
            $waktu_quiz = Jadwal::find($jadwal);
            $waktu = new DetailWaktu;
            $waktu->waktu_end = now()->addMinutes($waktu_quiz->waktu_quiz);
            $waktu->user_id = Auth::user()->id;
            $waktu->quiz_id = $id;
            $waktu->jadwal_id = $jadwal;
            $waktu->save();
        }
        $datawaktu = DetailWaktu::where([['user_id', '=', Auth::user()->id], ['quiz_id', '=', $id], ['jadwal_id', '=', $jadwal]])->first();
        $jumlahsoal = Pertanyaan::where('quiz_id', '=', $id)->get()->count();
        foreach ($quiz as $key => $value) {
            $pilihan[$key] = Jawaban::where('pertanyaan_id', '=', $value->id)->get();
        }
        if ($request->ajax()) {
            return view('backend/siswa.quizpaginator', compact('quiz', 'pilihan', 'datawaktu', 'jumlahsoal', 'kotakquiz','halaman','kategori','custom_banner'));
        }
        // dd($pilihan);
        return view('backend/siswa.detailquiz', compact('quiz', 'pilihan', 'datawaktu', 'jumlahsoal', 'kotakquiz','halaman','kategori','custom_banner'));
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

    public function HasilTextQuiz(Request $request)
    {
        // return $request->pertanyaan_id;
        $query = HasilText::where([
            ['user_id', '=', Auth::user()->id],
            ['pertanyaan_id', '=', $request->pertanyaan_id],
            ['jadwal_id', '=', $request->jadwal_id],
        ])->count();

        if ($query == 0) {
            $hasilText = new HasilText;
            $hasilText->jawaban_id = $request->jawaban_id;
            $hasilText->pertanyaan_id = $request->pertanyaan_id;
            $hasilText->jadwal_id = $request->jadwal_id;
            $hasilText->jawaban = $request->data;
            $hasilText->user_id = Auth::user()->id;
            $hasilText->save();
        } else {
            HasilText::where([
                ['user_id', '=', Auth::user()->id],
                ['pertanyaan_id', '=', $request->pertanyaan_id],
                ['jadwal_id', '=', $request->jadwal_id],
            ])->update(['jawaban' => $request->data]);
        }
    }

    public function totalnilai(Request $request)
    {
        $jawaban = 0;
        $hasil = HasilPilihan::join('jadwalquiz', 'hasilpilihan.jadwal_id', '=', 'jadwalquiz.id')
            ->join('pertanyaan', 'hasilpilihan.pertanyaan_id', '=', 'pertanyaan.id')
            ->join('jawabanpertanyaan', 'hasilpilihan.jawaban_id', '=', 'jawabanpertanyaan.id')
            ->select('hasilpilihan.pertanyaan_id', 'hasilpilihan.jawaban_id', 'hasilpilihan.jadwal_id', 'jawabanpertanyaan.point')
            ->where('hasilpilihan.jadwal_id', '=', $request->jadwal)
            ->where('jadwalquiz.quiz_id', '=', $request->id)
            ->where('hasilpilihan.user_id', '=', Auth::user()->id)
            ->get();
        $jumlah_soal = Pertanyaan::join('quiz', 'pertanyaan.quiz_id', '=', 'quiz.id')->join('jadwalquiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->where([['quiz.id', '=', $request->id], ['jadwalquiz.id', '=', $request->jadwal], ['pertanyaan.tipe_pertanyaan','!=','Custom Banner']])->get()->count();
        foreach ($hasil as $key => $value) {
            if ($value->point == 1) {
                $jawaban++;
            }
        }
        if (!cekQuiz($request->id, Auth::user()->id, $request->jadwal)) {
            $jawaban_benar = collect($jawaban);
            // dd($jawaban_benar);
            $modelskor = SettingSkor::join('quiz_kategori','skorsetting.kategori_id','=','quiz_kategori.id')->join('quiz','quiz.kategori_id','=','quiz_kategori.id')->where('quiz.id','=',$request->id)->where('skorsetting.jumlah_benar','=',$jawaban_benar)->first();
            if (isset($modelskor)) {
                $total = $modelskor->skor;
            }else {
                $total = (($jawaban_benar[0] / $jumlah_soal) * 100);
            }
            $modeldetailhasil = new DetailHasil;
            $modeldetailhasil->user_id = Auth::user()->id;
            $modeldetailhasil->quiz_id = $request->id;
            $modeldetailhasil->jadwal_id = $request->jadwal;
            $modeldetailhasil->totals = $total;
            $modeldetailhasil->save();
        }
        // dd($total);
        return redirect()->route('quizsiswa');
    }
    public function cekhasil(Request $request, $id, $jadwal)
    {
        $modelhasil = DetailHasil::where([['user_id', '=', Auth::user()->id], ['quiz_id', '=', $id], ['jadwal_id', '=', $jadwal]])->get()->count();
        return response()->json([
            'user' => $modelhasil,
            'message' => "Berhasil Cek Hasil",
        ]);
    }

    public function getAnswerStatus($questionId, $userId, $jadwal)
    {
        $isAnswered = cekhasilPilihan($questionId, $userId, $jadwal);
        return response()->json(['isAnswered' => $isAnswered]);
    }
}
