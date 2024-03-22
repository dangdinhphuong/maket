@extends('client.master')
@section('title', 'Siêu thị thực phẩm')
@section('content')


    <!-- Breadcrumb Section Begin -->
            @if ($categories_slug != '')
                <section class="breadcrumb-section set-bg" data-setbg="{{ asset('storage/' . $categories_slug->banner) }}">
            @else
                <section class="container container-info-shop">
            @endif
                        <div class="row" style="    background-color: #58565666; border-radius: 15px;">
                            <div class="col-lg-12">
                                <div class="breadcrumb__text pt-3 pb-3 d-flex justify-content-between">
                                    <img style="width: 8% ;margin-right: 25%;" src="https://salt.tikicdn.com/cache/w220/ts/seller/7d/3b/df/eee8d1f6b99ba58243f7e47337e0541e.jpg" alt="..." class="rounded-circle">
                                    <h4 style=" text-align: center; width: 33%; color:#fff; line-height: 84px;">Siêu thị thực phẩm</h4>
                                    <div class="breadcrumb__option" style="width: 33%; padding-top: 2%;">
                                        <form class="form-inline">
                                            <input class="form-control mr-sm-2" style="    width: 78%;" type="search" placeholder="Tìm kiếm sản phẩm tại cửa hàng" aria-label="Search">
                                            <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
                                          </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </section>
                <!-- Breadcrumb Section End -->
                <!-- Product Section Begin -->
                <section class="product spad" style="    padding-top: 27px;">
                    <div class=" mb-2 container container-filter d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-dark">Bán  chạy</button>
                        <button type="button" class="btn btn-outline-dark">Hàng mới</button>
                        <button type="button" class="btn btn-outline-dark">Giá từ thấp tới cao</button>
                        <button type="button" class="btn btn-outline-dark">Giá từ cao tới thấp</button>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#exampleModal">
                            <img src="https://salt.tikicdn.com/ts/upload/3f/23/35/2d29fcaea0d10cbb85ce5b0d4cd20add.png" alt="filters" style="width: 20px;height: 20px;">
                             Tất cả
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                ...
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12" style="background: #fff;">

                                <div class="row">
                                    @foreach ($products as $product)

                                        <div class="col-lg-3 col-md-6 col-sm-6" style="padding-top: 1%; margin-bottom: 1%;">
                                            <div class="product__discount__item" style="border-radius: 15px; background: #e9e4e4;">
                                                <div class="product__discount__item__pic set-bg"
                                                     data-setbg="{{ asset('storage/' . $product->image) }}">
                                                    @if ($product->discounts > 0)
                                                        <div class="product__discount__percent">-{{ $product->discounts }}%</div>
                                                    @endif
                                                    @if ($product->quantity <= 0)
                                                        <ul class="">
                                                            <li class="btn btn-warning w-100">Hết hàng</li>
                                                        </ul>
                                                    @else
                                                        <ul class="product__item__pic__hover">
                                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                            <li onclick="addCart({{ $product->id }})"><a><i
                                                                        class="fa fa-shopping-cart"></i></a></li>
                                                        </ul>
                                                    @endif
                                                </div>
                                                <div class="product__discount__item__text">
                                                    <h5><a
                                                            href="{{ route('product', ['slug' => $product->slug]) }}">{{ $product->namePro }}</a>
                                                    </h5>
                                                    @if (!empty($product->minPiceProduct))
                                                        @if ($product->minPiceProduct < $product->maxPriceProduct)
                                                            <div class="product__item__price">
                                                                {{ number_format($product->minPiceProduct, 0, ',', '.') . ' - ' . number_format($product->maxPriceProduct, 0, ',', '.') . ' ₫' }}
                                                            </div>
                                                        @else
                                                            <div class="product__item__price">
                                                                {{ number_format($product->minPiceProduct, 0, ',', '.') . ' ₫' }}
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="product__item__price">
                                                            {{ number_format($product->price-($product->price * $product->discounts) / 100, 0, ',', '.') . ' ₫' }}
                                                            @if ($product->discounts > 0)
                                                                <span>{{ number_format($product->price, 0, ',', '.') . ' ₫' }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                      
                                    @endforeach
                                </div>
                                <div class="product__pagination">
                                {!! $products->links('pagination::bootstrap-4') !!}
                                <!-- <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#"><i class="fa fa-long-arrow-right"></i></a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Product Section End -->
<style>
   .container-info-shop {
    max-height: 155px;
    background-image: url(https://salt.tikicdn.com/ts/tmp/3c/58/be/e9aed7e6b0ab91346072b53891ce7b7b.jpg);
    position: relative;
    background-size: cover;
    z-index: 1;
    border-radius: 15px;
}
.container-filter{
    background: #fff;
    padding: 1%;
    border-radius: 15px 15px 0 0;
}
</style>
                @endsection

            @section('javascript')
                <script>
                    $(document).ready(function() {
                        $(".page-link").on("click", function(e) {
                            e.preventDefault();
                            var rel = $(this).text();
                            var page = parseInt(rel);
                            // console.log( $("select[name='category_id']").val());
                            $("input[name='page']").val(page);

                            $("form[name='fillter_pro']").trigger("submit");
                        });
                        $("#fillter_pro").on("click", function(e) {
                            e.preventDefault();
                            $("input[name='page']").val(1);

                            $("form[name='fillter_pro']").trigger("submit");
                        });
                    });
                </script>
@endsection
