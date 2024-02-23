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
use App\Models\Tentor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class QuizTentorController extends Controller
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
        return view('backend/tentor.quiz', compact('modelkategori', 'modeltentor'));
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
            $modelquiz->user_id = json_encode([strval(Auth::user()->id)]);
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
        return view('backend/tentor.pertanyaan', compact('modelquiz'));
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
                }elseif ($request->hasFile('editaudio_quiz')) {
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
        $user_id = Auth::user()->id;
        $siswa = Quiz::select('quiz.id', 'quiz.judul_quiz', 'quiz.kategori_id', 'quiz_kategori.nama_kategori', 'quiz_kategori.deskripsi')
            ->join('quiz_kategori', 'quiz.kategori_id', '=', 'quiz_kategori.id')
            ->where(function ($query) use ($user_id) {
                $query->whereJsonDoesntContain('quiz.user_id', 'Default')
                    ->where(function ($subquery) use ($user_id) {
                        $subquery->whereJsonContains('quiz.user_id', (string) $user_id)
                            ->orWhereJsonContains('quiz.user_id', json_encode([$user_id]))
                            ->orWhereJsonContains('quiz.user_id', ["all"]);
                    });
            })
            ->get();


        return DataTables::of($siswa)->make(true);
    }
}
