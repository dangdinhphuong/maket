@extends('admin.master')
@section('title', 'Tạo sản phẩm')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Biến thể sản phẩm</h1>
        <a href="{{ route('cp-admin.products.index') }}"
           class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Danh mục</a>
    </div>

    <div class="card shadow mb-4 ">
        <div class="card-body">
            <div class="table-responsive">
                <form class="user"
                      action="{{ route('cp-admin.products.variant.update', ['product_id' => $Product->id]) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row d-flex justify-content-star">
                        <div class="col-sm-12 mb-3 mb-sm-3">
                            <label for="slugCategories">Loại biến thể</label> <br>
                            <select class="form-select w-100" id="multiple-select-variant"
                                    data-placeholder="Chọn loại biến thể" multiple>
                                <option value="color">Color</option>
                                <option value="size">Size</option>
                                <option value="weight">Weight</option>
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
                                                <span>Biến thể: <i class="text-danger">(Tối đa 10 biến thể)</i></span>
                                                <i class="fas fa-fw fa-chevron-down"></i>
                                            </div>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                         data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="btn btn-primary w-2 mb-5 float-right" id="addVariant"><i
                                                    class="fas fa-fw fa-plus"></i></div>
                                            <br>
                                            <div class="variants-container">
                                                @foreach ($variants as $variant)
                                                    @php $variantValues = json_decode($variant['variant_value'], true);  @endphp
                                                    <div class="form-row d-flex justify-content-start"
                                                         id="variant_{{$variant->id}}">
                                                        @foreach ($variantValues as $key => $item)
                                                            @if ($key == 'color')
                                                                <div class="form-group"
                                                                     style="width: 10%; margin-right: 1%;">
                                                                    <label for="slugCategories">{{ $key }}</label>
                                                                    <input type="{{ $key }}"
                                                                           value='{{ $item }}'
                                                                           class="form-control float-right w-100"
                                                                           placeholder="{{ $key }}" disabled>
                                                                </div>
                                                            @elseif ($key == 'image')
                                                                <div class="form-group"
                                                                     style="width: 10%; margin-right: 1%;">
                                                                    <label for="slugCategories">{{ $key }}</label>
                                                                    <img src="{{asset('storage/' .$item)}}"
                                                                         style=" width: 100%;height: 50%;"
                                                                         class="progressive-img_full">
                                                                </div>
                                                            @else
                                                                <div class="form-group"
                                                                     style="width: 10%; margin-right: 1%;">
                                                                    <label for="slugCategories">{{ $key }}</label>
                                                                    <input type="text" value='{{ $item }}'
                                                                           class="form-control float-right w-100"
                                                                           placeholder="{{ $key }}" disabled>
                                                                </div>
                                                            @endif
                                                        @endForeach
                                                        <div
                                                            class="form-group float-right"
                                                            style="width: 10%; margin-right: 1%;">
                                                            <div class="btn btn-primary w-2 mb-5 float-right "
                                                                 onclick="deleteVariant('{{ route('cp-admin.products.variant.delete', ['product_id' => $Product->id,'id'=> $variant->id]) }}', {{$variant->id}})"
                                                                 style="    margin-top: 28%;"><i
                                                                    class="fas fa-fw fa-trash"></i></div>
                                                        </div>
                                                        @endForeach
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
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
    <script>
        $('#multiple-select-variant').select2();
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
    <script>
        function deleteVariant(url, id) {
            swal({
                title: "Bạn có chắc không?",
                text: "Biến thể sẽ dừng hoạt động sau khi xóa! ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "get",
                            url: url,
                            success: function (res) {
                                //console.log(res.status)
                                if (res.status == 200) {
                                    swal("Tệp của bạn đã bị xóa!", {
                                        icon: "success",
                                    }).then(function () {
                                        $("#variant_" + id).remove();
                                    });
                                } else if (res.status == 401) {
                                    swal(res.message, {
                                        icon: "error",
                                    });
                                }
                            }
                        });

                    } else {
                        swal("Tệp của bạn an toàn!!");
                    }
                });
        }

    </script>
    <script>
        $(document).ready(function () {
            var selectedOptions = {};

            $('#multiple-select-variant').change(function () {
                selectedOptions = {};
                $('#multiple-select-variant option:selected').each(function () {
                    var name = $(this).val();
                    selectedOptions[name] = true;
                });
                console.log("Selected options:", selectedOptions);
            });

            $('#addVariant').click(function () {

                var variantHtml = '<div class="form-row d-flex justify-content-start">';
                var randomStr = randomString(10);
                variantHtml +=
                    `<div class="form-group" style="width: 10%; margin-right: 1%;"><label for="slugCategories">Name</label><input type="text" name="variants[${randomStr}][name]" class="form-control float-right w-100" placeholder="Tên biến thể"></div>`;
                for (var key in selectedOptions) {
                    if (selectedOptions.hasOwnProperty(key)) {

                        variantHtml +=
                            `<div class="form-group" style="width: 10%; margin-right: 1%;">
                                <label for="slugCategories">${key.charAt(0).toUpperCase() + key.slice(1)}</label>
                                <input type="${key}" name="variants[${randomStr}][${key}]" class="form-control float-right w-100" placeholder="${key.charAt(0).toUpperCase() + key.slice(1)}"></div>`;
                    }
                }
                variantHtml +=
                    `<div class="form-group" style="width: 10%; margin-right: 1%;"><label for="slugCategories">Quantity</label><input type="number" name="variants[${randomStr}][quantity]" class="form-control float-right w-100" placeholder="Số lượng"></div>`;
                variantHtml +=
                    `<div class="form-group" style="width: 10%; margin-right: 1%;"><label for="slugCategories">Price</label><input type="number" step="0.01" min="0" name="variants[${randomStr}][price]" class="form-control float-right w-100" placeholder="Nhập giá tiền"></div>`;
                variantHtml +=
                    `<div class="form-group" style="width: 15%; margin-right: 1%;"><label for="slugCategories">Image</label><input type="file" step="0.01" min="0" name="variants[${randomStr}][image]" id="product_image_${randomStr}" onchange="previewFile(this, '${randomStr}')" class="form-control float-right w-100" placeholder="Ảnh"></div>`;
                variantHtml +=
                    `<div class="form-group" style="width: 15%; margin-right: 1%;"> <img style="width: 100%;height: 50%;" id="previewimg_${randomStr}" alt=""></div>`;
                variantHtml +=
                    ` <div class="form-group float-right"style="width: 10%; margin-right: 1%;"> <div class="btn btn-primary w-2 mb-5 float-right "  style="    margin-top: 28%;"><i class="fas fa-fw fa-trash trash-icon"></i></div>
                    `;
                variantHtml += '</div>';
                var numberOfVariants = $('.variants-container .form-row').length;
                // numberOfVariants += 1;
                console.log('numberOfVariants',numberOfVariants)
                if (numberOfVariants >= 10) {
                    alert("Số lượng biến thể chỉ tối đa là 10.");
                } else if (Object.keys(selectedOptions).length !== 0) {
                    $('.variants-container').append(variantHtml);
                } else {
                    // Thực hiện hành động khác nếu mảng selectedOptions rỗng
                    alert("Không có tùy chọn nào được chọn.");
                }

            });

            $(document).on('click', '.trash-icon', function () {
                $(this).closest('.form-row').remove();
            });

            function randomString(length) {

                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            }
        });
    </script>
    <script>
        function previewFile(input, key) {
            console.log(input, key);
            var file = $("#product_image_" + key).get(0).files[0];
            console.log(file);
            if (file) {
                var reader = new FileReader();
                reader.onload = function () {
                    $('#previewimg_' + key).attr('src', reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
