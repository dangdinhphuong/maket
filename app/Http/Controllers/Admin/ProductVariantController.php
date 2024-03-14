<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\Variants;

class ProductVariantController extends Controller
{
    public function edit($id)
    {
        $Product = Product::find($id);
        if (!$Product) {
            return redirect()->back();
        }
        $typeVariants = Variants::where('user_id', auth()->user()->id)->get();
        $variants = ProductVariant::where('product_id', $id)->get();
        return view('admin.pages.product.variant', compact('variants', 'Product', 'typeVariants'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $variants = [];
        $Product = Product::find($id);
        if (!$Product) {
            return redirect()->back();
        }

        foreach ($data['variants'] as $key => $item) {
            if (is_int($key)) {
               $productVariant =  ProductVariant::find($key);
               $productVariant->update($this->formatProductVariant( $productVariant, $item));
            } else {
                $variants[] = $this->formatNewProductVariant($item, $id);
            }
        }
        ProductVariant::insert($variants);
        return redirect()->back();
    }

    public function formatNewProductVariant($data, $productId)
    {
        if (!empty($data['image'])) {
            $productImage = $this->imageProductVariant($data, $productId);
        }
        $data['image'] = $productImage->image ?? '';
        return [
            'product_id' => $productId,
            'variant_type' =>  $data["name"],
            'variant_value' => json_encode($data),
            'price' => $data["price"],
            'quantity' => $data["quantity"],
            'image_id' => $productImage->id ?? null
        ];
    }
    
    public function formatProductVariant( $productVariant, $item)
    {
        $variantValues = json_decode($productVariant['variant_value'], true); 
        $variantValues["quantity"] = $productVariant["quantity"];
        $variantValues["price"] = $productVariant["price"];
        return [
            'variant_value' => json_encode($variantValues),
            'price' => $productVariant["price"],
            'quantity' => $productVariant["quantity"]
        ];
    }

    public function imageProductVariant($data, $productId)
    {
        $pathAvatar = $data['image']->store('public/images/products');
        $pathAvatar = str_replace("public/", "", $pathAvatar);
        $productImage = ProductImage::create(['product_id' => $productId, 'image' => $pathAvatar]);
        return $productImage;
    }

    public function delete($productId, $id)
    {
        $productVariant = ProductVariant::where('product_id', $productId)->get();
        $variant = $productVariant->where('id', $id)->first();
        if (count($productVariant) <= 1) {
            return response()->json([
                'message' => "Xóa thất bại, sản phẩm tối thiểu 1 phân loại",
                'status' => "404"
            ]);
        }
        if (empty($variant)) {
            return response()->json([
                'message' => "Danh biến thể không tồn tại",
                'status' => "404"
            ]);
        }
        $variantImage = ProductImage::find($variant->image_id);
        $variant->delete();
        if ($variantImage) {
            $variantImage->delete();
        }
        return response()->json([
            'message' => "Xóa danh biến thể thành công",
            'status' => "200"
        ]);
    }
}
