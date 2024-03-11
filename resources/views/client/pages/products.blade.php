@extends('client.master')
@section('title', 'Siêu thị thực phẩm')
@section('content')


    <!-- Breadcrumb Section Begin -->
    @if ($categories_slug != '')
        <section class="breadcrumb-section set-bg" data-setbg="{{ asset('storage/' . $categories_slug->banner) }}">
        @else
            <section class="breadcrumb-section set-bg" data-setbg="http://thucphamsfood.com/upload/images/banner.jpg">
    @endif
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Siêu thị thực phẩm</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        @if ($categories_slug != '')
                            <span>{{ $categories_slug->nameCate }}</span>
                        @else
                            <span>Tát cả sản phẩm</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- Breadcrumb Section End -->
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item categories1">
                            <h4>Loại thực phẩm</h4>
                            <ul>
                                @foreach ($category as $cate)
                                    <li
                                        class=" {{ !empty(request('slug_cate')) && request('slug_cate') == $cate->slug ? 'active' : '' }} ">
                                        <a
                                            href="{{ route('products') . '?slug_cate=' . $cate->slug }}">{{ $cate->nameCate }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="sidebar__item">
                            <h4>Lọc sản phẩm</h4>
                            <div class="price-range-wrap">
                                <form name="fillter_pro" class="" action="" method="get">
                                    @if (request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if ($categories_slug != '')
                                        <input type="hidden" name="slug_cate" value="{{ $categories_slug->slug }}">
                                    @endif

                                    <input type="hidden" class="form-control bg-light border-0 small sreach" name="page"
                                        value="{{ request('page') ? request('page') : '1' }}" aria-label="Search"
                                        aria-describedby="basic-addon2">
                                    <!-- <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="0" data-max="10000000">
                                        <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    </div> -->
                                    <div class="range-slider">
                                        <label for="">Sắp xếp</label>
                                        <div class="price-input d-flex justify-content-between mb-3 w-100">
                                            <select class="custom-select w-100" name="sort" id="inputGroupSelect01">
                                                <option value="ASC" {{ request('sort') == 'ASC' ? 'selected' : '' }}>Giá
                                                    tăng dần</option>
                                                <option value="DESC" {{ request('sort') == 'DESC' ? 'selected' : '' }}>Giá
                                                    giảm dần</option>
                                            </select>
                                        </div>
                                        <label for="">Lọc theo giá</label>
                                        <div class="price-input d-flex justify-content-between">

                                            <input type="number" name="min"
                                                value="{{ request('min') ? request('min') : '' }}"
                                                class="border border-danger" placeholder="Tối thiểu...">
                                            <input type="number" name="max"
                                                value="{{ request('max') ? request('max') : '' }}"
                                                class="border border-danger" placeholder="Tối đa...">
                                        </div>
                                        <div class=" d-flex justify-content-between mt-2">
                                            <button type="submit" id="fillter_pro" class="site-btn">Lọc</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- <div class="sidebar__item sidebar__item__color--option">
                                <h4>Colors</h4>
                                <div class="sidebar__item__color sidebar__item__color--white">
                                    <label for="white">
                                        White
                                        <input type="radio" id="white">
                                    </label>
                                </div>
                                <div class="sidebar__item__color sidebar__item__color--gray">
                                    <label for="gray">
                                        Gray
                                        <input type="radio" id="gray">
                                    </label>
                                </div>
                                <div class="sidebar__item__color sidebar__item__color--red">
                                    <label for="red">
                                        Red
                                        <input type="radio" id="red">
                                    </label>
                                </div>
                                <div class="sidebar__item__color sidebar__item__color--black">
                                    <label for="black">
                                        Black
                                        <input type="radio" id="black">
                                    </label>
                                </div>
                                <div class="sidebar__item__color sidebar__item__color--blue">
                                    <label for="blue">
                                        Blue
                                        <input type="radio" id="blue">
                                    </label>
                                </div>
                                <div class="sidebar__item__color sidebar__item__color--green">
                                    <label for="green">
                                        Green
                                        <input type="radio" id="green">
                                    </label>
                                </div>
                            </div>
                            <div class="sidebar__item">
                                <h4>Popular Size</h4>
                                <div class="sidebar__item__size">
                                    <label for="large">
                                        Large
                                        <input type="radio" id="large">
                                    </label>
                                </div>
                                <div class="sidebar__item__size">
                                    <label for="medium">
                                        Medium
                                        <input type="radio" id="medium">
                                    </label>
                                </div>
                                <div class="sidebar__item__size">
                                    <label for="small">
                                        Small
                                        <input type="radio" id="small">
                                    </label>
                                </div>
                                <div class="sidebar__item__size">
                                    <label for="tiny">
                                        Tiny
                                        <input type="radio" id="tiny">
                                    </label>
                                </div>
                            </div>
                            <div class="sidebar__item">
                                <div class="latest-product__text">
                                    <h4>Latest Products</h4>
                                    <div class="latest-product__slider owl-carousel">
                                        <div class="latest-prdouct__slider__item">
                                            <a href="#" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/latest-product/lp-1.jpg" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6>Crab Pool Security</h6>
                                                    <span>$30.00</span>
                                                </div>
                                            </a>
                                            <a href="#" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/latest-product/lp-2.jpg" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6>Crab Pool Security</h6>
                                                    <span>$30.00</span>
                                                </div>
                                            </a>
                                            <a href="#" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/latest-product/lp-3.jpg" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6>Crab Pool Security</h6>
                                                    <span>$30.00</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="latest-prdouct__slider__item">
                                            <a href="#" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/latest-product/lp-1.jpg" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6>Crab Pool Security</h6>
                                                    <span>$30.00</span>
                                                </div>
                                            </a>
                                            <a href="#" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/latest-product/lp-2.jpg" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6>Crab Pool Security</h6>
                                                    <span>$30.00</span>
                                                </div>
                                            </a>
                                            <a href="#" class="latest-product__item">
                                                <div class="latest-product__item__pic">
                                                    <img src="img/latest-product/lp-3.jpg" alt="">
                                                </div>
                                                <div class="latest-product__item__text">
                                                    <h6>Crab Pool Security</h6>
                                                    <span>$30.00</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">

                    <div class="row">
                        @foreach ($products as $product)

                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__discount__item">
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
                                            <div class="product__item__price">
                                                {{ number_format($product->minPiceProduct, 0, ',', '.') . ' - ' . number_format($product->maxPriceProduct, 0, ',', '.') . ' ₫' }}
                                            </div>
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
