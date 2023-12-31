<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kursus;
use App\Models\Level;
use App\Models\Siswa;
use App\Models\Tentor;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modellevel = Level::all();
        $modelkelas = Kelas::all();
        $modelkursus = Kursus::all();
        return view('backend/admin.datauser', compact('modellevel', 'modelkursus', 'modelkelas'));
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
            'username' => 'required|unique:users',
            'password' => 'required',
            'level' => 'required',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modeluser = new User();
            $modeluser->username = $request->input('username');
            $modeluser->password = Hash::make($request->password);
            $modeluser->level_id = $request->input('level');
            $modeluser->save();
            if ($request->input('level') == 1) {
                $modeladmin = new Tentor;
                $modeladmin->nama = $request->input('nama');
                $modeladmin->user_id = $modeluser->id;
                $modeladmin->save();
            } elseif ($request->input('level') == 2) {
                $modeltentor = new Tentor;
                $modeltentor->nama = $request->input('nama');
                $modeltentor->tanggal_lahir = $request->input('tanggal_lahir');
                $modeltentor->alamat = $request->input('alamat');
                $modeltentor->no_telp = $request->input('no_telp');
                $modeltentor->kursus_id = $request->input('kursus');
                $modeltentor->user_id = $modeluser->id;
                $modeltentor->save();
            } elseif ($request->input('level') == 3) {
                $modelsiswa = new Siswa;
                $modelsiswa->nama = $request->input('nama');
                $modelsiswa->tanggal_lahir = $request->input('tanggal_lahir');
                $modelsiswa->alamat = $request->input('alamat');
                $modelsiswa->no_telp = $request->input('no_telp');
                $modelsiswa->kelas_id = $request->input('kelas');
                $modelsiswa->kursus_id = $request->input('kursus');
                $modelsiswa->user_id = $modeluser->id;
                $modelsiswa->save();
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
        $modeluser = User::find($id);
        if ($modeluser) {
            return response()->json([
                'status' => 200,
                'modeluser' => $modeluser,
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
            'editusername' => 'required',
            'editlevel' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $modeluser = User::find($id);
            if ($modeluser) {
                if ($request->editpassword) {
                    $modeluser->update([
                        'username' => $request->input('editusername'),
                        'password' => Hash::make($request->editpassword),
                        'level_id' => $request->input('editlevel'),
    
    
                    ]);
                }else {
                    $modeluser->update([
                        'username' => $request->input('editusername'),
                        'level_id' => $request->input('editlevel'),
                    ]);
                }
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                    'id' => $id,
                    'modeluser' => $modeluser
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
        User::find($id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }

    public function getData()
    {
        $siswa = User::select('users.id', 'users.username', 'users.level_id', 'level.level')
            ->join('level', 'users.level_id', '=', 'level.id')
            ->get();

        return DataTables::of($siswa)->make(true);
    }
}
