<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Quiz;
use App\Models\Tentor;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class JadwalQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelquiz = Quiz::all();
        $modelkelas = Kelas::all();
        $modeltentor = Tentor::join('users','tentor.user_id','=','users.id')->where('users.level_id','=',2)->get();
        return view('backend/admin/quiz.jadwalquiz', compact('modelquiz','modeltentor','modelkelas'));
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
            'tentor' => 'required',
            'kelas' => 'required',

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
            $modeljadwalquiz->user_id = json_encode($request->input('tentor'));
            $modeljadwalquiz->kelas_id = $request->input('kelas');
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
        if ($modeljadwalquiz) {
            return response()->json([
                'status' => 200,
                'modeljadwalquiz' => $modeljadwalquiz,
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
            'edittentor' => 'required',
            'editkelas' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modeljadwalquiz = Jadwal::find($id);
            if ($modeljadwalquiz) {
                $modeljadwalquiz->update([
                    'quiz_id' => $request->input('editnama_quiz'),
                    'tanggal_mulai' => $request->input('edittanggal_mulai'),
                    'tanggal_berakhir' => $request->input('edittanggal_berakhir'),
                    'waktu_quiz' => $request->input('editwaktu_quiz'),
                    'tampilan_soal' => $request->input('edittampilan_soal'),
                    'kelas_id' => $request->input('editkelas'),
                    'user_id' => json_encode($request->input('edittentor')),


                ]);
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
        $jadwal = Jadwal::select('jadwalquiz.id', 'jadwalquiz.quiz_id', 'jadwalquiz.tanggal_mulai', 'jadwalquiz.tanggal_berakhir', 'jadwalquiz.waktu_quiz', 'jadwalquiz.tampilan_soal', 'quiz.judul_quiz', 'kelas.kelas')
            ->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')
            ->join('kelas', 'jadwalquiz.kelas_id', '=', 'kelas.id')
            ->get();

        return DataTables::of($jadwal)->make(true);
    }
}
