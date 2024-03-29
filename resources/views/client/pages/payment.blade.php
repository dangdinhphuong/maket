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
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Giảm giá</th>
                                <th>Tổng tiền</th>
                                <th></th>
                            </tr>
                            </thead>
                            <form name="updateCarts" action="{{route('updateCarts')}}" method="post">
                                @csrf

                                <tbody>
                                @foreach($carts as $cart)
                                    @php $price = ceil($cart->products->price -(($cart->products->price * $cart->products->discounts )/100)); @endphp
                                    <input type="hidden" name="id[]" value="{{$cart->id}}">
                                    <tr id="pro{{$cart->product_id }}">
                                        <td>
                                            <h5>{{$cart->products->namePro}}</h5>
                                        </td>
                                        <td>
                                            <h5>{{$cart->quantity}}</h5>
                                        </td>
                                        <td >
                                            {{ number_format($price , 0, ',', '.') . " ₫"   }}
                                        </td>
                                        <td id="sale-{{ $cart->id  }}">
                                            {{ number_format(0 , 0, ',', '.') . " ₫"   }}
                                        </td>
                                        <td id="totalPrice-{{ $cart->id  }}">
                                            {{ number_format($price*$cart->quantity , 0, ',', '.') . " ₫"   }}
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

                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <div class="checkout__form">
                            <form action="{{route('checkout')}}" method="post" name="checkout">
                                @csrf

                                <div class="row mt-2">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <div class="form-inline" style="width: 100%">
                                                <input class="form-control mr-sm-2" id="voucher"style="width: 80%" name='voucher'type="search" placeholder="Thêm mã giảm giá"
                                                       aria-label="Thêm mã giảm giá">
                                                <div class="btn btn-outline-success my-2 my-sm-0" onclick="checkVoucher()">Add</div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="checkout__input">
                                                    <p>Tên người nhận<span>*</span></p>
                                                    <input type="text" name="fullname"
                                                           value="{{ old('fullname',auth()->user()->fullname ?? null) }}"
                                                           placeholder="Tên người nhận">
                                                    @error('fullname')<span
                                                        class="text-danger">{{$message}}</span>@enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="checkout__input">
                                                    <p>Số điện thoại<span>*</span></p>
                                                    <input type="text" name="phone"
                                                           value="{{ old('phone',auth()->user()->phone ?? null) }}"
                                                           placeholder="Số điện thoại người nhận">
                                                    @error('phone')<span
                                                        class="text-danger">{{$message}}</span>@enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="checkout__input">
                                            <p>Địa chỉ<span>*</span></p>
                                            <input type="text" name="address"
                                                   value="{{ old('address',auth()->user()->address ?? null) }}"
                                                   placeholder="Địa chỉ người nhận">
                                            @error('address')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                        <div class="checkout__input">
                                            <p>Ghi chú<span>*</span></p>

                                            <textarea name="note" class="w-100" rows="5">
                                        {{ old('note') }}
                                        </textarea>
                                            @error('note')<span class="text-danger">{{$message}}</span>@enderror
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="cash" checked>
                                            <label class="form-check-label" for="exampleRadios1">
                                                Thanh toán khi nhận hàng
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="vnpay" value="option2">
                                            <label class="form-check-label" for="exampleRadios2">
                                               Thanh toán vnpay
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shoping__checkout">

                        <br>
                        <h5>Tổng số giỏ hàng</h5>
                        <ul>
                            <li>Tạm tính <span>{{number_format(ceil($totalMoney), 0, ',', '.') . " ₫"}}</span></li>
                            <li>Giảm giá <span id ='totalDiscount'>0</span></li>
                            <li>Tổng tiền <span id ='totalPricePay'>{{number_format(ceil($totalMoney), 0, ',', '.') . " ₫"}}</span></li>
                        </ul>
                        <a id="{{ $carts->count() <=0 ? 'checkout1' : 'checkout' }}" class="primary-btn">Mua hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@endsection
@section('javascript')


    <script>
        const carts = {!! json_encode($carts, true) !!};
        let totalDiscount = 0;
        let totalPricePay = {!! ceil($totalMoney) !!};

        function checkVoucher() {
            const url = '/check-voucher';
            let voucher = $("#voucher").val();
            let _token = $("input[name=_token]").val();
            let data = { voucher, _token };
            $.ajax({
                type: "post",
                url: url,
                data: data,
                success: function(res) {
                    if (res.status == 200) {
                        $.each(carts, function(index, item) {

                            if (res.data.products_id.includes(item.product_id.toString())) {
                                const price = Math.ceil(item.products.price * (1 - item.products.discounts / 100));
                                const totalPriceBeforeDiscount = price * item.quantity; // tổng tiền

                                const discountMultiplier = 1 - (res.data.discount_percent / 100);

                                const totalPriceAfterDiscount = Math.ceil(totalPriceBeforeDiscount * discountMultiplier);

                                const discountAmount = totalPriceBeforeDiscount - totalPriceAfterDiscount;

                                console.log(price,totalPriceBeforeDiscount,discountMultiplier,totalPriceAfterDiscount)

                                const formattedAmount = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalPriceAfterDiscount);
                                const formattedDiscountAmount = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(discountAmount);
                                totalDiscount += discountAmount;
                                $(`#sale-${item.id}`).text("- "+formattedDiscountAmount);
                                $(`#totalPrice-${item.id}`).text(formattedAmount);
                            }
                            $(`#totalDiscount`).text("- " + new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalDiscount));
                            $(`#totalPricePay`).text(new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalPricePay - totalDiscount));
                        });
                    } else {
                        swal(res.message, {
                            icon: "error",
                        });
                    }
                }
            });
        }
        $("#submit-updateCarts").on("click", function (e) {
            $("form[name='updateCarts']").trigger("submit");
        });
        $("#checkout").on("click", function (e) {
            $("form[name='checkout']").trigger("submit");
        });
    </script>
    @if($carts->count() <=0)
        <script>
            $("#checkout1").on("click", function (e) {
                swal("Giỏ hàng còn trống ", "Vui lòng thêm sản phẩm vào giỏ nhàng", "error", {
                    button: "OK",
                })
            });
        </script>
    @endif
@endsection
