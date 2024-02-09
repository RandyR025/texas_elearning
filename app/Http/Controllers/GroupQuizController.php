<?php

namespace App\Http\Controllers;

use App\Models\GroupQuiz;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class GroupQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $modelkelas = Kelas::all();
        // $modelkursus = Kursus::all();
        return view('backend/admin/quiz.groupquiz');
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
            'nama_group' => 'required',
            'deskripsi' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modelkatgeoriquiz = new GroupQuiz;
            $modelkatgeoriquiz->nama_group = $request->input('nama_group');
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
        $modelgroupquiz = GroupQuiz::find($id);
        if ($modelgroupquiz) {
            return response()->json([
                'status' => 200,
                'modelgroupquiz' => $modelgroupquiz,
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
            'editnama_group' => 'required',
            'editdeskripsi' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modelgroupquiz = GroupQuiz::find($id);
            if ($modelgroupquiz) {
                $modelgroupquiz->update([
                    'nama_group' => $request->input('editnama_group'),
                    'deskripsi' => $request->input('editdeskripsi'),


                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                    'id' => $id,
                    'modelgroupquiz' => $modelgroupquiz
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
        GroupQuiz::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }

    public function getData()
    {
        $group = GroupQuiz::select('quiz_group.id', 'quiz_group.nama_group', 'quiz_group.deskripsi')
            ->get();

        return DataTables::of($group)->make(true);
    }
}
