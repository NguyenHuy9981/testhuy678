@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <!-- Main content -->
    <form action="{{ route('updateProduct_UpShopify', $product->id_product_shopify) }}" method="POST" enctype="multipart/form-data">
        <div class="content">
            <div class="row">
                <div class="col-md-6">

                    @csrf
                    <div class="form-group">
                        <label>Tên sản phẩm</label>
                        <input type="text" value="{{ $product->title }}" class="form-control" id="exampleInputEmail1" name="title" placeholder="Nhập tên sản phẩm">
                        @error('title')
                        <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01" name="image">
                            <label class="custom-file-label" for="inputGroupFile01">Chọn file ảnh</label>
                        </div>
                        @error('image')
                        <div class="form-text text-danger ml-4">{{ $message }}</div>
                        @enderror
                    </div>
                    <img class="m-2" src="{{ url($product->image) }}" alt="" style="width: 100px;">


                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="Textarea1">Mô tả</label>
                        <textarea class="form-control Tiny-mce" id="Textarea1" rows="20" name="description">{{ $product->description }}</textarea>
                        @error('description')
                        <div div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </div>
        </div>
    </form>

    <!-- /.main-content -->
</div>

@endsection