
function addToCart(id, productVariant = []) { // thêm sản phẩm có sô lượng
    let quantity = $("#quantity").val();
    let _token = $("input[name=_token]").val();
    let url = "/api/add-to-cart/" + id;
    let data = { quantity, _token, productVariant };
    if (quantity <= 0) {
        swal("Vui lòng chọn sô lượng", {
            icon: "error",
        })
        return false;
    }
    $.ajax({
            type: "post",
            url: url,
            data: data,
            success: function (res) {
                swal(res.message, {
                    icon: res.status,
                    timer: 1000
                });
            },
            error: function (response) {
                console.log('response', response.responseJSON)
                if (response.responseJSON.message) {
                    swal(response.responseJSON.message, {
                        icon: response.responseJSON.status,
                    });
                }
                else swal(response.message, {
                    icon: response.status,
                });
            },
        });


    }
function updateProductCarts(id,quantity) { // thêm sản phẩm có sô lượng
    let _token = $("input[name=_token]").val();
    let url = "/api/add-to-cart/" + id;
    let data = { quantity, _token };
    if (quantity <= 0) {
        swal("Số lượng tối thiểu là 1", {
            icon: "error",
        })
        return false;
    }
    $.ajax({
        type: "post",
        url: url,
        data: data,
        success: function (res) {
            swal(res.message, {
                icon: res.status,
                timer: 1000
            });
        },
        error: function (response) {
            console.log('response', response.responseJSON)
            if (response.responseJSON.message) {
                swal(response.responseJSON.message, {
                    icon: response.responseJSON.status,
                });
            }
            else swal(response.message, {
                icon: response.status,
            });
        },
    });


}

    function addCart(id) { // thêm sản phẩm măc định sô lượng là 1

        let url = "/api/add-cart/" + id;
        $.ajax({
            type: "get",
            url: url,
            success: function (res) {
                console.log('res', res)
                swal(res.message, {
                    icon: res.status,
                    timer: 2000
                });
            },
            error: function (response) {
                console.log('response', response.responseJSON)
                if (response.responseJSON.message) {
                    swal(response.responseJSON.message, {
                        icon: response.responseJSON.status,
                    });
                }
                else swal(response.message, {
                    icon: response.status,
                });
            },
        });


    }

    function removeCart(id) { // xóa sản phẩm theo id trong giỏ hàng

        let url = "/api/remove-cart/" + id;
        $.ajax({
            type: "get",
            url: url,
            success: function (res) {
                console.log('res', res)
                swal(res.message, {
                    icon: res.status,
                    timer: 2000
                }).then(function () {
                    $("#pro" + id).remove();
                });
            },
            error: function (response) {
                console.log('response', response.responseJSON)
                if (response.responseJSON.message) {
                    swal(response.responseJSON.message, {
                        icon: response.responseJSON.status,
                    });
                }
                else swal(response.message, {
                    icon: response.status,
                });
            },
        });


    }
