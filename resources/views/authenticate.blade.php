@extends('layouts.admin')


@section('title')
  <title>Trang chủ</title>
@endsection



@section('content')
<form class=" col-md-6 mt-5 ml-4" action="{{ url('https://testhuy678.myshopify.com/admin/oauth/access_token') }}" method="POST">
    @csrf
  <div class="form-group">
    <label for="exampleInputEmail1"></label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="client_id" value="{{ $api_key }}">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1"></label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="client_secret" value="{{ $api_secret }}">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1"></label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="code" value="{{ $code }}">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection