<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
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
        return view('backend/admin.datasiswa', compact('modelkelas', 'modelkursus'));
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
        // $validator = Validator::make($request->all(), [
        //     'nama' => 'required',
        //     'tanggal_lahir' => 'required',
        //     'alamat' => 'required',
        //     'no_telp' => 'required',
        //     'kelas' => 'required',
        //     'kursus' => 'required',

        // ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 400,
        //         'errors' => $validator->messages(),
        //     ]);
        // } else {
        //     $modelsiswa = new Siswa;
        //     $modelsiswa->nama = $request->input('nama');
        //     $modelsiswa->tanggal_lahir = $request->input('tanggal_lahir');
        //     $modelsiswa->alamat = $request->input('alamat');
        //     $modelsiswa->no_telp = $request->input('no_telp');
        //     $modelsiswa->kelas_id = $request->input('kelas');
        //     $modelsiswa->kursus_id = $request->input('kursus');
        //     $modelsiswa->user_id = $request->input('username');
        //     $modelsiswa->save();

        //     return response()->json([
        //         'status' => 200,
        //         'message' => "Data Berhasil Di Tambahkan !!!",
        //     ]);
        // }
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
        $modelsiswa = Siswa::find($id);
        if ($modelsiswa) {
            return response()->json([
                'status' => 200,
                'modelsiswa' => $modelsiswa,
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
            'editnama' => 'required',
            'edittanggal_lahir' => 'required',
            'editalamat' => 'required',
            'editno_telp' => 'required',
            'editkelas' => 'required',
            'editkursus' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modelsiswa = Siswa::find($id);
            if ($modelsiswa) {
                $modelsiswa->update([
                    'nama' => $request->input('editnama'),
                    'tanggal_lahir' => $request->input('edittanggal_lahir'),
                    'alamat' => $request->input('editalamat'),
                    'no_telp' => $request->input('editno_telp'),
                    'kelas_id' => $request->input('editkelas'),
                    'kursus_id' => $request->input('editkursus'),


                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                    'id' => $id,
                    'modelsiswa' => $modelsiswa
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
        Siswa::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }

    public function getData()
    {
        $siswa = Siswa::select('siswa.id', 'siswa.nama', 'siswa.tanggal_lahir', 'siswa.alamat', 'kelas.kelas', 'kursus.kursus', 'siswa.no_telp')
            ->leftJoin('kelas', 'siswa.kelas_id', '=', 'kelas.id')
            ->leftJoin('kursus', 'siswa.kursus_id', '=', 'kursus.id')
            ->join('users', 'siswa.user_id', '=', 'users.id')
            ->get();
        $processedData = $siswa->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'tanggal_lahir' => $item->tanggal_lahir,
                'alamat' => $item->alamat,
                'no_telp' => $item->no_telp,
                'kelas' => $item->kelas ?: '-',
                'kursus' => $item->kursus ?: '-',
            ];
        });

        return DataTables::of($processedData)->make(true);
    }
}
