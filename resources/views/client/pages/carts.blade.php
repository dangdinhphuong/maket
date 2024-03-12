@extends('client.master')
@section('title', 'Siêu thị thực phẩm')
@section('content')

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Đơn giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Số Tiền</th>
                                    <th scope="col">Thao Tác</th>
                                </tr>
                            </thead>
                            <form name="updateCarts" action="{{ route('updateCarts') }}" method="post">
                                @csrf
                                <tbody>
                                    @foreach ($carts as $cart)
                                        <input type="hidden" name="id[]" value="{{ $cart->id }}">
                                        <tr  id="pro{{ $cart->product_id }}">
                                            <td class="shoping__cart__item d-flex justify-content-start" style='width: 450px;'>
                                                <img style="width: 20%; height:120px"
                                                    src="{{ asset('storage/' . $cart->products->image) }}"
                                                    alt="{{ $cart->products->namePro }}">
                                                <div>
                                                    <h5>
                                                        <b>{{ $cart->products->namePro }} </b>
                                                    </h5>
                                                    <br>
                                                    @if(!empty($cart->productVariant))
                                                    <div class="header__top__right__language">
                                                        <div>Phân loại: <b> {{$cart->productVariant->variant_type}}</b></div>
                                                        @php dd($cart->productVariant->variant_value);
                                                         foreach($cart->productVariant as $key => $productVariant){
                                                              
                                                         }
                                                        @endphp
                                                        <span class="arrow_carrot-down"></span>
                                                        <ul style="color: #ffffff">
                                                            <li><a>Color: <span
                                                                        style="background-color: red; border-radius: 4px; color:red; font-size: 8px">
                                                                        #fff</span></a></li>
                                                            <li><a>Size: X</a></li>
                                                        </ul>
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class=" shoping__cart__price">
                                                {{ number_format(ceil($cart->products->price - ($cart->products->price * $cart->products->discounts) / 100), 0, ',', '.') . ' ₫' }}
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <input type="text" name="quantity[]" value="{{ (int) $cart->quantity }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class=" shoping__cart__price">
                                                {{ number_format(ceil($cart->products->price - ($cart->products->price * $cart->products->discounts) / 100), 0, ',', '.') . ' ₫' }}
                                            </td>
                                            <td class="shoping__cart__item__close" style="text-align: right;">
                                                {{-- <span class="icon_close" onclick="removeCart(50)"> xóa</span> --}}
                                                <div class='site-btn' onclick="removeCart(50)"><b>Xóa</b></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </form>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="{{ route('home') }}" class="primary-btn cart-btn">Tiếp tục mua sắm</a>
                        <button class="primary-btn cart-btn cart-btn-right" {{ $carts->count() <= 0 ? 'disabled' : '' }}
                            id="submit-updateCarts"></span>
                            Cập nhật giỏ hàng
                        </button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="shoping__checkout">
                        <h5>Tổng số giỏ hàng</h5>
                        <ul>
                            <li>Tạm tính <span>{{ number_format(ceil($totalMoney), 0, ',', '.') . ' ₫' }}</span></li>
                            <li>Tổng tiền <span>{{ number_format(ceil($totalMoney), 0, ',', '.') . ' ₫' }}</span></li>
                        </ul>
                        <a id="{{ $carts->count() <= 0 ? 'checkout1' : '' }}"
                            href="{{ $carts->count() <= 0 ? '#' : route('payment') }}" class="primary-btn">Mua hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@endsection
@section('javascript')

    <script>
        $('.shoping__cart__item h5 b').each(function() {
            $(this).text(truncateText($(this).text(), 70))
        })

        function truncateText(text, maxLength) {
            if (text.length <= maxLength) {
                return text;
            }
            var truncatedText = text.substring(0, maxLength - 3);
            truncatedText += " ...";

            return truncatedText;
        }
    </script>
    <script>
        $("#submit-updateCarts").on("click", function(e) {
            $("form[name='updateCarts']").trigger("submit");
        });
        $("#checkout").on("click", function(e) {
            $("form[name='checkout']").trigger("submit");
        });
    </script>
    @if ($carts->count() <= 0)
        <script>
            $("#checkout1").on("click", function(e) {
                swal("Giỏ hàng còn trống ", "Vui lòng thêm sản phẩm vào giỏ nhàng", "error", {
                    button: "OK",
                })
            });
        </script>
    @endif
    <script>
        var proQty = $('.pro-qty');
        proQty.prepend('<span class="dec qtybtn">-</span>');
        proQty.append('<span class="inc qtybtn">+</span>');
        proQty.on('click', '.qtybtn', function() {
            var $button = $(this);
            var oldValue = $button.parent().find('input').val();
            if ($button.hasClass('inc')) {
                var newVal = parseFloat(oldValue) + 1;
            } else {
                // Don't allow decrementing below zero
                if (oldValue > 0) {
                    var newVal = parseFloat(oldValue) - 1;
                } else {
                    newVal = 0;
                }
            }
            $button.parent().find('input').val(newVal);
        });
    </script>

@endsection
