<div class="white-container" data-quiz-id="{{ $quiz[0]->quiz_id }}" data-jadwal="{{ $quiz[0]->jadwal }}">
    @php $questionNum = $quiz->firstItem(); @endphp
    @php $choicenum = 1; @endphp
    @if(strpos($kategori->nama_kategori, "Reading") !== false)
    <div class="row">
        <div class="col">
            <div class="question-boxes" id="question-boxes">
                @foreach($kotakquiz as $data)
                <?php
                $questionNumm = $loop->iteration;
                if ($data->tipe_pertanyaan == "Pilihan") {
                    $isAnswered = cekhasilPilihan($data->id, Auth::user()->id, $data->jadwal);
                } elseif ($data->tipe_pertanyaan == "Teks") {
                    $isAnswered = cekhasilTeks($data->id, Auth::user()->id, $data->jadwal);
                } elseif ($data->tipe_pertanyaan == "Blank_Teks") {
                    $isAnswered = cekhasilBlank($data->id, Auth::user()->id, $data->jadwal);
                } else {
                    $isAnswered = "";
                }
                ?>
                <div class="question-box @if($isAnswered) bg-success @else bg-light @endif" onclick="goToQuestion({{ $questionNumm }})" data-pertanyaan-id="{{$data->id}}">
                    {{ $questionNumm }}
                </div>
                @endforeach
            </div>

            @foreach($quiz as $key => $data)
            <h4 hidden>{{$questionNum}}</h4>
            <!-- <h4 class="mt-3">Soal {{$questionNum++}}</h4> -->
            <?php
                $rumpang  = $data->pertanyaan;
            ?>
            @foreach($pilihan[$key] as $jawaban)
            <?php
                $hasilText = hasilText($jawaban->id, Auth::user()->id, $data->jadwal);
                $rumpang = str_replace($jawaban->jawaban, '<input name="jawaban" id="jawaban'. $jawaban->id. '" placeholder="Isi jawaban" class="blank" data-jawaban-id="' . $jawaban->id . '" data-pertanyaan-id="' . $jawaban->pertanyaan_id . '" oninput="textSavedata(this,'.$jawaban->id.','. $jawaban->pertanyaan_id .','. $data->jadwal .','. Auth::user()->id .')" value="'.$hasilText.'"/>', $rumpang);
            ?>
            @endforeach
            @if($data->tipe_pertanyaan == "Blank_Teks")
            <p>{!! $rumpang !!}</p>
            @else
            <p>{!! $data->pertanyaan !!}</p>
            @endif
            <ul class="list-group">
                @foreach($pilihan[$key] as $jawaban)
                @if($data->tipe_pertanyaan == "Pilihan")
                <li class="list-group-item">
                    <div class="radio" id="radioWrapper{{ $choicenum }}">
                        <label>
                            <input type="radio" name="optionsRadios[{{$questionNum}}]" id="optionsRadios{{ $choicenum++ }}" value="{{$jawaban->id}}" onclick="handleClick(this,'<?= $jawaban->pertanyaan_id; ?>','<?= $data->jadwal; ?>');" <?php if (hasilPilihan($jawaban['id'], Auth::user()->id, $data->jadwal)) echo 'checked' ?>>
                            <span class="hover-effect">{{$jawaban->jawaban}}</span>
                        </label>
                    </div>
                </li>
                @endif
                @if($data->tipe_pertanyaan == "Teks")
                <div class="input-group">
                    <textarea name="textjawaban" id="textjawaban{{$jawaban->id}}" data-jawaban-id="{{$jawaban->id}}" data-pertanyaan-id="{{$jawaban->pertanyaan_id}}" data-jadwal-id="{{$data->jadwal}}" cols="30" rows="10" class="form-control col-md-12" data-cek=""><?= hasilText($jawaban->id, Auth::user()->id, $data->jadwal) ?></textarea>
                </div>
                <div>
                    <p id="wordCount{{$jawaban->id}}">Jumlah kata: 0</p>
                    <input type="hidden" name="textid" value="{{$jawaban->id}}">
                </div>
                @endif
                @if($data->tipe_pertanyaan == "Blank_Teks")
                <!-- <div class="input-group">
                    <textarea name="textjawaban" id="textjawaban{{$jawaban->id}}" data-jawaban-id="{{$jawaban->id}}" data-pertanyaan-id="{{$jawaban->pertanyaan_id}}" data-jadwal-id="{{$data->jadwal}}" cols="30" rows="10" class="form-control col-md-12" data-cek=""><?= hasilText($jawaban->id, Auth::user()->id, $data->jadwal) ?></textarea>
                </div>
                <div>
                    <p id="wordCount{{$jawaban->id}}">Jumlah kata: 0</p>
                    <input type="hidden" name="textid" value="{{$jawaban->id}}">
                </div> -->
                @endif
                @endforeach
            </ul>
            @endforeach
            @if($quiz->currentPage() == $quiz->lastPage())
            <div class="row" style="margin-top: 20px;">
                <div class="col-12 text-center">
                    <button class="btn btn-outline-primary btn-icon btn-icon-end sw-25 w-50" onclick="finishAndClearCookies()">
                        <span>Finish</span>
                    </button>
                </div>
            </div>
            @endif
            <div class="pagination-container mt-2">
                {!! $quiz->onEachSide(1)->links() !!}
            </div>
        </div>
    </div>
    @else
    <div class="question-boxes" id="question-boxes">
        @foreach($kotakquiz as $data)
        <?php
        $questionNumm = $loop->iteration;
        if ($data->tipe_pertanyaan == "Pilihan") {
            $isAnswered = cekhasilPilihan($data->id, Auth::user()->id, $data->jadwal);
        } elseif ($data->tipe_pertanyaan == "Teks") {
            $isAnswered = cekhasilTeks($data->id, Auth::user()->id, $data->jadwal);
        } elseif ($data->tipe_pertanyaan == "Blank_Teks") {
            $isAnswered = cekhasilBlank($data->id, Auth::user()->id, $data->jadwal);
        }
        ?>
        <div class="question-box @if($isAnswered) bg-success @else bg-light @endif" onclick="goToQuestion({{ $questionNumm }})" data-pertanyaan-id="{{$data->id}}">
            {{ $questionNumm }}
        </div>
        @endforeach
    </div>

    @foreach($quiz as $key => $data)
    <h4 hidden>{{$questionNum}}</h4>
    <!-- <h4 class="mt-3">Soal {{$questionNum++}}</h4> -->
    <?php
    $rumpang  = $data->pertanyaan;
    ?>
    @foreach($pilihan[$key] as $jawaban)
    <?php
    $hasilText = hasilText($jawaban->id, Auth::user()->id, $data->jadwal);
    $rumpang = str_replace($jawaban->jawaban, '<input name="jawaban" id="jawaban'. $jawaban->id. '" placeholder="Isi jawaban" class="blank" data-jawaban-id="' . $jawaban->id . '" data-pertanyaan-id="' . $jawaban->pertanyaan_id . '" oninput="textSavedata(this,'.$jawaban->id.','. $jawaban->pertanyaan_id .','. $data->jadwal .','. Auth::user()->id .')" value="'.$hasilText.'"/>', $rumpang);
    ?>
    @endforeach
    @if($data->tipe_pertanyaan == "Blank_Teks")
    <p>{!! $rumpang !!}</p>
    @else
    <p>{!! $data->pertanyaan !!}</p>
    @endif
    <ul class="list-group">
        @foreach($pilihan[$key] as $jawaban)
        @if($data->tipe_pertanyaan == "Pilihan")
        <li class="list-group-item">
            <div class="radio" id="radioWrapper{{ $choicenum }}">
                <label>
                    <input type="radio" name="optionsRadios[{{$questionNum}}]" id="optionsRadios{{ $choicenum++ }}" value="{{$jawaban->id}}" onclick="handleClick(this,'<?= $jawaban->pertanyaan_id; ?>','<?= $data->jadwal; ?>');" <?php if (hasilPilihan($jawaban['id'], Auth::user()->id, $data->jadwal)) echo 'checked' ?>>
                    <span class="hover-effect">{{$jawaban->jawaban}}</span>
                </label>
            </div>
        </li>
        @endif
        @if($data->tipe_pertanyaan == "Teks")
        <div class="input-group">
            <textarea name="textjawaban" id="textjawaban{{$jawaban->id}}" data-jawaban-id="{{$jawaban->id}}" data-pertanyaan-id="{{$jawaban->pertanyaan_id}}" data-jadwal-id="{{$data->jadwal}}" cols="30" rows="10" class="form-control col-md-12" data-cek=""><?= hasilText($jawaban->id, Auth::user()->id, $data->jadwal) ?></textarea>
        </div>
        <div>
            <p id="wordCount{{$jawaban->id}}">Jumlah kata: 0</p>
            <input type="hidden" name="textid" value="{{$jawaban->id}}">
        </div>
        @endif
        @if($data->tipe_pertanyaan == "Blank_Teks")
                <!-- <div class="input-group">
                    <textarea name="textjawaban" id="textjawaban{{$jawaban->id}}" data-jawaban-id="{{$jawaban->id}}" data-pertanyaan-id="{{$jawaban->pertanyaan_id}}" data-jadwal-id="{{$data->jadwal}}" cols="30" rows="10" class="form-control col-md-12" data-cek=""><?= hasilText($jawaban->id, Auth::user()->id, $data->jadwal) ?></textarea>
                </div>
                <div>
                    <p id="wordCount{{$jawaban->id}}">Jumlah kata: 0</p>
                    <input type="hidden" name="textid" value="{{$jawaban->id}}">
                </div> -->
        @endif
        @endforeach
    </ul>
    @endforeach
    @if($quiz->currentPage() == $quiz->lastPage())
    <div class="row" style="margin-top: 20px;">
        <div class="col-12 text-center">
            <button class="btn btn-outline-primary btn-icon btn-icon-end sw-25 w-50" onclick="finishAndClearCookies()">
                <span>Finish</span>
            </button>
        </div>
    </div>
    @endif
    <div class="pagination-container mt-2">
        {!! $quiz->onEachSide(1)->links() !!}
    </div>
    @endif
</div>