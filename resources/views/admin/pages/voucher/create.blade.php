@extends('admin.master')
@section('title', "Mã giảm")
@section('style')
<style>

</style>
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Mã giảm sản phẩm</h1>
    <a href="{{route('cp-admin.category.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> Danh mục</a>
</div>

<div class="card shadow mb-4 ">
    <div class="card-body">
        <div class="table-responsive">
            <form class="user" action="{{ route('cp-admin.voucher.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-12 mb-3 mb-sm-0">
                        <label for="nameCategories">Mã giảm <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control form-control-user" id="code"  value="{{ old('code') }}" name="code" id="nameCategories" placeholder="Mã giảm ...">
                        @error('code')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="nameCategories">Mã giảm giá gắn với sản phẩm <span class="text-danger">(*)</span></label>
                        <select class="form-control form-control-sm products_id" id="products_id" name="products_id[]" multiple>
                            <option value="0" price="0">-- Chọn Gói sản phẩm --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" price="0">{{ $product->namePro }}</option>
                            @endforeach
                        </select>

                        @error('products_id')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="image">Thời gian bắt đầu <span class="text-danger">(*)</span></label>
                        <input type="datetime-local" name="time_start" class="form-control"placeholder="Thời gian bắt đầu">

                        @error('time_start')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="image">Thời gian Kết thúc <span class="text-danger">(*)</span></label>
                        <input type="datetime-local" name="time_end" class="form-control"placeholder="Thời gian Kết thúc">

                        @error('time_end')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <div class="col-sm-4">
                        <label for="slugCategories">Trạng thái<span class="text-danger">(*)</span></label>
                            <select class="custom-select" name="active" id="inputGroupSelect01">
                                <option selected value="1">Đang hoạt động</option>
                                <option value="0">Ngưng hoạt động</option>
                            </select>
                            @error('active')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="slugCategories">Số lượng <span class="text-danger">(*)</span></label>
                            <input type="number" name="number_sale" class="form-control"placeholder="Số lượng">
                                @error('number_sale')<span class="text-danger">{{$message}}</span>@enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="slugCategories">Giảm giá<span class="text-danger">(*)</span></label>
                                <input type="number" name="discount_percent" class="form-control"placeholder="Giảm giá" min="0">
                                    @error('discount_percent')<span class="text-danger">{{$message}}</span>@enderror
                                </div>

                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">Lưu lại</button>
            </form>
        </div>
    </div>
</div>

@endsection
@section('javascript')
<script src="{{asset('admin/js/slug.js')}}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
<script>
     $('.products_id').select2();
     $(document).ready(function () {
        // Function to check if end time is greater than start time
        function istime_endValid() {
            var time_start = new Date($('input[name="time_start"]').val());
            var time_end = new Date($('input[name="time_end"]').val());

            return time_end > time_start;
        }

        // Function to check if both start and end times are greater than current time
        function isCurrentTimeValid() {
            var currentTime = new Date();
            var time_start = new Date($('input[name="time_start"]').val());
            var time_end = new Date($('input[name="time_end"]').val());

            return time_start > currentTime && time_end > currentTime;
        }

        // Validate on input change
        $('input[name="time_start"], input[name="time_end"]').on('input', function () {
            if (!istime_endValid() || !isCurrentTimeValid()) {
                alert('Invalid date/time selection. Please make sure the end time is greater than the start time, and both are greater than the current time.');
                // You can also disable form submission or show error messages as needed
            }
        });
    });

</script>
@endsection
