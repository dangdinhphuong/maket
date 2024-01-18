@extends('client.master')
@section('title', 'Siêu thị thực phẩm')
@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{asset('storage/' .$Product->category->banner)}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{$Product->namePro}}</h2>
                    <div class="breadcrumb__option">
                        <a href="{{route('home')}}">Trang chủ</a>
                        <a href="{{route('products').'?slug_cate='.$Product->category->slug}}">{{$Product->category->nameCate}}</a>
                        <span>{{$Product->namePro}}</span>
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
                        <img class="product__details__pic__item--large" src="{{asset('storage/' .$Product->image)}}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">

                    <div class="product__details__text">
                        <h3>{{$Product->namePro}}</h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span>(18 đánh giá)</span>
                        </div>
                        <div class="product__details__price">
                            {{ number_format(($Product->price-(($Product->price * $Product->discounts )/100)), 0, ',', '.') . " VNĐ"   }}
                            @if($Product->discounts > 0)
                            <span>{{ number_format($Product->price, 0, ',', '.') . " VNĐ" }}</span>
                            @endif
                        </div>
                        <div class="product__details__quantity">
                        @csrf
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" id="quantity" value="1">
                                </div>
                            </div>
                        </div>
                        @if($config->market_status == 0)
                        <button type="button" class="btn btn-danger">Xin lỗi chợ đã đóng</button>
                        @else
                        <button class="primary-btn" onclick="addToCart({{$Product->id}})" {{$Product->quantity <= 0 ? "disabled" : "" }}>{{$Product->quantity <= 0 ? "Sản phẩm đã hết hàng" : "Thêm vào giỏ hàng" }}</button>
                        @endif
                        <ul>
                            <li><b>Số lượng sản phẩm </b> <span>{{$Product->quantity}} SP</span></li>
                            <li><b>Nhà cung cấp</b> <span>{{$Product->supplier->nameSupplier}}</span></li>
                            <li><b>Xuất xứ </b> <span>{{$Product->origin->name}}</span></li>
                            <li><b>Vận chuyển </b> <span><samp>Miễn phí vẫn chuyển</samp></span></li>
                            <li><b>Cửa hàng </b> <span> {{$Product->User->groupUser->name ?? ""}}</span></li>
                        </ul>
                    </div>

            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Mô tả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Bình luận <span></span></a>
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
                                <h6>Products Infomation</h6>
                                <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                                    Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                                    Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                                    sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                                    eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                                    Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                                    sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                                    diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                                    ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                                    Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                                    Proin eget tortor risus.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            @foreach($RelatedProducts->take(4) as $RelatedProduct)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{asset('storage/' .$RelatedProduct->image)}}">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li onclick="addCart({{$RelatedProduct->id}})"><a ><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text product__item__price">
                        <h6><a href="{{ route('product',['slug'=>$RelatedProduct->slug])  }}">{{$RelatedProduct->namePro}}</a></h6>
                        <b> {{ number_format(($RelatedProduct->price-(($RelatedProduct->price * $RelatedProduct->discounts )/100)), 0, ',', '.') . " VNĐ"   }}</b>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Related Product Section End -->

@endsection

@section('javascript')
<script>

</script>
@endsection
