@extends('layouts.admin')


@section('title')
<title>Trang chủ</title>
@endsection



@section('content')
<form class=" col-md-6 mt-5 ml-4" action="{{ route('store') }}" method="POST">
  @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Nhập tên shop</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="shop_name">
    @error('shop_name')
    <div class="form-text text-danger">{{ $message }}</div>
    @enderror
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection

<!-- @section('scripts')

<script>
    var AppBridge = window['app-bridge'];
    var actions = AppBridge.actions;
    var TitleBar = actions.TitleBar;
    var Button = actions.Button;
    var Redirect = actions.Redirect;
    var titleBarOptions = {
        title: 'Welcome'
    }
    var myTitleBar = TitleBar.create(app, titleBarOptions);

</script>

@endsection -->