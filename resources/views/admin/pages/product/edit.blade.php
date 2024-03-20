@extends('admin.master')
@section('title', 'Tạo Sản phẩm')
@section('style')
    <style>

    </style>
@endsection
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sản phẩm</h1>
        <a href="{{ route('cp-admin.products.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            Danh sách sản phẩm</a>
    </div>

    <div class="card shadow mb-4 ">
        <div class="card-body">
            <div class="table-responsive">
                <form class="user" action="{{ route('cp-admin.products.update', ['id' => $Product->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="namePro">Tên sản phẩm<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control form-control-user" id="namePro"
                                onchange="ChangeToSlug('namePro','slugs')" value="{{ $Product->namePro }}" name="namePro"
                                placeholder="Tên sản phẩm ...">
                            @error('namePro')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="slugCategories">Slug sản phẩm<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control form-control-user " id="slugs"
                                value="{{ $Product->slug }}" name="slug" id="slugCategories"
                                placeholder="Slug sản phẩm ...">
                            @error('slug')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <label for="quantity">Số lượng sản phẩm<span class="text-danger">(*)</span></label>
                            <input type="number" class="form-control form-control-user" id="quantity"
                                value="{{ $Product->quantity }}" name="quantity" id="quantity"
                                placeholder="Số lượng sản phẩm ...">
                            @error('quantity')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <label for="price">Giá gốc (đ)<span class="text-danger">(*)</span></label>
                            <input type="number" step="0.01" class="form-control form-control-user " id="price"
                                value="{{ $Product->cost }}" name="price" id="cost"
                                placeholder="Giá nhập sản phẩm ...">
                            @error('cost')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <label for="price">Giá bán (đ)<span class="text-danger">(*)</span></label>
                            <input type="number" step="0.01" class="form-control form-control-user " id="price"
                                value="{{ $Product->price }}" name="price" id="price"
                                placeholder="Giá tiền sản phẩm ...">
                            @error('price')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <label for="discounts">Giảm giá (%) <span class="text-danger">(*)</span></label>
                            <input type="number" class="form-control form-control-user " id="discounts" name="discounts"
                                value="{{ isset($Product->discounts) ? $Product->discounts : 0 }}" id="discounts"
                                placeholder="Giảm giá sản phẩm ...">
                            @error('discounts')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class=" col-sm-6 ">
                            <label for="slugCategories">Thuộc danh mục<span class="text-danger">(*)</span></label>
                            <select class="custom-select" name="category_id" id="inputGroupSelect01">
                                <option value="0" che>Choose...</option>
                                @foreach ($categoryAll as $cate)
                                    <option value="{{ $cate->id }}"
                                        {{ $Product->category_id == $cate->id ? 'selected' : '' }}>{{ $cate->nameCate }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class=" col-sm-6 ">
                            <label for="slugCategories">Nhà cung cấp<span class="text-danger">(*)</span></label>
                            <select class="custom-select" name="supplier_id" id="inputGroupSelect01">
                                <option>Choose...</option>
                                @foreach ($supplier as $cate)
                                    <option value="{{ $cate->id }}"
                                        {{ $Product->supplier_id == $cate->id ? 'selected' : '' }}>
                                        {{ $cate->nameSupplier }} {{ $cate->status == 1 ? ' ' : '(Ngưng cung cấp)' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class=" col-sm-6 ">
                            <label for="slugCategories">Nguồn gốc xuất xứ<span class="text-danger">(*)</span></label>
                            <select class="custom-select" name="origin_id" id="inputGroupSelect01">
                                <option>Choose...</option>
                                @foreach ($origin as $cate)
                                    <option value="{{ $cate->id }}"
                                        {{ $Product->origin_id == $cate->id ? 'selected' : '' }}>{{ $cate->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('origin_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="slugCategories">Trạng thái</label>
                            <select class="custom-select" name="status" id="inputGroupSelect01">
                                <option {{ $Product->status == 1 ? 'selected' : '' }} value="1">Đang hoạt động
                                </option>
                                <option {{ $Product->status == 0 ? 'selected' : '' }} value="0">Ngưng hoạt động
                                </option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0"><label for="slugCategories">Anh sản phẩm<span
                                    class="text-danger">(*)</span></label>
                            <input id="image" type="file" name="image[]" class="form-control" multiple
                                onchange="previewFile(this)">
                            <div class="d-flex justify-content-start">
                                @foreach ($Product->productImage->where('type', 1) as $productImage)
                                    <div class="mt-3"
                                        style="width: 100%; height: 200px; border: 1px solid gray; background-color: pink !important;text-align: center;">
                                        <img style="width: 100%; height: 100%;"
                                            src="{{ asset("storage/$productImage->image") }}" alt=" Anh cũ">
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3" style="font-size: 50px">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            <div class="d-flex justify-content-start previewFile"> </div>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class=" col-sm-12 ">
                            <label for="slugCategories">Mô tả sản phẩm</label>
                            <textarea class="form-control" name="Description" id="summernote" rows="10">{{ isset($Product->Description) ? $Product->Description : 0 }}</textarea>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('admin/js/slug.js') }}"></script>
    <script>
        function previewFile(input) {
            var files = $("#image").get(0).files;
            $('.previewFile').empty(); // Xóa tất cả các hình ảnh xem trước cũ trước khi thêm mới

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var html = `
                        <div class="mt-3" style="width: 20%; height: 200px; border: 1px solid gray; background-color: pink !important; text-align: center;">
                            <img style="width: 100%; height: 100%;" src="${e.target.result}">
                        </div>
                    `;
                    $('.previewFile').append(html); // Thêm hình ảnh xem trước mới vào

                    // Nếu bạn muốn chỉ giới hạn số lượng hình ảnh được xem trước, bạn có thể thêm điều kiện ở đây
                    // Ví dụ: if ($('.previewFile > div').length >= 5) { return; } // Giới hạn tối đa 5 hình ảnh
                }

                reader.readAsDataURL(files[i]);
            }
        }
    </script>


    <script>
        $(function() {
            // Summernote
            $('#summernote').summernote()
            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
@endsection
