@extends('client.master')
@section('title', 'Siêu thị thực phẩm')
@section('content')

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table" style="background: #f5f5f5;">
                    <table>
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Số tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        @php $totalPrice = $provisionalMoney = 0; @endphp
                        <tbody>
                            @foreach($Orders->order_detail as $Order)
                                @if($Order->status != 6)
                                    @php $provisionalMoney += $Order->price * $Order->quantity;  $totalPrice += $Order->totalPrice; @endphp
                                    @endif
                            <tr>
                                <td>
                                    <img src="img/cart/cart-1.jpg" alt="">
                                    <h5>{{$Order->name}}</h5>
                                </td>
                                <td>
                                    <h5> {{ number_format($Order->price, 0, ',', '.') . " ₫"   }}</h5>
                                </td>
                                <td>
                                    <h5> {{$Order->quantity}}</h5>
                                </td>
                                <td>

                                    <h5> {{ App\Common\Constants::STATUS_ORDER[$Order->status] }}</h5>
                                </td>
                                <td>
                                    <h5> {{ number_format($Order->price * $Order->quantity, 0, ',', '.') . " ₫"   }}</h5>
                                </td>
                                @if($Order->status < 2)
                                <td>
                                    <button type="button" class="btn btn-warning" onclick="cancelProduct({{$Order->id}})">Hủy sản phẩm</button>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Hóa đơn</h5>
                    <ul>
                        <li>Tổng tiền tạm tính <span>{{ number_format($provisionalMoney, 0, ',', '.') . " ₫"   }}</span></li>
                        <li>Giảm giá <span> - {{ number_format($provisionalMoney - $totalPrice, 0, ',', '.') . " ₫"   }}</span></li>
                        <li>Tổng tiền thanh toán <span>{{ number_format($totalPrice, 0, ',', '.') . " ₫"   }}</span></li>
                        <li>Phương thức thanh toán <span>Thanh toán khi nhân hàng</span></li>
                        <li>Trạng thái <span>{{ App\Common\Constants::STATUS_ORDER[$Orders->status] }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Thông tin giao hàng</h5>
                    <ul>
                        <li>Tên khách hàng <span>{{$Orders->fullname}}</span></li>
                        <li>Số điện thoại <span>{{$Orders->phone}}</span></li>
                        <li>Địa chỉ giao hàng <span>{{$Orders->address}}</span></li>
                        <li>Ghi chú  <span>{{$Orders->note}}</span></li>
                    </ul>
                </div>
            </div>
        </div>
        @csrf
    </div>
</section>
<!-- Shoping Cart Section End -->


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
