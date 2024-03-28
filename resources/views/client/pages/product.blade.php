@extends('client.master')
@section('title', 'Siêu thị thực phẩm')
@section('content')
    <style>
        .owl-item {
            width: 123.75px;
            height: 130px;
            margin-right: 20px;
            background-color: #fff;
        }
    </style>
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('storage/' . $Product->category->banner) }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>{{ $Product->namePro }}</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('home') }}">Trang chủ</a>
                            <a
                                href="{{ route('products') . '?slug_cate=' . $Product->category->slug }}">{{ $Product->category->nameCate }}</a>
                            <span>{{ $Product->namePro }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" src="{{ asset('storage/' . $Product->image) }}"
                                alt="" style="height: 500px">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            @if (count($Product->productImage) > 1)
                                <img data-imgbigurl="{{ asset('storage/' . $Product->image) }}"
                                    src="{{ asset('storage/' . $Product->image) }}" alt="">
                                @foreach ($Product->productImage as $item)
                                    <img data-imgbigurl="{{ asset('storage/' . $item->image) }}"
                                        src="{{ asset('storage/' . $item->image) }}" alt="">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">

                    <div class="product__details__text">
                        <h3>{{ $Product->namePro }}</h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 đánh giá)</span>
                        </div>
                        @if (!empty($Product->minPiceProduct))
                            @if ($Product->minPiceProduct < $Product->maxPriceProduct)
                                <div class="product__details__price">
                                    {{ number_format($Product->minPiceProduct, 0, ',', '.') . ' - ' . number_format($Product->maxPriceProduct, 0, ',', '.') . ' ₫' }}
                                </div>
                            @else
                                <div class="product__details__price">
                                    {{ number_format($Product->minPiceProduct, 0, ',', '.') . ' ₫' }}
                                </div>
                            @endif
                        @else
                            <div class="product__details__price">
                                {{ number_format($Product->price - ($Product->price * $Product->discounts) / 100, 0, ',', '.') . ' ₫' }}
                                @if ($Product->discounts > 0)
                                    <span>{{ number_format($Product->price, 0, ',', '.') . ' ₫' }}</span>
                                @endif
                            </div>
                        @endif
                        <div class="card w-100 mb-2" style="height: 160px;">
                            <div class="card-body" style="overflow-y: auto;">
                                <ul id="info-Variant" style="padding-top: 0px; margin-top: 0px; margin-bottom: 2px">
                                    <li> Chọn phân loại ... </li>
                                </ul>
                            </div>
                        </div>




                        <div class="card w-100 mb-2" style="height: 125px; " >
                            <div class="card-header">
                                Phân loại
                            </div>
                            <div class="card-body" style="overflow-y: auto;">
                                @foreach ($Product->productVariant as $productVariant)
                                    @if ($productVariant->type == 1)
                                        <div class="btn btn-outline-dark active" id="defaultVariant" data-id="{{ $productVariant->id }}"
                                             data-image="{{ asset('storage/' . json_decode($productVariant->variant_value, true)['image']) }}"
                                             >{{ $productVariant->variant_type }}</div>
                                    @elseif ($productVariant->quantity < 1)
                                        <div class="btn btn-outline-dark disabled" style="    background-color: #d308084a;">
                                            {{ $productVariant->variant_type }}
                                        </div>
                                    @else
                                        <div class="btn btn-outline-dark" data-id="{{ $productVariant->id }}"
                                            data-image="{{ asset('storage/' . json_decode($productVariant->variant_value, true)['image']) }}"
                                            onclick="selectVariant(this)">{{ $productVariant->variant_type }}</div>
                                    @endif
                                @endforeach

                            </div>
                        </div>

                        <div class="product__details__quantity">
                            @csrf
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="number" id="quantity" value="1" min=1>
                                </div>
                            </div>
                        </div>
                        @if ($config->market_status == 0)
                            <button type="button" class="btn btn-danger">Xin lỗi chợ đã đóng</button>
                        @else
                            <button class="primary-btn" id="addtocart-btn" onclick="beforeAddToCart({{ $Product->id }})"
                                {{ $Product->quantity <= 0 ? 'disabled' : '' }}>{{ $Product->quantity <= 0 ? 'Hết hàng' : 'Thêm vào giỏ hàng' }}</button>
                        @endif
                        <a href="{{ route('shop',['id'=>$Product->User->id])  }}"  class="btn primary-btn"> Xem shop</a>
                    </div>
                </div>
                <div class="col-lg-12" style="background: #fff; border-radius: 15px">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                                    aria-selected="true">Mô tả</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                    aria-selected="false">Bình luận <span></span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Thông tin sản phẩm</h6>
                                    <p>
                                        {!! $Product->Description !!}
                                    </p>
                                </div>
                            </div>

                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <div class="container mt-5 mb-5">
                                        <div class="row height d-flex justify-content-center align-items-center">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="p-3">
                                                        <h6>Comments</h6>
                                                    </div>
                                                    @if(!empty(auth()->user()))
                                                    <div class="mt-3 d-flex flex-row align-items-center p-3 form-color">
                                                        <img id="avatar-user" src="{{ asset('storage/' . auth()->user()->avatar) }}"width="40" height="40" class="rounded-circle mr-3">
                                                        <input type="text" class="form-control" id="commentInput"
                                                            placeholder="Enter your comment...">
                                                        <button onclick="addComment()" class="btn btn-primary">Submit
                                                        </button>
                                                    </div>
                                                    @endif
                                                    <div class="mt-2" id="commentsContainer">
                                                        @foreach ($comments as $item)
                                                            @if ($item->status == 1)
                                                                <div class="d-flex flex-row p-3"><img
                                                                        src="{{ asset('storage/' . $item->customer->avatar) }}"
                                                                        width="40" height="40"
                                                                        class="rounded-circle mr-3">
                                                                    <div class="w-100">
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center">
                                                                            <div
                                                                                class="d-flex flex-row align-items-center">
                                                                                <span
                                                                                    class="mr-2">{{ $item->customer->fullname }}</span>
                                                                            </div>
                                                                            <small>{{ $item->created_at }}</small>
                                                                        </div>
                                                                        <p class="text-justify comment-text mb-0">
                                                                            {{ $item->content }}</p>
{{--                                                                        <div class="d-flex flex-row user-feed"> <span--}}
{{--                                                                                class="wish"><i--}}
{{--                                                                                    class="fa fa-heartbeat mr-2"></i>24</span>--}}
{{--                                                                            <span class="ml-3"><i--}}
{{--                                                                                    class="fa fa-comments-o mr-2"></i>Reply</span>--}}
{{--                                                                        </div>--}}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @csrf
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container pt-3" style="background: #fff; border-radius: 15px">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Sản phẩm liên quan</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($RelatedProducts->take(4) as $RelatedProduct)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item"  style="border-radius: 15px; background: #e9e4e4;">
                            <a href="{{ route('product', ['slug' => $RelatedProduct->slug]) }}">
                            <div class="product__item__pic set-bg"
                                data-setbg="{{ asset('storage/' . $RelatedProduct->image) }}">
{{--                                <ul class="product__item__pic__hover">--}}
{{--                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>--}}
{{--                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>--}}
{{--                                    <li onclick="addCart({{ $RelatedProduct->id }})"><a><i--}}
{{--                                                class="fa fa-shopping-cart"></i></a></li>--}}
{{--                                </ul>--}}
                            </div>
                            <div class="product__item__text product__item__price">
                                <h6><a
                                        href="{{ route('product', ['slug' => $RelatedProduct->slug]) }}">{{ $RelatedProduct->namePro }}</a>
                                </h6>
                                <b>
                                    {{ number_format($RelatedProduct->price - ($RelatedProduct->price * $RelatedProduct->discounts) / 100, 0, ',', '.') . ' ₫' }}</b>
                            </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->
    <style>

        body {
            background-color: #eee
        }

        .card {
            background-color: #fff;
            border: none
        }

        .form-color {
            background-color: #fafafa
        }

        .form-control {
            height: 48px;
            border-radius: 25px
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #35b69f;
            outline: 0;
            box-shadow: none;
            text-indent: 10px
        }

        .c-badge {
            background-color: #35b69f;
            color: white;
            height: 20px;
            font-size: 11px;
            width: 92px;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 2px
        }

        .comment-text {
            font-size: 13px
        }

        .wish {
            color: #35b69f
        }

        .user-feed {
            font-size: 14px;
            margin-top: 12px
        }

        .qtybtn {
            cursor: pointer;
            user-select: none;
        }
    </style>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        var productVariants = {!! json_encode($Product->productVariant) !!}
        var productVariant = '';
        var productQuantity = {!! $Product->quantity !!};

        function beforeAddToCart(id) {
            console.log('productVariants',productVariants.length)
            if (productVariants.length > 0) {
                if (productVariant != '') {
                    addToCart(id, productVariant);
                } else {
                    swal("Vui lòng chọn phân loại", {
                        icon: "error",
                    }).then(() => {
                        location.reload();
                    });
                }
            } else {
                addToCart(id);
            }

        }
        if (productVariants.length == 1){
            selectVariant()
        }
        function selectVariant(element,dataId = '', dataImage = '') {
            if(productVariants.length >0)
            {
                if (productVariants.length == 1){
                     dataId = $("#defaultVariant").data('id');
                     dataImage = $("#defaultVariant").data('image');
                }else{
                    console.log('defaultVariant',element)
                    dataId = $(element).data('id');
                    dataImage = $(element).data('image');
                }
                productVariant = productVariants.find(function (element) {
                    return element.id === dataId;
                });
                console.log('element',dataId,dataImage)
                productQuantity = productVariant['quantity'];
                showVariant(JSON.parse(productVariant.variant_value))

                $('.product__details__pic__item--large').attr('src', dataImage);
                $(element).parent().find('.btn').removeClass('active');
                $(element).addClass('active');
            }
        }

        function showVariant(variant) {
            $('#quantity').val(1)
            var newInfo = toLabelValuePairs(variant);
            variantHtml = ``;
            for (var key in newInfo) {
                if (newInfo.hasOwnProperty(key)) {
                    if (newInfo[key].label == 'color') {
                        variantHtml +=
                            `<li><b>${newInfo[key].label}</b> <span style="background-color: ${newInfo[key].value};">${newInfo[key].value}</span></li>`;
                    } else if (newInfo[key].label == 'quantity') {
                        quantityPro = parseFloat(newInfo[key].value) - 1;
                        variantHtml += `<li><b>${newInfo[key].label}</b> <span id="${newInfo[key].label}_number" data-quantity="${quantityPro}">${quantityPro}</span></li>`;
                    }
                    else if (newInfo[key].label != 'image' && newInfo[key].label != 'price') {
                        variantHtml += `<li><b>${newInfo[key].label}</b> <span>${newInfo[key].value}</span></li>`;
                    }
                }
            }
            var number = productVariant.price;
            var formattedNumber = number.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
            $('.product__details__price').text(formattedNumber)
            $('#info-Variant').empty();
            $('#info-Variant').append(variantHtml);
        }

        function toLabelValuePairs(obj) {
            return Object.entries(obj).map(([label, value]) => {
                return {
                    label,
                    value
                };
            });
        }

        function addComment1(data) {


            // // Get the value of the input field
            var srcValue = $('#avatar-user').attr('src');
            var formattedDate = moment(data.created_at).utc().format('YYYY-MM-DD HH:mm:ss');
            // Create the new comment HTML
            var newCommentHTML = `
                    <div class="d-flex flex-row p-3">
                        <img src="${srcValue}" width="40" height="40" class="rounded-circle mr-3">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row align-items-center">
                                    <span class="mr-2">${data.customer.fullname}</span>
                                </div>
                                <small>${formattedDate}</small>
                            </div>
                            <p class="text-justify comment-text mb-0">${data.content}</p>
                        </div>
                    </div>
                `;

            // Append the new comment to the comments container
            $('#commentsContainer').prepend(newCommentHTML);

            // Clear the input field
            $('#commentInput').val('');
        }

        function addComment(id) {
            const url = '/comment';
            let status = $("#statusSelect0-" + id).val();
            let _token = $("input[name=_token]").val();
            let product_id = {!! $Product->id !!};
            let customer_id = {!! auth()->user()->id ?? 0 !!};
            let content = $('#commentInput').val();
            let data = {
                product_id,
                customer_id,
                content,
                _token
            };
            $.ajax({
                type: "post",
                url: url,
                data: data,
                success: function(res) {
                    console.log(res.status)
                    if (res.status == 200) {
                        addComment1(res.data);
                        console.log(res.data)
                    } else if (res.status == 401) {
                        swal(res.message, {
                            icon: "error",
                        });
                    }
                }
            });
        }

        /*-------------------
        		Quantity change
        	--------------------- */
        var proQty = $('.pro-qty');
        proQty.prepend('<span class="dec qtybtn">-</span>');
        proQty.append('<span class="inc qtybtn">+</span>');
        proQty.on('click', '.qtybtn', function() {
            var $button = $(this);
            var newVal = oldValue = $button.parent().find('input').val();
            if (productVariants.length > 0) {
                if (productVariant == '') {
                    swal("Vui lòng chọn phân loại", {
                        icon: "error",
                    });
                    return false;
                }
            }
            newProductQuantity =  productQuantity ;
            if ($button.hasClass('inc') && newProductQuantity >= parseFloat(oldValue) + 1) {
                newVal = parseFloat(oldValue) + 1;
            } else if ($button.hasClass('dec') && parseFloat(oldValue) - 1 > 0) {
                // Don't allow decrementing below zero
                newVal = parseFloat(oldValue) - 1;
            }
            // $('#quantity_number').text(newProductQuantity-newVal)
            $button.parent().find('input').val(newVal);
        });
    </script>
@endsection
