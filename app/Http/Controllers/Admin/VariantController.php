<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Variants;
class VariantController extends Controller
{

    public function index(Request $request)
    {
        $categories = Variants::filter(request(['search']))->orderBy('id','DESC')->paginate(15);
        $categories->load('products'); // gọi products bên model

        return view('admin.pages.categories.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.variants.create');
    }
    public function store(Request $request)
    {
        $this->validate(request(),[
            'nameCate'=>'required|min:3|max:100|unique:categories,nameCate',
            'slug'=>'required|min:3|max:100|unique:categories,slug',
            'banner' => 'required|mimes:jpg,bmp,png|max:2048',
        ],
        [
            'nameCate.required'=>'Bạn chưa nhập tên danh mục',
            'nameCate.unique' => 'Tên danh mục không được trùng',
            'nameCate.min'=>'Tên danh mục phải có Độ dài  từ 3 đến 100 ký tự',
            'nameCate.max'=>'Tên danh mục phải có Độ dài  từ 3 đến 100 ký tự',
            'slug.required'=>'Bạn chưa nhập slug',
            'slug.unique' => 'Slug không được trùng',
            'slug.min'=>'Slug phải có Độ dài  từ 3 đến 100 ký tự',
            'slug.max'=>'Slug phải có Độ dài  từ 3 đến 100 ký tự',
            'banner.required' => 'Banner không được trống',
            'banner.mimes'=>'Banner Không đúng định dạng quy định (jpg,bmp,png)',
            'banner.max'=>'Banner dụng lượng tối đa 2048mb',
        ]);
       $pathAvatar = $request->file('banner')->store('public/images/Variants');
       $pathAvatar = str_replace("public/", "", $pathAvatar);
       $data = request(['nameCate','slug']);
       $data['users_id'] = auth()->user()->id;
       $data['banner'] = $pathAvatar;
        Variants::create($data);
       return redirect()->route('cp-admin.Variants.index');
    }
    public function edit($id)
    {
        $Variants = Variants::find($id);
        return view('admin.pages.categories.edit', compact('Variants'));
    }
    public function update(Request $request ,$id)
    {
        $Variants = Variants::find($id);
        $this->validate(request(),[
            'nameCate'=>'required|min:3|max:100|unique:categories,nameCate,'.$Variants->id,
            'slug'=>'required|min:3|max:100|unique:categories,slug,'.$Variants->id,
            'banner' => 'mimes:jpg,bmp,png|max:2048',
        ],
        [
            'nameCate.required'=>'Bạn chưa nhập tên danh mục',
            'nameCate.unique' => 'Tên danh mục không được trùng',
            'nameCate.min'=>'Tên danh mục phải có Độ dài  từ 3 đến 100 ký tự',
            'nameCate.max'=>'Tên danh mục phải có Độ dài  từ 3 đến 100 ký tự',
            'slug.required'=>'Bạn chưa nhập slug',
            'slug.unique' => 'Slug không được trùng',
            'slug.min'=>'Slug phải có Độ dài  từ 3 đến 100 ký tự',
            'slug.max'=>'Slug phải có Độ dài  từ 3 đến 100 ký tự',
            'banner.mimes'=>'Banner Không đúng định dạng quy định (jpg,bmp,png)',
            'banner.max'=>'Banner dụng lượng tối đa 2048mb',
        ]);
        if ($request->file('banner') != null) {
            if (file_exists('storage/' . $Variants->banner)) {
                unlink('storage/' . $Variants->banner);
            }
            $pathAvatar = $request->file('banner')->store('public/images/Variants');
            $pathAvatar = str_replace("public/", "", $pathAvatar);
        } else {
            $pathAvatar = $Variants->banner;
        }
        $data = request(['nameCate','slug']);
        $data['users_id'] = auth()->user()->id;
        $data['banner'] = $pathAvatar;
        $Variants->update($data);
         return redirect()->route('cp-admin.Variants.index')->with('message','Cập nhật thành công');
    }
    public function delete($id)
    {
        $Variants = Variants::find($id);
        $Variants->load('products');
        if($Variants){
            if($Variants->products->count()>=1){
                return response()->json([
                    'message' => "Không thể xóa khi vẫn còn số lượng khách hàng",
                    'status' => "401"
                ]);
            }
            $Variants->delete();
            if (file_exists('storage/' . $Variants->banner)) {
                unlink('storage/' . $Variants->banner);
            }
            return response()->json([
                'message' => "Xóa danh mục thành công",
                'status' => "200"
            ]);
        }
        return response()->json([
            'message' => "Không tìm thấy danh mục",
            'status' => "401"
        ]);
    }
}
