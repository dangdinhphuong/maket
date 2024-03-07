@extends('admin.master')
@section('title', "Têm danh mục")
@section('style')
<style>

</style>
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh mục sản phẩm</h1>
    <a href="{{route('cp-admin.category.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> Danh mục</a>
</div>

<div class="card shadow mb-4 ">
    <div class="card-body">
        <div class="table-responsive">
            <form class="user" action="{{route('cp-admin.category.update',[ 'id' => $category->id ])}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="nameCategories">Tên danh mục</label>
                        <input type="text" class="form-control form-control-user" id="nameCate" onchange="ChangeToSlug('nameCate','slugs')" value="{{ $category->nameCate }}" name="nameCate" id="nameCategories" placeholder="Tên danh mục ...">
                        @error('nameCate')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="slugCategories">Slug danh mục</label>
                        <input type="text" class="form-control form-control-user " id="slugs" value="{{ $category->slug }}" name="slug" id="slugCategories" placeholder="Slug danh mục ...">
                        @error('slug')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="image">Banner</label>
                        <input onchange="previewFile(this)" id="product_image" type="file" id="image" name="banner" class="form-control" require>
                        <div class="d-flex justify-content-start">
                            <div class="mt-3" style="width: 45%; border: 1px solid gray; background-color: pink !important;text-align: center;">
                                <img style="width: 100%; height: 100%;" src="{{ asset("storage/$category->banner") }}" alt=" Anh cũ">
                            </div>
                            <div class="mt-3" style="font-size: 100px">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            <div class="mt-3" style="width: 45%; height: 200px; border: 1px solid gray ; background-color: pink !important;text-align: center;">
                                <img style="width: 100%; height: 100%;" id="previewimg" alt=" Anh mới">
                            </div>
                        </div>
                        @error('banner')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                        @enderror
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
<script>
    function previewFile(input) {
        var file = $("#product_image").get(0).files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $('#previewimg').attr('src', reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection