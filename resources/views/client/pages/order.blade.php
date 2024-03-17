@extends('client.master')
@section('title', 'Siêu thị thực phẩm')
@section('content')

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <!-- Button trigger modal -->

                        @foreach ($orderDetails as $orderDetail)
                            <div class="card mb-5" data-toggle="modal"
                                data-target=".bd-example-modal-lg-{{ $orderDetail->id }}">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="RBPP9y">
                                        <div class="Koi0Pw">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="16"
                                                fill="none">
                                                <title>{{ $orderDetail->productVariant->product->User->fullname }}</title>
                                                <path fill="#EE4D2D" fill-rule="evenodd"
                                                    d="M0 2C0 .9.9 0 2 0h66a2 2 0 012 2v12a2 2 0 01-2 2H2a2 2 0 01-2-2V2z"
                                                    clip-rule="evenodd"></path>
                                                <g clip-path="url(#clip0)">
                                                    <path fill="#fff"
                                                        d="M8.7 13H7V8.7L5.6 6.3A828.9 828.9 0 004 4h2l2 3.3a1197.3 1197.3 0 002-3.3h1.6L8.7 8.7V13zm7.9-1.7h1.7c0 .3-.2.6-.5 1-.2.3-.5.5-1 .7l-.6.2h-.8c-.5 0-1 0-1.5-.2l-1-.8a4 4 0 01-.9-2.4c0-1 .3-1.9 1-2.6a3 3 0 012.4-1l.8.1a2.8 2.8 0 011.3.7l.4.6.3.8V10h-4.6l.2 1 .4.7.6.5.7.1c.4 0 .7 0 .9-.2l.2-.6v-.1zm0-2.3l-.1-1-.3-.3c0-.2-.1-.2-.2-.3l-.8-.2c-.3 0-.6.2-.9.5l-.3.5a4 4 0 00-.3.8h3zm-1.4-4.2l-.7.7h-1.4l1.5-2h1.1l1.5 2h-1.4l-.6-.7zm8.1 1.6H25V13h-1.7v-.5.1H23l-.7.5-.9.1-1-.1-.7-.4c-.3-.2-.4-.5-.6-.8l-.2-1.3V6.4h1.7v3.7c0 1 0 1.6.3 1.7.2.2.5.3.7.3h.4l.4-.2.3-.3.3-.5.2-1.4V6.4zM34.7 13a11.2 11.2 0 01-1.5.2 3.4 3.4 0 01-1.3-.2 2 2 0 01-.5-.3l-.3-.5-.2-.6V7.4h-1.2v-1h1.1V5h1.7v1.5h1.9v1h-2v3l.2 1.2.1.3.2.2h.3l.2.1c.2 0 .6 0 1.3-.3v1zm2.4 0h-1.7V3.5h1.7v3.4a3.7 3.7 0 01.2-.1 2.8 2.8 0 013.4 0l.4.4.2.7V13h-1.6V9.3 8.1l-.4-.6-.6-.2a1 1 0 00-.4.1 2 2 0 00-.4.2l-.3.3a3 3 0 00-.3.5l-.1.5-.1.9V13zm5.4-6.6H44V13h-1.6V6.4zm-.8-.9l1.8-2h1.8l-2.1 2h-1.5zm7.7 5.8H51v.5l-.4.5a2 2 0 01-.4.4l-.6.3-1.4.2c-.5 0-1 0-1.4-.2l-1-.7c-.3-.3-.5-.7-.6-1.2-.2-.4-.3-.9-.3-1.4 0-.5.1-1 .3-1.4a2.6 2.6 0 011.6-1.8c.4-.2.9-.3 1.4-.3.6 0 1 .1 1.5.3.4.1.7.4 1 .6l.2.5.1.5h-1.6c0-.3-.1-.5-.3-.6-.2-.2-.4-.3-.8-.3s-.8.2-1.2.6c-.3.4-.4 1-.4 2 0 .9.1 1.5.4 1.8.4.4.8.6 1.2.6h.5l.3-.2.2-.3v-.4zm4 1.7h-1.6V3.5h1.7v3.4a3.7 3.7 0 01.2-.1 2.8 2.8 0 013.4 0l.3.4.3.7V13h-1.6V9.3L56 8.1c-.1-.3-.2-.5-.4-.6l-.6-.2a1 1 0 00-.3.1 2 2 0 00-.4.2l-.3.3a3 3 0 00-.3.5l-.2.5V13z">
                                                    </path>
                                                </g>
                                                <g clip-path="url(#clip1)">
                                                    <path fill="#fff"
                                                        d="M63 8.2h2.2v1.6H63V12h-1.6V9.8h-2.2V8.2h2.2V6H63v2.3z"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0">
                                                        <path fill="#fff" d="M0 0h55v16H0z" transform="translate(4)">
                                                        </path>
                                                    </clipPath>
                                                    <clipPath id="clip1">
                                                        <path fill="#fff" d="M0 0h7v16H0z" transform="translate(59)">
                                                        </path>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="UDaMW3" tabindex="0">
                                            {{ $orderDetail->productVariant->product->User->fullname }}</div>

                                        <a class="Mr26O7"
                                            href="{{ route('order_detail', ['id' => $orderDetail->order->id]) }}">
                                            <div class="stardust-button">
                                                <svg enable-background="new 0 0 15 15" viewBox="0 0 15 15" x="0" y="0"
                                                    class="shopee-svg-icon icon-btn-shop">
                                                    <path
                                                        d="m15 4.8c-.1-1-.8-2-1.6-2.9-.4-.3-.7-.5-1-.8-.1-.1-.7-.5-.7-.5h-8.5s-1.4 1.4-1.6 1.6c-.4.4-.8 1-1.1 1.4-.1.4-.4.8-.4 1.1-.3 1.4 0 2.3.6 3.3l.3.3v3.5c0 1.5 1.1 2.6 2.6 2.6h8c1.5 0 2.5-1.1 2.5-2.6v-3.7c.1-.1.1-.3.3-.3.4-.8.7-1.7.6-3zm-3 7c0 .4-.1.5-.4.5h-8c-.3 0-.5-.1-.5-.5v-3.1c.3 0 .5-.1.8-.4.1 0 .3-.1.3-.1.4.4 1 .7 1.5.7.7 0 1.2-.1 1.6-.5.5.3 1.1.4 1.6.4.7 0 1.2-.3 1.8-.7.1.1.3.3.5.4.3.1.5.3.8.3zm.5-5.2c0 .1-.4.7-.3.5l-.1.1c-.1 0-.3 0-.4-.1s-.3-.3-.5-.5l-.5-1.1-.5 1.1c-.4.4-.8.7-1.4.7-.5 0-.7 0-1-.5l-.6-1.1-.5 1.1c-.3.5-.6.6-1.1.6-.3 0-.6-.2-.9-.8l-.5-1-.7 1c-.1.3-.3.4-.4.6-.1 0-.3.1-.3.1s-.4-.4-.4-.5c-.4-.5-.5-.9-.4-1.5 0-.1.1-.4.3-.5.3-.5.4-.8.8-1.2.7-.8.8-1 1-1h7s .3.1.8.7c.5.5 1.1 1.2 1.1 1.8-.1.7-.2 1.2-.5 1.5z">
                                                    </path>
                                                </svg>
                                                <span>Xem Shop</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="jgIyoX" style="    align-items: center;display: flex; padding: 0 0 0 10px;">
                                        @if( $orderDetail->status == 5)
                                        <div class="LY5oll"
                                            style="    align-items: center; border-right: 1px solid rgba(0, 0, 0, .12);display: flex;margin: 0 10px 0 0; padding: 0 5px 0 0;text-align: right;">
                                            <a class="lXbYsi" ><span
                                                    class="O2yAdQ">
                                                    <svg enable-background="new 0 0 15 15" viewBox="0 0 15 15" x="0" y="0"
                                                        class="shopee-svg-icon icon-free-shipping-line">
                                                        <g>
                                                            <line fill="none" stroke-linejoin="round"
                                                                stroke-miterlimit="10" x1="8.6" x2="4.2"
                                                                y1="9.8" y2="9.8"></line>
                                                            <circle cx="3" cy="11.2" fill="none" r="2"
                                                                stroke-miterlimit="10"></circle>
                                                            <circle cx="10" cy="11.2" fill="none" r="2"
                                                                stroke-miterlimit="10"></circle>
                                                            <line fill="none" stroke-miterlimit="10" x1="10.5"
                                                                x2="14.4" y1="7.3" y2="7.3"></line>
                                                            <polyline fill="none"
                                                                points="1.5 9.8 .5 9.8 .5 1.8 10 1.8 10 9.1"
                                                                stroke-linejoin="round" stroke-miterlimit="10"></polyline>
                                                            <polyline fill="none"
                                                                points="9.9 3.8 14 3.8 14.5 10.2 11.9 10.2"
                                                                stroke-linejoin="round" stroke-miterlimit="10"></polyline>
                                                        </g>
                                                    </svg> {{ App\Common\Constants::STATUS_ORDER[$orderDetail->status] }}</span></a>
                                            <div class="shopee-drawer" id="pc-drawer-id-4" tabindex="0">
                                                <svg enable-background="new 0 0 15 15" viewBox="0 0 15 15" x="0" y="0"
                                                    class="shopee-svg-icon icon-help">
                                                    <g>
                                                        <circle cx="7.5" cy="7.5" fill="none" r="6.5"
                                                            stroke-miterlimit="10"></circle>
                                                        <path
                                                            d="m5.3 5.3c.1-.3.3-.6.5-.8s.4-.4.7-.5.6-.2 1-.2c.3 0 .6 0 .9.1s.5.2.7.4.4.4.5.7.2.6.2.9c0 .2 0 .4-.1.6s-.1.3-.2.5c-.1.1-.2.2-.3.3-.1.2-.2.3-.4.4-.1.1-.2.2-.3.3s-.2.2-.3.4c-.1.1-.1.2-.2.4s-.1.3-.1.5v.4h-.9v-.5c0-.3.1-.6.2-.8s.2-.4.3-.5c.2-.2.3-.3.5-.5.1-.1.3-.3.4-.4.1-.2.2-.3.3-.5s.1-.4.1-.7c0-.4-.2-.7-.4-.9s-.5-.3-.9-.3c-.3 0-.5 0-.7.1-.1.1-.3.2-.4.4-.1.1-.2.3-.3.5 0 .2-.1.5-.1.7h-.9c0-.3.1-.7.2-1zm2.8 5.1v1.2h-1.2v-1.2z"
                                                            stroke="none"></path>
                                                    </g>
                                                </svg>
                                            </div>
                                        </div>
                                        @else

                                        <div class="bv3eJE" tabindex="0">
                                            {{ App\Common\Constants::STATUS_ORDER[$orderDetail->status] }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    @php $variantValues = json_decode($orderDetail->productVariant->variant_value, true); @endphp
                                    <div class="shoping__cart__item d-flex justify-content-start" style="">
                                        <img style="width: 8%; height:88px"
                                            src="{{ asset('storage/' . $variantValues['image']) }}"
                                            alt="Mr. Saul Padberg I">
                                        <div style="margin-left: 2%;     width: 82%;">
                                            <h5>
                                                <b>{{ $orderDetail->name }}</b>
                                            </h5>
                                            <div>
                                                <div class="d-flex justify-content-start">Phân loại hàng :
                                                    @foreach ($variantValues as $key => $variantValue)
                                                        @if ($key == 'color')
                                                            <div class="square ml-2"></div>
                                                        @elseif($key != 'quantity' && $key != 'price' && $key != 'image')
                                                            <span class=" ml-2"> {{ $variantValue }}</span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <b>x{{ $orderDetail->quantity }}</b>
                                        </div>
                                        <div style="margin-left: 2%;     width: 10%;">
                                            <h5>
                                                <p class="text-danger">
                                                    {{ number_format($orderDetail->price, 0, ',', '.') . ' ₫' }}</p>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-muted">
                                    <div class="NWUSQP"><span class="R_ufN9">
                                            <div class="afBScK" tabindex="0"><svg width="16" height="17"
                                                    viewBox="0 0 253 263" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <title>Shopee Guarantee</title>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M126.5 0.389801C126.5 0.389801 82.61 27.8998 5.75 26.8598C5.08763 26.8507 4.43006 26.9733 3.81548 27.2205C3.20091 27.4677 2.64159 27.8346 2.17 28.2998C1.69998 28.7657 1.32713 29.3203 1.07307 29.9314C0.819019 30.5425 0.688805 31.198 0.689995 31.8598V106.97C0.687073 131.07 6.77532 154.78 18.3892 175.898C30.003 197.015 46.7657 214.855 67.12 227.76L118.47 260.28C120.872 261.802 123.657 262.61 126.5 262.61C129.343 262.61 132.128 261.802 134.53 260.28L185.88 227.73C206.234 214.825 222.997 196.985 234.611 175.868C246.225 154.75 252.313 131.04 252.31 106.94V31.8598C252.31 31.1973 252.178 30.5414 251.922 29.9303C251.667 29.3191 251.292 28.7649 250.82 28.2998C250.35 27.8358 249.792 27.4696 249.179 27.2225C248.566 26.9753 247.911 26.852 247.25 26.8598C170.39 27.8998 126.5 0.389801 126.5 0.389801Z"
                                                        fill="#ee4d2d"></path>
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M207.7 149.66L119.61 107.03C116.386 105.472 113.914 102.697 112.736 99.3154C111.558 95.9342 111.772 92.2235 113.33 88.9998C114.888 85.7761 117.663 83.3034 121.044 82.1257C124.426 80.948 128.136 81.1617 131.36 82.7198L215.43 123.38C215.7 120.38 215.85 117.38 215.85 114.31V61.0298C215.848 60.5592 215.753 60.0936 215.57 59.6598C215.393 59.2232 215.128 58.8281 214.79 58.4998C214.457 58.1705 214.063 57.909 213.63 57.7298C213.194 57.5576 212.729 57.4727 212.26 57.4798C157.69 58.2298 126.5 38.6798 126.5 38.6798C126.5 38.6798 95.31 58.2298 40.71 57.4798C40.2401 57.4732 39.7735 57.5602 39.3376 57.7357C38.9017 57.9113 38.5051 58.1719 38.1709 58.5023C37.8367 58.8328 37.5717 59.2264 37.3913 59.6604C37.2108 60.0943 37.1186 60.5599 37.12 61.0298V108.03L118.84 147.57C121.591 148.902 123.808 151.128 125.129 153.884C126.45 156.64 126.797 159.762 126.113 162.741C125.429 165.72 123.755 168.378 121.363 170.282C118.972 172.185 116.006 173.221 112.95 173.22C110.919 173.221 108.915 172.76 107.09 171.87L40.24 139.48C46.6407 164.573 62.3785 186.277 84.24 200.16L124.49 225.7C125.061 226.053 125.719 226.24 126.39 226.24C127.061 226.24 127.719 226.053 128.29 225.7L168.57 200.16C187.187 188.399 201.464 170.892 209.24 150.29C208.715 150.11 208.2 149.9 207.7 149.66Z"
                                                        fill="#fff"></path>
                                                </svg></div>
                                        </span><label class="juCcT0">Thành tiền:</label>
                                        <div class="t7TQaf" tabindex="0"
                                            aria-label="Thành tiền: {{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') . ' ₫' }}">
                                            {{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') . ' ₫' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg-{{ $orderDetail->id }}" id="exampleModal"
                                tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog  modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Mã đơn hàng:
                                                {{ $orderDetail->id }}</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Sản phẩm</th>
                                                        <th scope="col">Giá</th>
                                                        <th scope="col">Số lượng</th>
                                                        <th scope="col">Trạng thái</th>
                                                        <th scope="col">Số tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <h5>{{ $orderDetail->name }}</h5>
                                                        </td>
                                                        <td>
                                                            <h5> {{ number_format($orderDetail->price, 0, ',', '.') . ' ₫' }}
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5> {{ $orderDetail->quantity }}</h5>
                                                        </td>
                                                        <td>

                                                            <h5>{{ App\Common\Constants::STATUS_ORDER[$orderDetail->status] }}
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <h5> {{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') . ' ₫' }}
                                                            </h5>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="d-flex justify-content-start">Phân loại hàng :

                                                                @foreach ($variantValues as $key => $variantValue)
                                                                    @if ($key == 'color')
                                                                        |<div class="square ml-2"></div>
                                                                    @elseif($key != 'quantity' && $key != 'price' && $key != 'image')
                                                                        <span class=" ml-2">| {{ $variantValue }}</span>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div id="accordion-{{ $orderDetail->id }}">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne-{{ $orderDetail->id }}">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link" data-toggle="collapse"
                                                                data-target="#collapseOne-{{ $orderDetail->id }}" aria-expanded="false"
                                                                aria-controls="collapseOne-{{ $orderDetail->id }}">
                                                                Hóa đơn
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div id="collapseOne-{{ $orderDetail->id }}" class="collapse hidden"
                                                        aria-labelledby="headingOne-{{ $orderDetail->id }}" data-parent="#accordion-{{ $orderDetail->id }}">
                                                        <div class="card-body">
                                                            <div class="col-lg-12">
                                                                <div class="shoping__checkout">
                                                                    <ul>
                                                                        <li>Tổng tiền hàng
                                                                            <span>{{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') . ' ₫' }}</span>
                                                                        </li>
                                                                        <li>Giảm giá <span> - 0 ₫</span></li>
                                                                        <li>Thành tiền
                                                                            <span>{{ number_format($orderDetail->price * $orderDetail->quantity, 0, ',', '.') . ' ₫' }}</span>
                                                                        </li>
                                                                        <li>Thời gian đặt 
                                                                            <span>{{ $orderDetail->created_at }}</span>
                                                                        </li>
                                                                        <li>Phương thức thanh toán
                                                                            <span>{{ $orderDetail->order->payment_method == 'card' ? 'Đã thanh toán thẻ' : 'Thanh toán khi nhân hàng' }}</span>
                                                                        </li>
                                                                        <li>Tên khách hàng
                                                                            <span>{{ $orderDetail->order->fullname }}</span>
                                                                        </li>
                                                                        <li>Số điện thoại
                                                                            <span>{{ $orderDetail->order->phone }}</span>
                                                                        </li>
                                                                        <li>Địa chỉ giao hàng
                                                                            <span>{{ $orderDetail->order->address }}</span>
                                                                        </li>
                                                                        <li>Ghi chú
                                                                            <span>{{ $orderDetail->order->note }}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                                @if($orderDetail->status < 2)
                                                <div type="button" class="btn btn-primary"  onclick="cancelProduct({{$orderDetail->id}})">Hủy sản phẩm</div>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Shoping Cart Section End -->
    <style>
        .square {
            width: 2%;
            /* Đặt độ rộng của hình vuông */
            height: 18px;
            /* Đặt chiều cao của hình vuông */
            background-color: red;
            /* Đặt màu nền là đỏ */
        }

        .lXbYsi {
            align-items: center;
            display: inline-flex;
            margin: 0;
        }

        .O2yAdQ {
            color: rgba(0, 0, 0, .87);
            color: #26aa99;
            -webkit-text-decoration: none;
            text-decoration: none;
            vertical-align: middle;
        }

        .LY5oll .icon-free-shipping-line {
            color: #00bfa5;
            font-size: 1rem;
            margin: 0 4px 1px 0;
            vertical-align: middle;
            stroke: #26aa99;
        }

        .LY5oll .shopee-drawer {
            display: inline-flex;
            margin: 0 0 0 6px;
            vertical-align: middle;
        }

        .LY5oll .icon-help,
        .lXbYsi {
            vertical-align: middle;
        }

        .shopee-drawer .icon-help {
            stroke: currentColor;
        }

        .bv3eJE {
            color: #ee4d2d;
            line-height: 24px;
            text-align: right;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .shopee-svg-icon {
            display: inline-block;
            height: 1em;
            width: 1em;
            fill: currentColor;
            position: relative;
        }

        svg:not(:root) {
            overflow: hidden;
        }

        .RBPP9y {
            align-items: center;
            display: flex;
            white-space: nowrap;
        }

        .Koi0Pw,
        .P2JMvg {
            align-items: center;
            display: flex;
        }

        .UDaMW3 {
            font-size: 14px;
            font-weight: 600;
            margin-left: 8px;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .B2SOGC,
        .Mr26O7,
        .UDaMW3 {
            margin: 0 0 0 8px;
        }

        .B2SOGC>.stardust-button:not(.stardust-button--primary),
        .Mr26O7>.stardust-button:not(.stardust-button--primary) {
            border: 1px solid rgba(0, 0, 0, .09);
            color: #555;
        }

        .B2SOGC>.stardust-button,
        .Mr26O7>.stardust-button {
            border: 1px solid transparent;
            border-radius: 2px;
            font-size: 12px;
            outline: none;
            padding: 4px 8px;
            text-transform: capitalize;
        }

        .Mr26O7>.stardust-button>svg {
            vertical-align: middle;
        }

        .B2SOGC>.stardust-button>span,
        .Mr26O7>.stardust-button>span {
            margin: 0 0 0 4px;
        }

        a:active,
        a:hover {
            outline: 0;
        }

        .NWUSQP {
            align-items: center;
            display: flex;
            justify-content: flex-end;
        }

        .R_ufN9 {
            cursor: pointer;
        }

        .afBScK {
            cursor: pointer;
            line-height: 0;
            margin: 0 5px 0 0;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        .juCcT0 {
            color: rgba(0, 0, 0, .8);
            font-size: 14px;
            line-height: 20px;
            margin: 0 10px 0 0;
        }

        .t7TQaf {
            color: #ee4d2d;
            font-size: 24px;
            line-height: 30px;
        }
    </style>

@endsection

@section('javascript')

    <script>
            function cancelProduct(id) {
        const url = '/api/orders/update/' + id;
        let status = 6;
        let _token = $("input[name=_token]").val();
        let data = { status, _token };
        swal({
            title: "Bạn có chắc không?",
            text: " ",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "post",
                        url: url,
                        data: data,
                        success: function(res) {
                            console.log(res.status)
                            if (res.status == 200) {
                                swal("Tệp của bạn đã được thay đổi!", {
                                    icon: "success",
                                }).then(function() {
                                    location.reload();
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
        $("#submit-updateCarts").on("click", function(e) {
            $("form[name='updateCarts']").trigger("submit");
        });
        $("#checkout").on("click", function(e) {
            $("form[name='checkout']").trigger("submit");
        });
    </script>
@endsection
