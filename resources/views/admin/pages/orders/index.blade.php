@extends('admin.master')
@section('title', "Đơn hàng")
@section('style')
<style>
    .sreach {
        border: 1px solid black !important;
    }
</style>
@endsection
@section('content')
<div  class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Đơn hàng</h1>
</div>

<div class="card shadow mb-4 ">
    <div class="card-header py-3">
        <form name="fillter_cate" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="" method="get">
            <div class="input-group">
            <input type="hidden" class="form-control bg-light border-0 small sreach" name="page" value="{{request('page') ? request('page') : '1' }}" aria-label="Search" aria-describedby="basic-addon2">
                <input type="text" class="form-control bg-light border-0 small sreach" name="search" placeholder="Tìm danh mục liên hệ ..." value="{{request('search') ? request('search') : '' }}" aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" id="fillter_cate" type="btn">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th>ID</th>
                        <th>Sản phẩm </th>
                        <th>Giá </th>
                        <th>Trạng thái</th>
                        <th>Thời gian đặt</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tfoot>
                <th>ID</th>
                <th>Sản phẩm </th>
                <th>Giá </th>
                <th>Trạng thái</th>
                <th>Thời gian đặt</th>
                <th>Hành động</th>
                </tr>
                </tfoot>
                <tbody>
                    @foreach( $Orders as $Order)
                    <tr id="cate{{ $Order->id }}">
                    <td>{{ $Order->id }}</td>
                        <td>{{ $Order->name }}</td>
                        <td> {{ number_format($Order->price, 0, ',', '.') . " ₫"   }}</td>
                        <td>{{ App\Common\Constants::STATUS_ORDER[$Order->status] }}</td>
                        <td>{{ $Order->created_at }}</td>
                        <td>
                        @can('SUA-DON-HANG')
                            <a href="{{route('cp-admin.orders.edit',[ 'id' => $Order->order_id ])}}" class="btn-lg"><i class="fas fa-pencil-alt"></i></a>
                            @endcan
                            {{-- <a class="btn-lg" onclick="deleteCate({{ $contact->id}})"><i class="fas fa-trash"></i></a> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-header py-3">
        {!! $Orders->links('pagination::bootstrap-4') !!}
    </div>
</div>

@endsection
@section('javascript')
@if(session('message'))
<script>
    swal("Hành động", " {!! session('message') !!}", "success", {
        button: "OK",
    })
</script>
@endif
<script>
    function deleteCate(id) {
        const url = '/cp-admin/cate_blog/delete/' + id;
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
                            console.log(res.status)
                            if (res.status == 200) {
                                swal("Tệp của bạn đã bị xóa!", {
                                    icon: "success",
                                }).then(function() {
                                    $("#cate" + id).remove();
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
            $("input[name='page']").val(page);

            $("form[name='fillter_cate']").trigger("submit");
        });
        $("#fillter_cate").on("click", function(e) {
            e.preventDefault();
            $("input[name='page']").val(1);

            $("form[name='fillter_cate']").trigger("submit");
        });
    });
</script>
@endsection
