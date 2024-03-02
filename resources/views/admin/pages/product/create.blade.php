@extends('admin.master')
@section('title', 'Tạo sản phẩm')
@section('style')
    <style>

    </style>
@endsection
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sản phẩm</h1>
        <a href="{{ route('cp-admin.products.index') }}"
           class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            Danh mục</a>
    </div>

    <div class="card shadow mb-4 ">
        <div class="card-body">
            <div class="table-responsive">
                <form class="user" action="{{ route('cp-admin.products.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="namePro">Tên sản phẩm<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control form-control-user" id="namePro"
                                   onchange="ChangeToSlug('namePro','slugs')" value="{{ old('namePro') }}"
                                   name="namePro"
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
                                   value="{{ old('slug') }}" name="slug" id="slugCategories"
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
                                   value="{{ old('quantity') }}" name="quantity" id="quantity"
                                   placeholder="Số lượng sản phẩm ...">
                            @error('quantity')
                            <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <label for="price">Giá gốc (đ)<span class="text-danger">(*)</span></label>
                            <input type="number" step="0.01" class="form-control form-control-user " id="cost"
                                   value="{{ old('cost') }}" name="cost" id="cost"
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
                                   value="{{ old('price') }}" name="price" id="price"
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
                                   value="0" id="discounts" placeholder="Giảm bán sản phẩm ...">
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
                                <option selected>Choose...</option>
                                @foreach ($category as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->nameCate }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class=" col-sm-6 ">
                            <label for="slugCategories">Nhà cung cấp<span class="text-danger">(*)</span></label>
                            <select class="custom-select" name="supplier_id" id="inputGroupSelect01">
                                <option selected>Choose...</option>
                                @foreach ($supplier as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->nameSupplier }}
                                        {{ $cate->status == 1 ? ' ' : '(Ngưng cung cấp)' }}</option>
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
                                <option selected>Choose...</option>
                                @foreach ($origin as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                @endforeach
                            </select>
                            @error('origin_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="slugCategories">Trạng thái<span class="text-danger">(*)</span></label>
                            <select class="custom-select" name="status" id="inputGroupSelect01">
                                <option selected value="1">Đang hoạt động</option>
                                <option value="0">Ngưng hoạt động</option>
                            </select>
                            @error('status')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0"><label for="slugCategories">Anh sản phẩm<span
                                    class="text-danger">(*)</span></label>
                            <div class="custom-file">
                                <!-- <input type="file" class="custom-file-input" id="inputGroupFile01"> -->
                                <input id="image" type="file" id="image" name="image" class="form-control"
                                       require>
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="form-group row d-flex justify-content-star">
                        <div class="col-sm-12 mb-3 mb-sm-3">
                            <label for="slugCategories">Loại biến thể</label> <br>
                            <select class="form-select w-100" id="multiple-select-variant"
                                    data-placeholder="Chọn loại biến thể" multiple>
                                <option type="color">Color</option>
                                <option type="text">Size</option>
                                <option type="text">Weight</option>
                            </select>
                        </div>

                        <div class="col-sm-12 mb-3 mb-sm-3">
                            <div id="accordion">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <div class="btn btn-link w-100 d-flex justify-content-between"
                                                 data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                 aria-controls="collapseOne">
                                                <span>Biến thể</span> <i class="fas fa-fw fa-chevron-down"></i>
                                            </div>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                         data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="btn btn-primary w-2 mb-5 float-right" data-input-type="color"><i
                                                    class="fas fa-fw fa-plus"></i></div>
                                            <br>
                                            <div class="form-row  d-flex  justify-content-start mt-5">
                                                <div class="form-group" style="width: 10%;">
                                                    <input type="color" class="form-control float-right w-100"
                                                           placeholder="Color">
                                                </div>
                                                <div class="form-group" style="width: 10%;">
                                                    <input type="text" class="form-control float-right w-100"
                                                           placeholder="Size">
                                                </div>
                                                <div class="form-group" style="width: 10%;">
                                                    <input type="text" class="form-control float-right w-100"
                                                           placeholder="Weight">
                                                </div>
                                                <div class="form-group" style="width: 10%;">
                                                    <input type="number" class="form-control float-right w-100"
                                                           placeholder="Số lượng">
                                                </div>
                                                <div class="form-group" style="width: 10%;">
                                                    <input type="number" step="0.01" min="0"
                                                           class="form-control float-right w-100"
                                                           placeholder="Nhập giá tiền">
                                                </div>
                                                <div class="form-group float-right">
                                                    <i class="fas fa-fw fa-trash float-right trash-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class=" col-sm-12 ">
                            <label for="slugCategories">Mô tả sản phẩm</label>
                            <textarea class="form-control" name="Description" id="summernote"
                                      rows="3">{{ old('Description') }}</textarea>
                        </div>

                    </div>
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
        var selectedOptions = {};

        $('#multiple-select-variant').change(function () {
            selectedOptions = {};
            $('#multiple-select-variant option:selected').each(function () {
                var name = $(this).text();
                var type = $(this).attr('type');
                selectedOptions[name] = type;
            });
            console.log("Selected options:", selectedOptions);
        });
    </script>
    <script>
        $('#multiple-select-variant').select2();
    </script>
    <script>
        $(document).ready(function () {
            // Hàm để tạo form-row với loại input được chỉ định
            function createFormRow(inputType) {
                var formRow = `<div class="form-row  d-flex  justify-content-start mt-5">`
                for (var key in selectedOptions) {
                    if (selectedOptions.hasOwnProperty(key)) {
                        var type = selectedOptions[key];
                        console.log("Name:", key, "Type:", type);
                        // Chèn biến type vào thuộc tính type của input
                        formRow += `<div class="form-group" style="width: 10%;">
                        <input type="${type}" class="form-control float-right w-100" placeholder="${key}">
                    </div>`;
                    }
                }
                formRow += `
                            <div class="form-group" style="width: 10%;">
                                <input type="number" class="form-control float-right w-100" placeholder="Số lượng">
                            </div>
                            <div class="form-group" style="width: 10%;">
                                <input type="number" step="0.01" min="0" class="form-control float-right w-100" placeholder="Nhập giá tiền">
                            </div>
                            <div class="form-group float-right">
                                <i class="fas fa-fw fa-trash float-right trash-icon"></i>
                            </div>
                        </div>`

                return formRow;
            }

            // Thêm form-row khi click vào nút plus
            $('.btn-primary').click(function () {
                var parentCardBody = $(this).closest('.card-body');
                var inputType = $(this).data('input-type'); // Lấy loại input từ data attribute
                var newFormRow = createFormRow(inputType);
                parentCardBody.append(newFormRow);
            });

            // Xóa form-row khi click vào icon trash
            $(document).on('click', '.trash-icon', function () {
                $(this).closest('.form-row').remove();
            });
        });
    </script>

    <script>
        $(function () {
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
