<?php

namespace App\Http\Controllers;

use App\Models\Kursus;
use App\Models\Tentor;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelkursus = Kursus::all();
        return view('backend/admin.datatentor', compact('modelkursus'));
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
        $modeltentor = Tentor::find($id);
        if ($modeltentor) {
            return response()->json([
                'status' => 200,
                'modeltentor' => $modeltentor,
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
            'editkursus' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modeltentor = Tentor::find($id);
            if ($modeltentor) {
                $modeltentor->update([
                    'nama' => $request->input('editnama'),
                    'tanggal_lahir' => $request->input('edittanggal_lahir'),
                    'alamat' => $request->input('editalamat'),
                    'no_telp' => $request->input('editno_telp'),
                    'kursus_id' => $request->input('editkursus'),


                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                    'id' => $id,
                    'modeltentor' => $modeltentor
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
        //
    }

    public function getData()
    {
        $tentor = Tentor::select('tentor.id', 'tentor.nama', 'tentor.tanggal_lahir', 'tentor.alamat', 'kursus.kursus', 'tentor.no_telp')
            ->leftJoin('kursus', 'tentor.kursus_id', '=', 'kursus.id')
            ->join('users', 'tentor.user_id', '=', 'users.id')
            ->where('users.level_id','=',2)
            ->get();
        $processedData = $tentor->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'tanggal_lahir' => $item->tanggal_lahir,
                'alamat' => $item->alamat,
                'no_telp' => $item->no_telp,
                'kursus' => $item->kursus ?: '-',
            ];
        });

        return DataTables::of($processedData)->make(true);
    }
}
