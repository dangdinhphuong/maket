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
                                    {{--                                <th scope="col"><input type="checkbox" class="form-check-input checkbox-prod-all" style="margin-top: -1%;"></th> --}}
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
                                        @php $variantValues = json_decode($cart->productVariant->variant_value, true); @endphp
                                        <tr id="pro{{ $cart->product_id }}">
                                            {{--                                        <th scope="row"> <input type="checkbox" class="form-check-input checkbox-prod-detail" name="id[]" value="{{ $cart->id }}"></th> --}}
                                            <input type="hidden" class="form-check-input checkbox-prod-detail"
                                                name="id[]" value="{{ $cart->id }}">
                                            <td class="shoping__cart__item d-flex justify-content-start"
                                                style='width: 450px;'>
                                                <img style="width: 20%; height:120px"
                                                    src="{{ asset('storage/' . $variantValues['image']) }}"
                                                    alt="{{ $cart->products->namePro }}">
                                                <div>
                                                    <h5>
                                                        <a style="color:black;" href="{{route('products').'?search='. $cart->products->namePro}}"> <b>{{ $cart->products->namePro }}</b></a>
                                                    </h5>
                                                    <br>
                                                    @if (!empty($cart->productVariant) && $cart->productVariant->type != 1)
                                                        <div class="header__top__right__language">
                                                            <div>Phân loại: <b>
                                                                    {{ $cart->productVariant->variant_type }}</b>
                                                            </div>

                                                            <span class="arrow_carrot-down"></span>
                                                            <ul style="background:#f1f1f1; color: #0d0d0d;width: 200px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);" class="border border-secondary">
                                                                @foreach ($variantValues as $key => $item)
                                                                    @if ($key == 'color')
                                                                        <li>
                                                                            <a style="color: black;">{{ $key }}:
                                                                                <span
                                                                                    style="background-color: {{ $item }}; border-radius: 4px; color:{{ $item }}; font-size: 8px">{{ $item }}
                                                                                </span>
                                                                            </a>
                                                                        </li>
                                                                    @elseif ($key != 'image' && $key != 'quantity' && $key != 'price' && $key != 'name')
                                                                        <li >
                                                                            <a  style="color: black;">{{ $key }}:
                                                                                {{ $item }}</a>
                                                                        </li>
                                                                    @endif
                                                                @endForeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class=" shoping__cart__price" style="width: 16%;"
                                                id="priceProdDetail-{{ $cart->id }}">
                                                @if (!empty($cart->productVariant))
                                                    {{ number_format(ceil($cart->productVariant->price), 0, ',', '.') . ' ₫' }}
                                                @else
                                                    {{ number_format(ceil($cart->products->price - ($cart->products->price * $cart->products->discounts) / 100), 0, ',', '.') . ' ₫' }}
                                                @endif
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <input type="text" name="quantity[]"
                                                            data-prod-id="{{ $cart->id }}"
                                                            value="{{ (int) $cart->quantity }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class=" shoping__cart__price allMoneyProdDetail" style="width: 16%;"
                                                id='allMoneyProdDetail-{{ $cart->id }}'>
                                                @if (!empty($cart->productVariant))
                                                    {{ number_format(ceil($cart->productVariant->price) * (int) $cart->quantity, 0, ',', '.') . ' ₫' }}
                                                @else
                                                    {{ number_format(ceil($cart->products->price - ($cart->products->price * $cart->products->discounts) / 100) * (int) $cart->quantity, 0, ',', '.') . ' ₫' }}
                                                @endif
                                            </td>
                                            <td class="shoping__cart__item__close" style="text-align: right;">
                                                {{-- <span class="icon_close" onclick="removeCart(50)"> xóa</span> --}}
                                                <div class='site-btn' onclick="removeCart({{ $cart->id }})"><b>Xóa</b>
                                                </div>
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
                        <a href="{{ route('home') }}" class="primary-btn cart-btn cart-btn-right">Tiếp tục mua sắm</a>
                        {{-- <button class="primary-btn cart-btn cart-btn-right" {{ $carts->count() <= 0 ? 'disabled' : '' }}
                            id="submit-updateCarts"></span>
                            Cập nhật giỏ hàng
                        </button> --}}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="shoping__checkout">
                        <h5>Tổng số giỏ hàng</h5>
                        <ul>
                            <li>Tạm tính <span class='totalAmount'></span></li>
                            <li>Tổng tiền <span class='totalAmount'></span></li>
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
        calculateTotalMoney();
        var proQty = $('.pro-qty');
        proQty.prepend('<span class="dec qtybtn">-</span>');
        proQty.append('<span class="inc qtybtn">+</span>');
        proQty.on('click', '.qtybtn', function() {
            var $button = $(this);
            var oldValue = $button.parent().find('input').val();
            var prodId = $button.parent().find('input').data('prod-id');
            var price = parseFloat($('#priceProdDetail-' + prodId).text().trim().replace('₫', '').replace('.', ''));
            console.log('prodId', prodId);


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
            updateProductCarts(prodId, newVal, function(result) {
                if (result) {
                    $button.parent().find('input').val(newVal);
                    var allMoney = price * newVal;
                    $('#allMoneyProdDetail-' + prodId).text(allMoney.toLocaleString('vi-VN') + ' ₫');
                    calculateTotalMoney();
                }
            });

        });

        function calculateTotalMoney() {
            let totalMoney = 0;
            $('.allMoneyProdDetail').each(function() {
                let moneyString = $(this).text().trim().replace('₫', '').replace(/\./g, '').replace(',', '.');
                let moneyValue = parseFloat(moneyString);
                console.log('moneyValue', moneyValue);
                totalMoney += moneyValue;
            });
            $('.totalAmount').text(totalMoney.toLocaleString('vi-VN') + ' ₫');
        }
    </script>
@endsection
