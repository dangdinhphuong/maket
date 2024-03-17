<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Origin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use GuzzleHttp\Handler\Proxy;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $supplier = Supplier::all();
        $categoryAll = Category::all();
        $origin = Origin::all();
        $products = Product::filter(request(['search','category_id','supplier_id','origin_id','status']))
            ->when(auth()->user()->role_id == 3, function ($query) {
                return $query->where('users_id', auth()->user()->id);
            })
            ->with(['category','supplier','origin','User','productVariant'])
            ->orderBy('id', 'DESC')
            ->Paginate(7);

        return view('admin.pages.product.index', compact('products','supplier', 'categoryAll', 'origin'));
    }
    public function create()
    {
        $supplier = Supplier::all();
        $category = Category::all();
        $origin = Origin::all();
        return view('admin.pages.product.create', compact('supplier', 'category', 'origin'));
    }
    public function store(StoreProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = request(['namePro', 'quantity', 'slug', 'price', 'discounts', 'Description', 'status', 'category_id', 'supplier_id', 'origin_id','cost']);
            $data['users_id'] = auth()->user()->id;
            $data['image'] = '';
            $product = Product::create($data);
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $filename = $image->store('public/images/products'); // Adjust storage path as per your requirement
                    $data['image'] = $pathAvatar = str_replace("public/", "", $filename);
                    $product->productImage()->create(['image' => $pathAvatar,'type'=>1]);
                }
            }
            $product->update($data);

            DB::commit();
            return redirect()->route('cp-admin.products.variant.edit',['id'=>$product->id])->with('message', 'Thêm sản phẩm thành công !');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('message :', $exception->getMessage() . '--line :' . $exception->getLine());
            if (file_exists('storage/' . $pathAvatar)) {
                unlink('storage/' . $pathAvatar);
            }
            return redirect()->route('cp-admin.products.index')->with('error', 'Thêm sản phẩm thất bại !');
        }
    }
    public function edit($id)
    {
        $Product = Product::with('productVariant')->find($id);
        if(!$Product){
            return redirect()->back();
        }
        $supplier = Supplier::all();
        $categoryAll = Category::all();
    //    dd($supplier);
        $origin = Origin::all();
        return view('admin.pages.product.edit', compact('Product', 'supplier', 'categoryAll', 'origin'));
    }
    public function update(Request $request, $id)
    {
        $Product = Product::find($id);
        if(!$Product){
            return redirect()->back();
        }
        $this->validate(
            request(),
            [
                'namePro' => 'required|min:3|max:100|unique:products,namePro,' . $Product->id,
                'slug' => 'required|min:3|max:100|unique:products,slug,' . $Product->id,
                'image.*' => [
                    'sometimes', // Chỉ kiểm tra nếu người dùng tải lên ảnh mới
                    'mimes:jpg,bmp,png', // Định dạng ảnh phải là jpg, bmp hoặc png
                    'max:2048' // Kích thước tối đa là 2048KB
                ],
                'quantity' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:1',
                'discounts' => 'required|numeric|min:0|max:100',
                'status' => 'required|numeric|min:0|max:1',
                'category_id' => 'required|numeric|min:1',
                'supplier_id' => 'required|numeric|min:1',
                'origin_id' => 'required|numeric|min:1'
            ]
        );
        try {
            DB::beginTransaction();
            $data = request(['namePro', 'quantity', 'slug', 'price', 'discounts', 'Description', 'status', 'category_id', 'supplier_id', 'origin_id']);
            $data['users_id'] = auth()->user()->id;


            $Product->productImage()->where('type',1)->delete();
            if ($request->hasFile('image')) {
                foreach($Product->productImage->where('type',1) as $productImage ){
                    if (file_exists('storage/' . $productImage->image)) {
                        unlink('storage/' . $productImage->image);
                    }
                }
                foreach ($request->file('image') as $image) {
                    $filename = $image->store('public/images/products'); // Adjust storage path as per your requirement
                    $data['image'] = $pathAvatar = str_replace("public/", "", $filename);
                    $Product->productImage()->create(['image' => $pathAvatar,'type'=>1]);
                }
            }
            $Product->update($data);
            DB::commit();
            return redirect()->route('cp-admin.products.index')->with('message', 'Cập nhật sản phẩm thành công');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('message :', $exception->getMessage() . '--line :' . $exception->getLine());
            if (file_exists('storage/' . $pathAvatar)) {
                unlink('storage/' . $pathAvatar);
            }
            return redirect()->route('cp-admin.products.index')->with('error', 'Sửa sản phẩm thất bại !');
        }
    }
    public function delete($id)
    {
        $Product = Product::find($id);

        if ($Product) {
            if (file_exists('storage/' . $Product->image)) {
                unlink('storage/' . $Product->image);
            }
            $Product->delete();
            return response()->json([
                'message' => "Xóa sản phẩm thành công",
                'status' => "200"
            ]);
        }
        return response()->json([
            'message' => "Không tìm thấy sản phẩm",
            'status' => "401"
        ]);
    }
    public function updateStatus(Request $request, $id)
    {
        $Product = Product::find($id);
        $data = $request->all();
        if ($Product) {
            $Product->update(['status'=>$data['status']]);
            return response()->json([
                'message' => "Cập nhật sản phẩm thành công",
                'status' => "200"
            ]);
        }
        return response()->json([
            'message' => "Không tìm thấy sản phẩm",
            'status' => "401"
        ]);
    }
}
