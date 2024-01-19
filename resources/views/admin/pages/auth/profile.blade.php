@extends('admin.master')
@section('title', "Thông tin cá nhân")
@section('style')
<style>

</style>
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thông tin cá nhân</h1>
    <!-- <a href="{{route('cp-admin.category.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> Danh mục</a> -->
</div>
<div class="row col-12 d-sm-flex align-items-center justify-content-between">
    <div class="card shadow mb-4 col-7">
        <div class="card-body">
            <div class="table-responsive">
                <form class="user" action="{{ route('cp-admin.profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="mt-3 " style="width: 100%; height: 100px; text-align: center; display: block; " id="imgavatar1">
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" style="width: 100px; height: 100%;  border-radius: 50%; border: 2px solid #a1a1a1;" alt="{{auth()->user()->fullname}}">
                        </div>
                        <div class="mt-3 " style="width: 100%; height: 100px; text-align: center; display: none; " id="imgavatar2">
                            <img style="width: 100px; height: 100%;  border-radius: 50%; border: 2px solid #a1a1a1;" id="previewimgavatar" alt="">
                        </div>
                        <input onchange="previewFile(this)" id="avatar_image" type="file" id="image" name="avatar" class="form-control" require>
                        @error('avatar')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    @if(auth()->user()->role_id == 3)
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên cửa hàng</label>
                        <input type="text" value="{{auth()->user()->groupUser->name}}" name="shopName" disabled class="form-control form-control-user">
                        @error('shopName')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="exampleInputEmail1">Họ và tên</label>
                        <input type="text" value="{{auth()->user()->fullname}}" name="fullname" class="form-control form-control-user">
                        @error('fullname')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="text" value="{{auth()->user()->email}}" disabled class="form-control form-control-user">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Số điện thoại</label>
                        <input type="text" value="{{auth()->user()->phone}}" name="phone" class="form-control form-control-user">
                        @error('phone')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Địa chỉ chi tiết</label>
                        <input type="text" value="{{auth()->user()->address_detail}}" name="address_detail" class="form-control form-control-user">
                        @error('address_detail')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4 col-4" style="    margin-top: -13rem !important;">
        <div class="card-body">
            <div class="table-responsive">
                <form class="user" action="{{ route('cp-admin.changePassword') }}" method="POST">
                    @csrf
                    <div class="form-group" style=" text-align: center; ">
                        <h1>Đổi mật khẩu</h1>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mật khẩu hiện tại</label>
                        <input type="text" name="current_password" class="form-control form-control-user">
                        @error('current_password')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mật khẩu mới</label>
                        <input type="text" name="new_password" class="form-control form-control-user">
                        @error('new_password')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mật khẩu xác nhận</label>
                        <input type="text" name="confirm_password" class="form-control form-control-user">
                        @error('confirm_password')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
@if(session('message'))
<script>
    swal("Hành động", " {!! session('message') !!}", "success", {
        button: "OK",
    })
</script>
@endif
@if(session('error'))
<script>
    swal("Hành động", " {!! session('error') !!}", "error", {
        button: "OK",
    })
</script>
@endif
<script src="{{asset('admin/js/slug.js')}}"></script>
<script>
    function previewFile(input) {
        var file = $("#avatar_image").get(0).files[0];
        $("#imgavatar2").css("display", "block");
        $("#imgavatar1").css("display", "none");
        console.log(file);
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $('#previewimgavatar').attr('src', reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
