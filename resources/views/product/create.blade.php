@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <!-- Main content -->
    <form action="{{ route('createProduct_UpShopify') }}" method="POST">
        <div class="content">
            <div class="row">
                <div class="col-md-6">

                    @csrf
                    <div class="form-group">
                        <label>Tên sản phẩm</label>
                        <input type="text" value="" class="form-control" id="exampleInputEmail1" name="title" placeholder="Nhập tên sản phẩm">
                        @error('name')
                        <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="Textarea1">Nhập nội dung</label>
                        <textarea class="form-control Tiny-mce" id="Textarea1" rows="20" name="description"></textarea>
                        @error('content')
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