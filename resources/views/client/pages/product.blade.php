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
                        <ul id="info-Variant" style="padding-top: 0px; margin-top: 0px; margin-bottom: 2px">
                        </ul>
                        <div class="card w-100 mb-2">
                            <div class="card-header">
                                Phân loại
                            </div>
                            <div class="card-body">
                                @foreach ($Product->productVariant as $productVariant)
                                    @if ($productVariant->quantity < 1)
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
                                    <input type="text" id="quantity" value="1" disabled>
                                </div>
                            </div>
                        </div>
                        @if ($config->market_status == 0)
                            <button type="button" class="btn btn-danger">Xin lỗi chợ đã đóng</button>
                        @else
                            <button class="primary-btn" onclick="beforeAddToCart({{ $Product->id }})"
                                {{ $Product->quantity <= 0 ? 'disabled' : '' }}>{{ $Product->quantity <= 0 ? 'Sản phẩm đã hết hàng' : 'Thêm vào giỏ hàng' }}</button>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12 ">
                    <div class="card">
                        <div class="card-body">
                            <img style="width:100px; height: 100px;" src="{{ asset('storage/' . $Product->User->avatar) }}" class="rounded float-left mr-2" alt="...">
                            <div class=" mb-2" style="margin-top: 2%;"> {{ $Product->User->fullname }}</div>
                            <a href="{{ $Product->User->id }}"  class="btn btn-outline-dark"> Xem shop</a>
                        </div>
                      </div>
                   
                </div>
   
                <div class="col-lg-12">
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
                                                    <div class="mt-3 d-flex flex-row align-items-center p-3 form-color">
                                                        <img src="https://i.imgur.com/zQZSWrt.jpg" width="50"
                                                            class="rounded-circle mr-2">
                                                        <input type="text" class="form-control" id="commentInput"
                                                            placeholder="Enter your comment...">
                                                        <button onclick="addComment()" class="btn btn-primary">Submit
                                                        </button>
                                                    </div>
                                                    <div class="mt-2" id="commentsContainer">
                                                        @foreach ($Product->comments as $item)
                                                            @if ($item->status == 1)
                                                                <div class="d-flex flex-row p-3"><img
                                                                        src="https://i.imgur.com/zQZSWrt.jpg"
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
                                                                        <div class="d-flex flex-row user-feed"> <span
                                                                                class="wish"><i
                                                                                    class="fa fa-heartbeat mr-2"></i>24</span>
                                                                            <span class="ml-3"><i
                                                                                    class="fa fa-comments-o mr-2"></i>Reply</span>
                                                                        </div>
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
        <div class="container">
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
                        <div class="product__item">
                            <div class="product__item__pic set-bg"
                                data-setbg="{{ asset('storage/' . $RelatedProduct->image) }}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li onclick="addCart({{ $RelatedProduct->id }})"><a><i
                                                class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text product__item__price">
                                <h6><a
                                        href="{{ route('product', ['slug' => $RelatedProduct->slug]) }}">{{ $RelatedProduct->namePro }}</a>
                                </h6>
                                <b>
                                    {{ number_format($RelatedProduct->price - ($RelatedProduct->price * $RelatedProduct->discounts) / 100, 0, ',', '.') . ' ₫' }}</b>
                            </div>
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
    </style>
@endsection

@section('javascript')
    <script>
        var productVariants = {!! json_encode($Product->productVariant) !!}
        var productVariant = '';
        var productQuantity = {!! $Product->quantity !!};

        function beforeAddToCart(id) {
            if (productVariants.length > 0) {
                if (productVariant != '') {
                    addToCart(id, productVariant);
                } else {
                    swal("Vui lòng chọn phân loại", {
                        icon: "error",
                    });
                }
            } else {
                addToCart(id);
            }

        }

        function selectVariant(element) {
            var dataId = $(element).data('id');
            var dataImage = element.dataset.image;

            productVariant = productVariants.find(function(element) {
                return element.id === dataId;
            });
            productQuantity = productVariant['quantity'];
            showVariant(JSON.parse(productVariant.variant_value))
            $('.product__details__pic__item--large').attr('src', dataImage);
            $(element).parent().find('.btn').removeClass('active');
            $(element).addClass('active');
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
                    } else if (newInfo[key].label != 'image' && newInfo[key].label != 'price') {
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
            // var newCommentText = $('#commentInput').val();

            // Create the new comment HTML
            var newCommentHTML = `
                    <div class="d-flex flex-row p-3">
                        <img src="https://i.imgur.com/zQZSWrt.jpg" width="40" height="40" class="rounded-circle mr-3">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row align-items-center">
                                    <span class="mr-2">${data.customer.fullname}</span>
                                </div>
                                <small>${data.created_at}</small>
                            </div>
                            <p class="text-justify comment-text mb-0">${data.content}</p>
                            <div class="d-flex flex-row user-feed">
                                <span class="wish"><i class="fa fa-heartbeat mr-2"></i>0</span>
                                <span class="ml-3"><i class="fa fa-comments-o mr-2"></i>Reply</span>
                            </div>
                        </div>
                    </div>
                `;

            // Append the new comment to the comments container
            $('#commentsContainer').append(newCommentHTML);

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
            if ($button.hasClass('inc') && productQuantity >= parseFloat(oldValue) + 1) {
                newVal = parseFloat(oldValue) + 1;
            } else if ($button.hasClass('dec') && parseFloat(oldValue) - 1 > 0) {
                // Don't allow decrementing below zero
                newVal = parseFloat(oldValue) - 1;
            }
            $button.parent().find('input').val(newVal);
        });
    </script>
@endsection
