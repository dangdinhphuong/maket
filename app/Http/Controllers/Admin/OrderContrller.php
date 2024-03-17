<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\ProductVariant;
class OrderContrller extends Controller
{
    public function index(Request $request)
    {

        $Orders = OrderDetail::where('users_id', auth()->user()->id)->orderBy('id', 'DESC')->Paginate(30);
        return view('admin.pages.orders.index', compact('Orders'));
    }

    public function edit($id)
    {
        $Orders = Order::where('id', $id)->first();
        $Orders->load('order_detail');
        if(!$Orders){
            return redirect()->back();
        }
        if($Orders){
            //  dd($Orders);
              $totalMoney = 0;
              foreach ($Orders->order_detail as $order) {
                  $totalMoney += $order->price * $order->quantity;
              }
            return view('admin.pages.orders.edit', compact('Orders','totalMoney'));
            }
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩn của đơn hàng');
    }

    public function update(Request $request ,$id)
    {
        $this->validate(request(),[
            'status' => 'required|integer|min:0',
        ],
        [
            'status.required' => 'Trạng thái Không hợp lệ',
            'status.integer' => 'Trạng thái Không hợp lệ',
            'status.min'=>'Trạng thái Không hợp lệ',
        ]);
        $Orders = OrderDetail::with(['productVariant'])->find($id);
        $variantValues = json_decode($Orders->productVariant->variant_value, true);
        $variantValues['quantity'] = $Orders->productVariant->quantity + $Orders->quantity;
        $newData= ['quantity' => $variantValues['quantity'],'variant_value' => json_encode($variantValues)];
        if(!$Orders){
            return redirect()->back();
        }
        $Orders->update($request->all());
        ProductVariant::find($Orders->productVariant->id)->update($newData);
        return response()->json([
            'message' => "Cập nhật trạng thái thành công",
            'status' => "200"
        ]);
    }
}
