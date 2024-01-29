<div class="white-container" data-quiz-id="{{ $quiz[0]->quiz_id }}" data-jadwal="{{ $quiz[0]->jadwal }}">
    @php $questionNum = $quiz->firstItem(); @endphp
    @php $choicenum = 1; @endphp
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
                    <input type="radio" name="optionsRadios[{{$questionNum}}]" id="optionsRadios{{ $choicenum++ }}" value="{{$jawaban->id}}" onclick="handleClick(this,'<?= $jawaban->pertanyaan_id; ?>','<?= $data->jadwal; ?>');" <?php if (hasilPilihan($jawaban['id'], Auth::user()->id, $data->jadwal)) echo 'checked' ?>>
                    <span class="hover-effect">{{$jawaban->jawaban}}</span>
                </label>
            </div>
        </li>
        @endif
        @if($data->tipe_pertanyaan == "Teks")
        <div class="input-group">
            <textarea name="textjawaban" id="textjawaban{{$jawaban->id}}" data-jawaban-id="{{$jawaban->id}}" data-pertanyaan-id="{{$jawaban->pertanyaan_id}}" data-jadwal-id="{{$data->jadwal}}" cols="30" rows="10" class="form-control col-md-12" data-cek="<?= cekhasilText($jawaban->id, Auth::user()->id, $data->jadwal) ?>"><?= hasilText($jawaban->id, Auth::user()->id, $data->jadwal) ?></textarea>
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
            <button class="btn btn-outline-primary btn-icon btn-icon-end sw-25 w-50" onclick="finishAndClearCookies()">
                <span>Finish</span>
            </button>
        </div>
    </div>
    @endif
</div>
<div class="pagination-container">
    {!! $quiz->onEachSide(1)->links() !!}
</div>