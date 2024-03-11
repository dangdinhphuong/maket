@extends('admin.master')
@section('title', "Sản phẩm ")
@section('style')
<style>
    .sreach {
        border: 1px solid black !important;
    }
</style>
@endsection
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thống kê</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Sản phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($products)}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Bài viết</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$Blogs}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Khách hàng
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$User}}</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        @if(auth()->user()->role_id != 3)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Đơn hàng
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($Order)}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Số lượng sản phẩm đã bán :
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($Order)}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Content Row -->

    <div class="row">
        <!-- Area Chart -->
        @if(auth()->user()->role_id != 3)
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Doanh số của các gian hàng</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên gian hàng</th>
                                <th>Chủ shop</th>
                                <th>Số lượng sản phẩm đã bán</th>
                                <th>Tồng sản phẩm</th>
                                <th>Doanh thu tổng</th>
                                <th>Trạng thái shop</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tên gian hàng</th>
                                <th>Chủ shop</th>
                                <th>Số lượng sản phẩm đã bán</th>
                                <th>Tồng sản phẩm</th>
                                <th>Doanh thu tổng</th>
                                <th>Trạng thái shop</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach( $shop as $item)
                                @php
                                $totalShop = 0;
                                    if(isset($item->user[0]) && $item->user[0]->orderDetail){
                                        foreach ($item->user[0]->orderDetail as $orderShop){
                                            $totalShop += $orderShop->price;
                                        }
                                    }
                                @endphp
                                <tr id="pro{{ $item->id }}">
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->user[0]->fullname ?? '' }}</td>
                                    <td>{{ isset($item->user[0]) && $item->user[0]->orderDetail ? count($item->user[0]->orderDetail) : 0 }}</td>
                                    <td>{{ isset($item->user[0]) && $item->user[0]->products ? count($item->user[0]->products) : 0 }}</td>
                                    <td>{{ number_format($totalShop, 0, ',', '.') . " ₫" }}</td>
                                    <td><span style="" class="btn {{ ($item->user[0]->status ?? 0) == 1 ? 'btn-primary' : 'btn-danger' }} w-100">
                                            {{ App\Common\Constants::STATUS_PRODUCTS[$item->user[0]->status ?? 0] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Kho hàng</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá nhập</th>
                            <th>Giá bán</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>

                            <th>Giá nhập</th>
                            <th>Giá bán</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach( $products as $product)
                            <tr id="pro{{ $product->id }}">
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->namePro }}</td>
                                <td>{{ number_format($product->cost, 0, ',', '.') . " ₫" }}</td>
                                <td>{{ number_format($product->price, 0, ',', '.') . " ₫" }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td><span style="" class="btn {{$product->status==1?'btn-primary':'btn-danger'}} w-100">{{ App\Common\Constants::STATUS_PRODUCTS[$product->status] }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Doanh số bán hàng</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Sản phẩm </th>
                            <th scope="col">Số lượng bán</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tổng tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $expectedTotalAmount = 0;
                            $totalAmountReceived = 0;
                        @endphp
                        @foreach($Order as $item)
                            @php
                                $expectedTotalAmount += $item->price;
                                $totalAmountReceived += $item->status == 5 ? $item->price :0;
                            @endphp
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ App\Common\Constants::STATUS_ORDER[$item->status] }}</td>
                            <td>{{ $item->status != 6 ? number_format($item->price, 0, ',', '.') . " ₫" :0 }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="5">
                                <b>Tồng tiền dự kiến</b> : {{ number_format($expectedTotalAmount, 0, ',', '.') . " ₫" }} <br>
                                <b>Tồng tiền đã nhận</b> : {{ number_format($totalAmountReceived, 0, ',', '.') . " ₫" }}
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>



</div>
<!-- /.container-fluid -->

@endsection
@section('javascript')

@if(session('message'))
<script>
    swal("Hành động", " {!! session('message') !!}", "success", {
        button: "OK",
    })
</script>
@endif
@if(session('error'))
<script>
    swal("Hành động", " {!! session('error') !!}", "error", {
        button: "OK",
    })
</script>
@endif
<script>
    function deleteCate(id) {
        const url = '/cp-admin/products/delete/' + id;
        // console.log(url);
        swal({
                title: "Bạn có chắc không?",
                text: "Sau khi bị xóa, bạn sẽ không thể khôi phục tệp này! ",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "get",
                        url: url,
                        success: function(res) {
                            //console.log(res.status)
                            if (res.status == 200) {
                                swal("Tệp của bạn đã bị xóa!", {
                                    icon: "success",
                                }).then(function() {
                                    $("#pro" + id).remove();
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
