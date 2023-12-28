<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Quiz;
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
        return view('backend/admin/quiz.jadwalquiz', compact('modelquiz'));
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
        $jadwal = Jadwal::select('jadwalquiz.id', 'jadwalquiz.quiz_id', 'jadwalquiz.tanggal_mulai', 'jadwalquiz.tanggal_berakhir', 'jadwalquiz.waktu_quiz', 'jadwalquiz.tampilan_soal', 'quiz.judul_quiz')
            ->join('quiz', 'jadwalquiz.quiz_id', '=', 'quiz.id')
            ->get();

        return DataTables::of($jadwal)->make(true);
    }
}
