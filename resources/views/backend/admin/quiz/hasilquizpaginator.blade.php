<div class="white-container" data-quiz-id="{{ $quiz[0]->quiz_id }}" data-jadwal="{{ $quiz[0]->jadwal }}">
    @php $questionNum = $quiz->firstItem(); @endphp
    @php $choicenum = 1; @endphp
    @if(strpos($kategori->nama_kategori, "Reading") !== false)
    <div class="row">
        <div class="col-md-8">
            @foreach($custom_banner as $data)
            <div class="card card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">{{$data->jawaban}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" id="coba">
                    {!! $data->pertanyaan !!}
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-4">
            <div class="question-boxes" id="question-boxes">
                @foreach($kotakquiz as $data)
                <?php
                $questionNumm = $loop->iteration;
                if ($data->tipe_pertanyaan == "Pilihan") {
                    $isAnswered = cekhasilPilihanAkhir($data->id, $modelhasilquiz->user_id, $data->jadwal);
                } elseif ($data->tipe_pertanyaan == "Teks") {
                    $isAnswered = cekhasilTeks($data->id, $modelhasilquiz->user_id, $data->jadwal);
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
            <h4 class="mt-3">Soal {{$questionNum++}}</h4>
            <p>{!! $data->pertanyaan !!}</p>
            <ul class="list-group">
                @foreach($pilihan[$key] as $jawaban)
                @if($data->tipe_pertanyaan == "Pilihan")
                <li class="list-group-item">
                    <div class="radio" id="radioWrapper{{ $choicenum }}">
                        <label>
                            <input type="radio" name="optionsRadios[{{$questionNum}}]" id="optionsRadios{{ $choicenum++ }}" value="{{$jawaban->id}}" <?php if (hasilPilihan($jawaban['id'], $modelhasilquiz->user_id, $data->jadwal)) echo 'checked' ?>>
                            <span class="hover-effect" <?php if (hasilPilihan($jawaban['id'], $modelhasilquiz->user_id, $data->jadwal) && $jawaban->point == 0) echo 'style="color: red;"';
                                                        else if (hasilPilihan($jawaban['id'], $modelhasilquiz->user_id, $data->jadwal) && $jawaban->point == 1) echo 'style="color: green;"';
                                                        else if ($jawaban->point == 1) echo 'style="color: green;"' ?>>{{$jawaban->jawaban}}</span>
                        </label>
                    </div>
                </li>
                @endif
                @if($data->tipe_pertanyaan == "Teks")
                <div class="input-group">
                    <textarea name="textjawaban" id="textjawaban{{$jawaban->id}}" data-jawaban-id="{{$jawaban->id}}" cols="30" rows="10" class="form-control col-md-12"><?= hasilText($jawaban->id, $modelhasilquiz->user_id, $data->jadwal) ?></textarea>
                </div>
                <div>
                    <p id="wordCount{{$jawaban->id}}">Jumlah kata: 0</p>
                    <input type="hidden" name="textid" value="{{$jawaban->id}}">
                </div>
                @endif
                @endforeach
            </ul>
            @endforeach
            @if($quiz->currentPage() == $quiz->lastPage())
            <div class="row" style="margin-top: 20px;">
                <div class="col-12 text-center">
                    <a href="{{ route('datahasilquiz.data.detail', [$modelhasilquiz->jadwal_id])}}">
                        <button class="btn btn-outline-primary btn-icon btn-icon-end sw-25 w-50">
                            <span>Kembali</span>
                        </button>
                    </a>
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
            $isAnswered = cekhasilPilihanAkhir($data->id, $modelhasilquiz->user_id, $data->jadwal);
        } elseif ($data->tipe_pertanyaan == "Teks") {
            $isAnswered = cekhasilTeks($data->id, $modelhasilquiz->user_id, $data->jadwal);
        } else {
            $isAnswered = "";
        }
        ?>
        <div class="question-box @if($isAnswered) bg-success @else bg-danger @endif" onclick="goToQuestion({{ $questionNumm }})" data-pertanyaan-id="{{$data->id}}">
            {{ $questionNumm }}
        </div>
        @endforeach
    </div>
    @foreach($quiz as $key => $data)
    <h4 hidden>{{$questionNum}}</h4>
    <h4 class="mt-3">Soal {{$questionNum++}}</h4>
    <p>{!! $data->pertanyaan !!}</p>
    <ul class="list-group disabled">
        @foreach($pilihan[$key] as $jawaban)
        @if($data->tipe_pertanyaan == "Pilihan")
        <li class="list-group-item">
            <div class="radio" id="radioWrapper{{ $choicenum }}">
                <label>
                    <input disabled type="radio" name="optionsRadios[{{$questionNum}}]" id="optionsRadios{{ $choicenum++ }}" value="{{$jawaban->id}}" <?php if (hasilPilihan($jawaban['id'], $modelhasilquiz->user_id, $data->jadwal)) echo 'checked' ?>>
                    <span class="hover-effect" <?php if (hasilPilihan($jawaban['id'], $modelhasilquiz->user_id, $data->jadwal) && $jawaban->point == 0) echo 'style="color: red;"';
                                                else if (hasilPilihan($jawaban['id'], $modelhasilquiz->user_id, $data->jadwal) && $jawaban->point == 1) echo 'style="color: green;"';
                                                else if ($jawaban->point == 1) echo 'style="color: green;"' ?>>{{$jawaban->jawaban}}</span>
                </label>
            </div>
        </li>
        @endif
        @if($data->tipe_pertanyaan == "Teks")
        <div class="input-group">
            <textarea disabled name="textjawaban" id="textjawaban{{$jawaban->id}}" data-jawaban-id="{{$jawaban->id}}" cols="30" rows="10" class="form-control col-md-12"><?= hasilText($jawaban->id, $modelhasilquiz->user_id, $data->jadwal) ?></textarea>
        </div>
        <div>
            <p id="wordCount{{$jawaban->id}}">Jumlah kata: 0</p>
            <input type="hidden" name="textid" value="{{$jawaban->id}}">
        </div>
        @endif
        @endforeach
    </ul>
    @endforeach
    @if($quiz->currentPage() == $quiz->lastPage())
    <div class="row" style="margin-top: 20px;">
        <div class="col-12 text-center">
            <a href="{{ route('datahasilquiz.data.detail', [$modelhasilquiz->jadwal_id])}}">
                <button class="btn btn-outline-primary btn-icon btn-icon-end sw-25 w-50">
                    <span>Kembali</span>
                </button>
            </a>
        </div>
    </div>
    @endif
    <div class="pagination-container">
        {!! $quiz->onEachSide(1)->links() !!}
    </div>
    @endif
</div>