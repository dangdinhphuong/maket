@extends('client.master')
@section('title', 'Siêu thị thực phẩm')
@section('content')

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                            <tr>
                                <th class="shoping__product">Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>

                                <th></th>
                            </tr>
                            </thead>
                            <form name="updateCarts" action="{{route('updateCarts')}}" method="post">
                                @csrf

                                <tbody>
                                @foreach($carts as $cart)

                                    <input type="hidden" name="id[]" value="{{$cart->id}}">
                                    <tr id="pro{{$cart->product_id }}">
                                        <td class="shoping__cart__item">
                                            <img style="width: 20%;" src="{{asset('storage/' .$cart->products->image)}}" alt="">
                                            <h5>{{$cart->products->namePro}}</h5>
                                        </td>
                                        <td style="width: 30%;" class=" shoping__cart__price">
                                            {{ number_format(ceil($cart->products->price-(($cart->products->price * $cart->products->discounts )/100)), 0, ',', '.') . " ₫"   }}
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" name="quantity[]" value="{{(int)$cart->quantity}}">
                                                </div>
                                            </div>
                                        </td>
                                        <!-- <td class="shoping__cart__total">
                                        $110.00 * (int)$cart->quantity
                                    </td> -->
                                        <td class="shoping__cart__item__close">
                                            <span class="icon_close" onclick="removeCart({{$cart->product_id }})"></span>
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
                        <a href="{{route('home')}}" class="primary-btn cart-btn">Tiếp tục mua sắm</a>
                        <button class="primary-btn cart-btn cart-btn-right" {{ $carts->count() <=0 ? "disabled" : "" }} id="submit-updateCarts"></span>
                            Cập nhật giỏ hàng</button>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="shoping__checkout">
                        <h5>Tổng số giỏ hàng</h5>
                        <ul>
                            <li>Tạm tính <span>{{number_format(ceil($totalMoney), 0, ',', '.') . " ₫"}}</span></li>
                            <li>Tổng tiền <span>{{number_format(ceil($totalMoney), 0, ',', '.') . " ₫"}}</span></li>
                        </ul>
                        <a id="{{ $carts->count() <=0 ? 'checkout1' : '' }}"
                           href="{{ $carts->count() <=0 ? '#' : route('payment') }}"
                           class="primary-btn">Mua hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@endsection
@section('javascript')


    <script>
        $("#submit-updateCarts").on("click", function(e) {
            $("form[name='updateCarts']").trigger("submit");
        });
        $("#checkout").on("click", function(e) {
            $("form[name='checkout']").trigger("submit");
        });
    </script>
    @if($carts->count() <=0) <script>
        $("#checkout1").on("click", function(e) {
            swal("Giỏ hàng còn trống ", "Vui lòng thêm sản phẩm vào giỏ nhàng", "error", {
                button: "OK",
            })
        });
        
    </script>
    @endif
@endsection
