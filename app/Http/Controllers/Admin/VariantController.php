<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Variants;

class VariantController extends Controller
{
    protected $variants;

    public function __construct(Variants $variants)
    {
        $this->variants = $variants;
    }
    public function index(Request $request)
    {
        $typeVariants = $this->variants->where('user_id',auth()->user()->id)->filter(request(['search']))->orderBy('id', 'DESC')->paginate(15);
        return view('admin.pages.variants.index', compact('typeVariants'));
    }

    public function create()
    {
        return view('admin.pages.variants.create');
    }

    public function store(Request $request)
    {
        $this->validate(
            request(),
            [
                'name' => 'required|min:3|max:100|unique:variants,name,NULL,id,user_id,' . auth()->user()->id,
                'slug' => 'required|min:3|max:100|unique:variants,slug,NULL,id,user_id,' . auth()->user()->id
            ],
            [
                'name.required' => 'Bạn chưa nhập tên danh mục',
                'name.unique' => 'Tên danh mục không được trùng',
                'name.min' => 'Tên danh mục phải có Độ dài  từ 3 đến 100 ký tự',
                'name.max' => 'Tên danh mục phải có Độ dài  từ 3 đến 100 ký tự',
                'slug.required' => 'Bạn chưa nhập slug',
                'slug.unique' => 'Slug không được trùng',
                'slug.min' => 'Slug phải có Độ dài  từ 3 đến 100 ký tự',
                'slug.max' => 'Slug phải có Độ dài  từ 3 đến 100 ký tự',
            ]
        );
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $this->variants->create($data);
        return redirect()->route('cp-admin.variant.index');
    }

    public function edit($id)
    {
        $variant = $this->variants->where('id', $id)->where('user_id', auth()->user()->id)->first();
        return view('admin.pages.variants.edit', compact('variant'));
    }

    public function update(Request $request, $id)
    {
        // Lọc dữ liệu trước khi validation
        $data = $request->except(['_token']);
    
        // Validation
        $this->validate(
            $request,
            [
                'name' => 'required|min:3|max:100|unique:variants,name,'.$id.',id,user_id,'.auth()->user()->id,
                'slug' => 'required|min:3|max:100|unique:variants,slug,'.$id.',id,user_id,'.auth()->user()->id
            ],
            [
                'name.required' => 'Bạn chưa nhập tên danh mục',
                'name.unique' => 'Tên danh mục không được trùng',
                'name.min' => 'Tên danh mục phải có độ dài từ 3 đến 100 ký tự',
                'name.max' => 'Tên danh mục phải có độ dài từ 3 đến 100 ký tự',
                'slug.required' => 'Bạn chưa nhập slug',
                'slug.unique' => 'Slug không được trùng',
                'slug.min' => 'Slug phải có độ dài từ 3 đến 100 ký tự',
                'slug.max' => 'Slug phải có độ dài từ 3 đến 100 ký tự',
            ]
        );
    
        // Cập nhật dữ liệu
        $data['user_id'] = auth()->user()->id;
        $this->variants->where('id', $id)->where('user_id', auth()->user()->id)->update($data);
    
        // Redirect sau khi cập nhật thành công
        return redirect()->route('cp-admin.variant.index')->with('message', 'Cập nhật thành công');
    }
    
    public function delete($id)
    {
        $variant = $this->variants->where('id', $id)->where('user_id', auth()->user()->id)->first();
        if ($variant) {
            $variant->delete();
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
