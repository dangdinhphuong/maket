    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="{{ asset('storage/' . $config->logo) }}" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="{{route('carts')}}"><i class="fa fa-shopping-bag"></i></a></li>
            </ul>
        </div>
        <div class="humberger__menu__widget">

            <div class="header__top__right__auth">
                <a href="{{ route('login') }}"><i class="fa fa-user"></i> Đăng nhập</a>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <li class="{{ request()->route()->getName() == "home" ? "active" : "" }}"><a href="{{route('home')}}">Trang chủ</a></li>
                <li class="{{ request()->route()->getName() == "blogs" ? "active" : "" }}"><a href="{{ route('blogs') }}">Bài viết</a></li>
                <li class="{{ request()->route()->getName() == "contact" ? "active" : "" }}"><a href="{{ route('contact') }}">Liên hệ</a></li>
                <li class="{{ request()->route()->getName() == "order" ? "active" : "" }}"><a href="{{ route('order') }}">Đơn hàng</a></li>
                <!-- <li><a href="./shop-grid.html">Shop</a></li>
                <li><a href="#">Pages</a>
                    <ul class="header__menu__dropdown">
                        <li><a href="./shop-details.html">Shop Details</a></li>
                        <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                        <li><a href="./checkout.html">Check Out</a></li>
                        <li><a href="./blog-details.html">Blog Details</a></li>
                    </ul>
                </li>
                <li><a href="./blog.html">Blog</a></li>
                <li><a href="./contact.html">Contact</a></li> -->
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i>{{$config->email}}</li>
                <li>Giao hàng tận nơi</li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->


    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> {{$config->email}}</li>
                                <li>Giao hàng tận nơi</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="{{$config->link_facebook}}" target="_blank"><i class="fa fa-facebook"></i></a>
                                <a href="{{$config->link_twitter}}" target="_blank"><i class="fa fa-twitter"></i></a>
                                <a href="{{$config->link_linkedin}}" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </div>
                            <div class="header__top__right__auth">
                                <a href="{{route('registered_shop')}}"><i class="fa fa-heart"></i>Đăng ký shop </a>
                            </div>
                            @if(isset(auth()->user()->is_admin)&& auth()->user()->is_admin == 0)
                            <div class="header__top__right__language">

                                <a href="#">
                                    <div><i class="fa fa-user"></i> {{ auth()->user()->fullname }}</div>
                                </a>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="{{route('profile')}}">Tài khoản</a></li>
                                    <li><a href="{{route('logout')}}">Đăng xuất</a></li>
                                </ul>
                            </div>
                            @else
                            <div class="header__top__right__auth">
                                <a href="{{route('login')}}"><i class="fa fa-user"></i> Đăng nhập</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo_1">
                        <a href="{{route('home')}}"><img src="{{ asset('storage/' . $config->logo) }}" style="margin-left: 83px;width:100px;" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>

                            <li class="{{ request()->route()->getName() == "home" ? "active" : "" }}"><a href="{{route('home')}}">Trang chủ</a></li>
                            <li class="{{ request()->route()->getName() == "blogs" ? "active" : "" }}"><a href="{{ route('blogs') }}">Bài viết</a></li>
                            <li class="{{ request()->route()->getName() == "contact" ? "active" : "" }}"><a href="{{ route('contact') }}">Liên hệ</a></li>
                            <li class="{{ request()->route()->getName() == "order" ? "active" : "" }}"><a href="{{ route('order') }}">Đơn hàng</a></li>
                            <!-- <li><a href="#">Pages</a>
                                <ul class="header__menu__dropdown">
                                    <li><a href="./shop-details.html">Shop Details</a></li>
                                    <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                                    <li><a href="./checkout.html">Check Out</a></li>
                                    <li><a href="./blog-details.html">Blog Details</a></li>
                                </ul>
                            </li>
                            <li><a href="./blog.html">Blog</a></li>
                            <li><a href="./contact.html">Contact</a></li> -->
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>

                            <li><a href="{{route('carts')}}"><i class="fa fa-shopping-bag"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <section class="hero {{ request()->route()->getName() != "home" ? "hero-normal" : "" }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Các loại thực phẩm</span>
                        </div>
                        <ul style='display: {{ request()->route()->getName() != "home" ? "none" : "block" }} '>
                            @foreach($categories as $category)
                            <li><a href="{{route('products').'?slug_cate='. $category->slug}}">{{ $category->nameCate  }} ({{ $category->products->count() }})</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="{{route('products')}}" method="get">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Hãy cho tôi biết bạn cần gì ?">
                                <button type="submit" class="site-btn">Tìm kiếm</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <a href="tel: {{$config->phone}}">
                                    <h5>{{$config->phone}}</h5>
                                </a>
                                <span>Hỗ trợ 24/7 </span>
                            </div>
                        </div>
                    </div>
                    <div style='display: {{ request()->route()->getName() != "home" ? "none" : "block" }} ' class="hero__item set-bg" data-setbg="{{asset('client/img/hero/banner.jpg')}}">
                        <div class="hero__text" style="padding-top: 95px;">
                            <span>FRUIT FRESH</span>
                            <h2>Vegetable <br />100% Organic</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <a href="#" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->