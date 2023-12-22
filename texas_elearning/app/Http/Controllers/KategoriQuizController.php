<?php

namespace App\Http\Controllers;

use App\Models\KategoriQuiz;
use App\Models\Kelas;
use App\Models\Kursus;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelkelas = Kelas::all();
        $modelkursus = Kursus::all();
        return view('backend/admin/quiz.kategoriquiz', compact('modelkelas', 'modelkursus'));
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
            'nama_kategori' => 'required',
            'deskripsi' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modelkatgeoriquiz = new KategoriQuiz;
            $modelkatgeoriquiz->nama_kategori = $request->input('nama_kategori');
            $modelkatgeoriquiz->deskripsi = $request->input('deskripsi');
            $modelkatgeoriquiz->save();

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
        $modelkategoriquiz = KategoriQuiz::find($id);
        if ($modelkategoriquiz) {
            return response()->json([
                'status' => 200,
                'modelkategoriquiz' => $modelkategoriquiz,
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
            'editnama_kategori' => 'required',
            'editdeskripsi' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modelkategoriquiz = KategoriQuiz::find($id);
            if ($modelkategoriquiz) {
                $modelkategoriquiz->update([
                    'nama_kategori' => $request->input('editnama_kategori'),
                    'deskripsi' => $request->input('editdeskripsi'),


                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                    'id' => $id,
                    'modelkategoriquiz' => $modelkategoriquiz
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
        KategoriQuiz::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }

    public function getData()
    {
        $siswa = KategoriQuiz::select('quiz_kategori.id', 'quiz_kategori.nama_kategori', 'quiz_kategori.deskripsi')
            ->get();

        return DataTables::of($siswa)->make(true);
    }
}
