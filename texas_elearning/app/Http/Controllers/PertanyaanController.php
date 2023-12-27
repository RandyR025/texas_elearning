<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'pertanyaan' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modelpertanyaan = new Pertanyaan;
            $modelpertanyaan->pertanyaan = $request->input('pertanyaan');
            // $modelpertanyaan->tipe_pertanyaan = $request->input('kategori');
            $modelpertanyaan->quiz_id = $request->input('hidden_id');
            $modelpertanyaan->tipe_pertanyaan = $request->tipe_pertanyaan;
            $modelpertanyaan->save();
            // dd($request->input('bobot'));
            if ($request->tipe_pertanyaan == "Pilihan") {
                foreach ($request->input('bobot') as $key => $bobot) {
                    $modeljawaban = new Jawaban; // Sesuaikan dengan model Anda
                    $modeljawaban->point = $bobot;
                    $modeljawaban->jawaban = $request->input('jawaban')[$key];
                    $modeljawaban->pertanyaan_id = $modelpertanyaan->id;
                    $modeljawaban->save();
                }
            } elseif ($request->tipe_pertanyaan == "Teks") {
                $modeljawaban = new Jawaban; // Sesuaikan dengan model Anda
                $modeljawaban->point = $request->textbobot;
                $modeljawaban->jawaban = $request->textjawaban;
                $modeljawaban->pertanyaan_id = $modelpertanyaan->id;
                $modeljawaban->save();
            }

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
        $modelpertanyaan = Pertanyaan::find($id);
        $modeljawaban = Jawaban::where('pertanyaan_id', $id)->get();
        if ($modelpertanyaan) {
            return response()->json([
                'status' => 200,
                'modelpertanyaan' => $modelpertanyaan,
                'modeljawaban' => $modeljawaban,
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
            'editpertanyaan' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modelpertanyaan = Pertanyaan::find($id);
            if ($modelpertanyaan) {
                $modelpertanyaan->update([
                    'pertanyaan' => $request->input('editpertanyaan'),
                    'tipe_pertanyaan' => $request->input('edittipe_pertanyaan'),
                    // dd($request->input('bobot'));1
                ]);
                if ($request->edittipe_pertanyaan == "Pilihan") {
                    if ($request->input('editbobot')) {
                        foreach ($request->input('editbobot') as $key => $bobot) {
                            $modeljawaban = Jawaban::where('id', $request->id[$key]); // Sesuaikan dengan model Anda
                            $modeljawaban->update([
                                'point' => $bobot,
                                'jawaban' => $request->input('editjawaban')[$key],
                            ]);
                        }
                    }
                    if ($request->input('editbobottambah')) {
                        if ($request->tipe == "Teks") {
                            Jawaban::where('pertanyaan_id', '=', $id)->delete();
                        }
                        foreach ($request->input('editbobottambah') as $key => $bobot) {
                            $modeljawaban = new Jawaban; // Sesuaikan dengan model Anda
                            $modeljawaban->point = $bobot;
                            $modeljawaban->jawaban = $request->input('editjawabantambah')[$key];
                            $modeljawaban->pertanyaan_id = $id;
                            $modeljawaban->save();
                        }
                    }
                } elseif ($request->edittipe_pertanyaan == "Teks") {
                    if ($request->tipe == "Pilihan") {
                        Jawaban::where('pertanyaan_id', '=', $id)->delete();
                        $modeljawaban = new Jawaban;
                        $modeljawaban->point = $request->edittextbobot;
                        $modeljawaban->jawaban = $request->edittextjawaban;
                        $modeljawaban->pertanyaan_id = $id;
                        $modeljawaban->save();
                    }elseif ($request->tipe == "Teks") {
                        $modeljawaban = Jawaban::where('id','=',$request->textid);
                        $modeljawaban->update([
                            'point' => $request->edittextbobot,
                            'jawaban' => $request->edittextjawaban,
                        ]);
                    }
                }
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                    'id' => $id,
                    'modelpertanyaan' => $modelpertanyaan
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
        Pertanyaan::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }

    public function getData($id)
    {
        $siswa = Pertanyaan::select('pertanyaan.id', 'pertanyaan.pertanyaan', 'pertanyaan.tipe_pertanyaan')->where('pertanyaan.quiz_id', '=', $id)
            ->get();

        return DataTables::of($siswa)->make(true);
    }

    public function jawabandelete($id)
    {
        Jawaban::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }
}
