@extends('layouts.app')

@section('content')
<h1>Tên shop: {{ $shop->name }}</h1>
<form class="col-md-12" action="{{ route('createWebhook') }}" method="POST">
  <button class="btn btn-primary float-right m-2 mb-2" type="submit">Kích hoạt đồng bộ sản phẩm Shopify</button>
  <input value="{{ $shop_token }}" name="access_token" type="hidden">
</form>
<table class="table">

  <thead>
    <tr>
      <th scope="col">Tên sản phẩm</th>
      <th scope="col">Mô tả</th>
      <th scope="col">Hình ảnh</th>
      <th scope="col">Action</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      @foreach($products as $product)
      <td>{{ $product->title }}</td>
      <td>{{ $product->description }}</td>
      <td>
        <img class="width-height" src="{{ $product->image }}" alt="" style="width: 100px; height: 100px">
      </td>
      <td>
        <a href="" class="btn btn-success">Sửa</a>

        <a href="" data-url="" class="btn btn-danger action_delete">Xóa</a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>


@endsection