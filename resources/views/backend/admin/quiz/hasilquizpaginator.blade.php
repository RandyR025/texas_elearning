<div class="white-container">
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
                    <input type="radio" name="optionsRadios[{{$questionNum}}]" id="optionsRadios{{ $choicenum++ }}" value="{{$jawaban->id}}" <?php if (hasilPilihan($jawaban['id'], $modelhasilquiz->user_id, $data->jadwal)) echo 'checked' ?>>
                    <span class="hover-effect">{{$jawaban->jawaban}}</span>
                </label>
            </div>
        </li>
        @endif
        @if($data->tipe_pertanyaan == "Teks")
        <div class="input-group">
            <textarea name="textjawaban" id="textjawaban{{$jawaban->id}}" data-jawaban-id="{{$jawaban->id}}" cols="30" rows="10" class="form-control col-md-12"><?= hasilText($jawaban->id, $modelhasilquiz->user_id,$data->jadwal)?></textarea>
        </div>
        <div>
            <p id="wordCount{{$jawaban->id}}">Jumlah kata: 0</p>
            <input type="hidden" name="textid" value="{{$jawaban->id}}">
        </div>
        @endif
        @endforeach
    </ul>
    @if($jumlahsoal == $quiz->firstItem())
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
    @endforeach
</div>
<div class="pagination-container">
    {!! $quiz->onEachSide(1)->links() !!}
</div>