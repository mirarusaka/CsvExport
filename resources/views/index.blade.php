@extends('layouts.app')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<script src="{{ mix('css/app.css') }}" defer></script>
@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/l10n/ja.js" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{ asset('js/index.js') }}" defer></script>
<script src="{{ asset('js/modal.js') }}" defer></script>
@endsection

@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">建築物条件</th>
      <th scope="col">建築物デザイン</th>
      <th scope="col">名前</th>
      <th scope="col">住所</th>
      <th scope="col">電話番号</th>
      <th scope="col">Fax</th>
    </tr>
  </thead>
  <tbody class="table-stripes-row-tbody">
  @foreach($contacts as $c)
    <tr>
      <td>{{ $c->id }}</td>
      <td>{{ $c->condition_name }}</td>
      <td>{{ $c->design_name }}</td>
      <td>{{ $c->surname }}{{ $c->name }}</td>
      <td>{{ $c->zipcode }}<br>{{ $c->pref }}{{ $c->city }}{{ $c->street }}</td>
      <td>{{ $c->tel_number }}</td>
      <td>{{ $c->fax_number }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
<div class="btn btn-primary modal-open">データ入力</div>
<div class="btn btn-primary modal-open">データ出力</div>

<!-- remodal -->
<div class="modal-container">
    <div class="modal-body">
        <div class="modal-close">×</div>
        <div class="modal-content">
            <form id='csvform' action="{{ route('contact.csv.export') }}" method="POST">
                @csrf
                <div class='row mb-3'>
                <div class="col-md-5">
                    <label class='h4'>エクスポートの開始日</label>
                </div>
                <div class="col-md-2 h2 d-flex justify-content-center align-items-center"></div>
                <div class="col-md-5">
                    <label class='h4'>エクスポートの終端日</label>
                </div>
                </div> <!-- row -->
                <div class='row mb-3'>
                <!--datepicker-->
                <div class="col-md-5">
                    <input data-provide="datepicker" class="form-control datepicker js-start-date" type="datetime"
                    placeholder="出力開始日" name="start_date" value="" dusk='datepicker_first'>
                </div>
                <div class="col-md-2 h2 d-flex justify-content-center align-items-center">
                    〜
                </div>
                <div class="col-md-5">
                    <input data-provide="datepicker" class="form-control datepicker js-end-date" type="datetime" placeholder="出力終了日"
                    name="end_date" value="" dusk='datepicker_last'>
                </div>
                </div> <!-- row -->

                <button data-remodal-action="cancel" class="btn btn-secondary">キャンセル</button>
                <button type='submit' class="btn btn-primary">ダウンロード</button>
            </form>
        </div>
    </div>
</div> <!-- remodal -->
@endsection
