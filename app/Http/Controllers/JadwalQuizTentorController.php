<?php

namespace App\Http\Controllers;

use App\Models\GroupQuiz;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Quiz;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JadwalQuizTentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $currentDate = Carbon::now()->toDateString();
        $modelkelas = Kelas::all();
        $modelgroup = GroupQuiz::all();
        $modelquiz = Quiz::where(function ($subquery) use ($user_id) {
            $subquery->whereJsonContains('quiz.user_id', (string) $user_id)
                ->orWhereJsonContains('quiz.user_id', json_encode([$user_id]))
                ->orWhereJsonContains('quiz.user_id', ["all"]);
        })->get();
        $modelprevquiz = Jadwal::join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->select('jadwalquiz.id', 'jadwalquiz.updated_at', 'quiz.judul_quiz')->where(function ($subquery) use ($user_id) {
            $subquery->whereJsonContains('quiz.user_id', (string) $user_id)
                ->orWhereJsonContains('quiz.user_id', json_encode([$user_id]))
                ->orWhereJsonContains('quiz.user_id', ["all"]);
        })->whereDate('jadwalquiz.updated_at', '=', $currentDate)->get();
        return view('backend/tentor.jadwalquiz', compact('modelquiz', 'modelkelas', 'modelprevquiz', 'modelgroup'));
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
            'nama_quiz' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_berakhir' => 'required',
            'waktu_quiz' => 'required',
            'tampilan_soal' => 'required',
            'kelas' => 'required',
            'siswa' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modeljadwalquiz = new Jadwal;
            $modeljadwalquiz->quiz_id = $request->input('nama_quiz');
            $modeljadwalquiz->tanggal_mulai = $request->input('tanggal_mulai');
            $modeljadwalquiz->tanggal_berakhir = $request->input('tanggal_berakhir');
            $modeljadwalquiz->waktu_quiz = $request->input('waktu_quiz');
            $modeljadwalquiz->tampilan_soal = $request->input('tampilan_soal');
            $modeljadwalquiz->user_id = json_encode([strval(Auth::user()->id)]);
            $modeljadwalquiz->siswa_id = json_encode($request->input('siswa'));
            $modeljadwalquiz->kelas_id = $request->input('kelas');
            $modeljadwalquiz->group_id = $request->input('group');
            $modeljadwalquiz->prev_quiz = $request->input('quiz_sebelumnya');
            $modeljadwalquiz->save();

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modeljadwalquiz = Jadwal::find($id);
        $modeljadwalprevious = Jadwal::join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->select('jadwalquiz.id', 'jadwalquiz.quiz_id', 'jadwalquiz.kelas_id', 'jadwalquiz.tanggal_mulai', 'jadwalquiz.tanggal_berakhir', 'jadwalquiz.waktu_quiz', 'jadwalquiz.tampilan_soal',  'jadwalquiz.user_id', 'jadwalquiz.prev_quiz', 'quiz.judul_quiz')->where('jadwalquiz.id', '=', $modeljadwalquiz->prev_quiz)->first();
        if ($modeljadwalquiz) {
            return response()->json([
                'status' => 200,
                'modeljadwalquiz' => $modeljadwalquiz,
                'modeljadwalprevious' => $modeljadwalprevious,
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
            'editnama_quiz' => 'required',
            'edittanggal_mulai' => 'required',
            'edittanggal_berakhir' => 'required',
            'editwaktu_quiz' => 'required',
            'edittampilan_soal' => 'required',
            'editkelas' => 'required',
            'editsiswa' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modeljadwalquiz = Jadwal::find($id);
            if ($modeljadwalquiz) {
                if ($request->input('editquiz_sebelumnya') == null) {
                    $modeljadwalquiz->update([
                        'quiz_id' => $request->input('editnama_quiz'),
                        'tanggal_mulai' => $request->input('edittanggal_mulai'),
                        'tanggal_berakhir' => $request->input('edittanggal_berakhir'),
                        'waktu_quiz' => $request->input('editwaktu_quiz'),
                        'tampilan_soal' => $request->input('edittampilan_soal'),
                        'kelas_id' => $request->input('editkelas'),
                        'group_id' => $request->input('editgroup'),
                        'user_id' => json_encode([strval(Auth::user()->id)]),
                        'siswa_id' => json_encode($request->input('editsiswa')),
                        'prev_quiz' => $request->input('editquiz_sebelumnya'),
                    ]);
                } else {
                    $modeljadwalquiz->update([
                        'quiz_id' => $request->input('editnama_quiz'),
                        'tanggal_mulai' => $request->input('edittanggal_mulai'),
                        'tanggal_berakhir' => $request->input('edittanggal_berakhir'),
                        'waktu_quiz' => $request->input('editwaktu_quiz'),
                        'tampilan_soal' => $request->input('edittampilan_soal'),
                        'kelas_id' => $request->input('editkelas'),
                        'user_id' => json_encode([strval(Auth::user()->id)]),
                        'siswa_id' => json_encode($request->input('editsiswa')),
                        'group_id' => $request->input('editgroup'),
                        'prev_quiz' => $request->input('editquiz_sebelumnya'),
                    ]);
                }
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                    'id' => $id,
                    'modeljadwalquiz' => $modeljadwalquiz
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
        Jadwal::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }
    public function getData()
    {
        $user_id = Auth::user()->id;
        $jadwal = Jadwal::select('jadwalquiz.id', 'jadwalquiz.quiz_id', 'jadwalquiz.tanggal_mulai', 'jadwalquiz.tanggal_berakhir', 'jadwalquiz.waktu_quiz', 'jadwalquiz.tampilan_soal', 'quiz.judul_quiz', 'kelas.kelas')
            ->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')
            ->join('kelas', 'jadwalquiz.kelas_id', '=', 'kelas.id')
            ->where(function ($query) use ($user_id) {
                $query->whereJsonDoesntContain('jadwalquiz.user_id', 'Default')
                    ->where(function ($subquery) use ($user_id) {
                        $subquery->whereJsonContains('jadwalquiz.user_id', (string) $user_id)
                            ->orWhereJsonContains('jadwalquiz.user_id', json_encode([$user_id]))
                            ->orWhereJsonContains('jadwalquiz.user_id', ["all"]);
                    });
            })
            ->get();

        return DataTables::of($jadwal)->make(true);
    }

    public function getQuiz(Request $request)
    {
        $user_id = Auth::user()->id;
        $currentDate = Carbon::now()->toDateString();
        $query = $request->input('q'); // Ambil nilai pencarian dari parameter 'q'

        $modelprevquiz = Jadwal::join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')->select('jadwalquiz.id', 'jadwalquiz.updated_at', 'quiz.judul_quiz')->where(function ($subquery) use ($user_id) {
            $subquery->whereJsonContains('jadwalquiz.user_id', (string) $user_id)
                ->orWhereJsonContains('jadwalquiz.user_id', json_encode([$user_id]))
                ->orWhereJsonContains('jadwalquiz.user_id', ["all"]);
        })->whereDate('jadwalquiz.updated_at', '=', $currentDate)
            ->where(function ($q) use ($query) {
                // Tambahkan kondisi pencarian jika nilai pencarian ada
                if ($query) {
                    $q->where('quiz.judul_quiz', 'like', '%' . $query . '%');
                }
            })->get();

        return response()->json($modelprevquiz);
    }
    public function getSiswa($id)
    {
        $siswa = Siswa::join('users', 'siswa.user_id', '=', 'users.id')->where('siswa.kelas_id', '=', $id)->get();
        return response()->json(['siswa' => $siswa]);
    }
}
