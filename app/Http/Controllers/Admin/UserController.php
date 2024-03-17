<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Roles;
use App\Common\Constants;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    public function index()
    {
        $roles = Roles::where('id', '!=', 1)->orderBy('id', 'DESC')->get();
        $users = User::where('is_admin', true)->where('role_id', '!=', 3)
            ->filter(request(['search', 'role_id', 'status']))
            ->orderBy('id', 'DESC')->Paginate(15);
        $users->load('roles');
        return view('admin.pages.users.index', compact('users', 'roles'));
    }
    public function getSeller()
    {
        $users = User::with([
            'groupUser',
            'roles'
        ])
            ->where('is_admin', true)->where('role_id', 3)
            ->filter(request(['search', 'role_id', 'status']))
            ->orderBy('id', 'DESC')->Paginate(15);

        return view('admin.pages.sellers.index', compact('users'));
    }

    public function create()
    {
        $roles = Roles::where('id', '!=', 1)->orderBy('id', 'DESC')->get();
        return view('admin.pages.users.create', compact('roles'));
    }
    public function store(Request $request)
    {

        $this->validate(
            request(),
            [
                'fullname' => 'required|min:3|max:100',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
                'phone' => 'required|numeric|digits_between:10,12|unique:users,phone',
                'address' => 'required|min:3|max:200',
                'email' => 'required|email|unique:users,email',
                'role_id' => 'required|integer|min:2',
                'status' => 'required|numeric|min:0|max:1',
            ],
            [
                'fullname.required' => 'Bạn chưa nhập họ và tên',
                'phone.unique' => 'Số điện thoại đã được sử dụng',
                'fullname.min' => 'Họ và tên phải có Độ dài  từ 3 đến 100 ký tự',
                'fullname.max' => 'Họ và tên phải có Độ dài  từ 3 đến 100 ký tự',
                'avatar.required' => 'Bạn chưa chọn ảnh',
                'avatar.mimes' => 'Hình đại diện phải là tệp thuộc loại: image / jpeg, image / png.',
                'avatar.image' => 'Hình đại diện phải là tệp thuộc loại: image / jpeg, image / png.',
                'avatar.max' => 'avatar dụng lượng tối đa 2048mb',
                'phone.required' => 'Bạn chưa nhập số điện thoại',
                'phone.digits_between' => 'Độ dài số điện thoại không hợp lệ',
                'phone.numeric' => 'Số điện thoại không hợp lệ',
                'address.required' => 'Bạn chưa nhập địa chỉ',
                'address.unique' => 'Địa chỉ không được trùng',
                'address.min' => 'Địa chỉ phải có Độ dài  từ 3 đến 200 ký tự',
                'address.max' => 'Địa chỉ phải có Độ dài  từ 3 đến 200 ký tự',
                'email.required' => 'Bạn chưa nhập email',
                'email.email' => 'Email không đúng định dạng',
                'phone.unique' => 'Email đã được sử dụng',
                'role_id.required' => 'Mời chọn chức vụ',
                'role_id.integer' => 'Chức vụ Không hợp lệ',
                'role_id.min' => 'Chức vụ Không hợp lệ',
                'status.required' => 'Trạng thái Không hợp lệ',
                'status.integer' => 'Trạng thái Không hợp lệ',
                'status.min' => 'Trạng thái Không hợp lệ',
                'status.max' => 'Trạng thái Không hợp lệ',
            ]
        );

        // lưu ảnh
        $pathAvatar = $request->file('avatar')->store('public/users/avatar');
        $pathAvatar = str_replace("public/", "", $pathAvatar);



        $data = request(['fullname', 'phone', 'address', 'email', 'role_id', 'status']);
        // tạo mật khẩu cho tài khoản
        $data['passwordNew'] = Str::random(15); // pass chưa mã hóa
        $data['avatar'] = $pathAvatar;
        $data['password'] = bcrypt( $data['passwordNew']); // mã hóa mật khẩu
        $data['is_admin'] = true;

        User::create($data);

        Mail::to($request->email)->send(new NotifyMail($data));
        return redirect()->route('cp-admin.user.index')->with('message', 'Thêm nhóm nhân viên thành công . Vui lòng kiểm tra email để lấy thông tin đăng nhập !');
    }
    public function edit($id)
    {
        $users = User::where('is_admin',true)->where('id',$id)->first();

        if ($users) {
            $roles = Roles::where('id', '!=', 1)->orderBy('id', 'DESC')->get();
            return view('admin.pages.users.edit', compact('users', 'roles'));
        }
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $user = User::where('is_admin',true)->where('id',$id)->first();
        $this->validate(
            request(),
            [
                'fullname' => 'required|min:3|max:100',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
                'phone' => 'required|numeric|digits_between:10,12|unique:users,phone,'. $user ->id,
                'address' => 'required|min:3|max:200',
                'email' => 'required|email|unique:users,email,'. $user ->id,
                'role_id' => 'required|integer|min:2',
                'status' => 'required|numeric|min:0|max:1',
            ],
            [
                'fullname.required' => 'Bạn chưa nhập họ và tên',
                'phone.unique' => 'Số điện thoại đã được sử dụng',
                'fullname.min' => 'Họ và tên phải có Độ dài  từ 3 đến 100 ký tự',
                'fullname.max' => 'Họ và tên phải có Độ dài  từ 3 đến 100 ký tự',

                'avatar.mimes' => 'Hình đại diện phải là tệp thuộc loại: image / jpeg, image / png.',
                'avatar.image' => 'Hình đại diện phải là tệp thuộc loại: image / jpeg, image / png.',
                'avatar.max' => 'avatar dụng lượng tối đa 2048mb',
                'phone.required' => 'Bạn chưa nhập số điện thoại',
                'phone.digits_between' => 'Độ dài số điện thoại không hợp lệ',
                'phone.numeric' => 'Số điện thoại không hợp lệ',
                'address.required' => 'Bạn chưa nhập địa chỉ',
                'address.unique' => 'Địa chỉ không được trùng',
                'address.min' => 'Địa chỉ phải có Độ dài  từ 3 đến 200 ký tự',
                'address.max' => 'Địa chỉ phải có Độ dài  từ 3 đến 200 ký tự',
                'email.required' => 'Bạn chưa nhập email',
                'email.email' => 'Email không đúng định dạng',
                'phone.unique' => 'Email đã được sử dụng',
                'role_id.required' => 'Mời chọn chức vụ',
                'role_id.integer' => 'Chức vụ Không hợp lệ',
                'role_id.min' => 'Chức vụ Không hợp lệ',
                'status.required' => 'Trạng thái Không hợp lệ',
                'status.integer' => 'Trạng thái Không hợp lệ',
                'status.min' => 'Trạng thái Không hợp lệ',
                'status.max' => 'Trạng thái Không hợp lệ',
            ]
        );
        // tìm user theo id

        // kiểm tra xem request ảnh lên không
        $pathAvatar = "";
        if ($request->file('avatar') != null) { // có giửi ảnh lên

            if (file_exists('storage/' . $user->avatar)) {  // kiểm tra xem file ảnh cũ có tồn tại trong forder ko
                unlink('storage/' . $user->avatar); // nếu có thì xóa ảnh cũ trong file store
            }
            // lưu ảnh mới
            $pathAvatar = $request->file('avatar')->store('public/users/avatar');
            $pathAvatar = str_replace("public/", "", $pathAvatar);
        } else {
            $pathAvatar = $user->avatar;
        }
        $data = request(['fullname', 'phone', 'address', 'email', 'role_id', 'status']);
        $data['avatar'] = $pathAvatar;
        $user->update($data);

        return redirect()->route('cp-admin.user.index')->with('message', 'Cập nhật tài khoản thành công !');;
    }
    public function delete($id)
    {
        $user = User::where('is_admin',true)->where('id',$id)->first();
        $user->load('blogs');
        $user->load('products');
        // dd($user->blogs->count(),$user->products->count());
        if($user){
            if($user->products->count()>=1){
                return response()->json([
                    'message' => "Không thể xóa nhân viên khi vẫn còn sản phẩm liên quan",
                    'status' => "401"
                ]);
            }
            else if($user->blogs->count()>=1){
                return response()->json([
                    'message' => "Không thể xóa nhân viên khi vẫn còn bài viết liên quan",
                    'status' => "401"
                ]);
            }

            $user->delete();
            $logout=false;
            if($id==auth()->user()->id){
                auth()->logout();
                $logout=true;
            }
            return response()->json([
                'message' => "Xóa nhân viên thành công",
                'status' => "200",
                'logout' => $logout
            ]);
        }
        return response()->json([
            'message' => "Không tìm thấy nhân viên",
            'status' => "401"
        ]);

    }

    //#############################################################################
    public function proFile()
    {
        return view('admin.pages.auth.profile');
    }
    public function proFileStore(Request $request)
    {

        $this->validate(
            request(),
            [
                'fullname' => 'required|min:3|max:100',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
                'phone' => 'required|numeric|digits_between:10,12|unique:users,phone,' . auth()->user()->id,
                'address_detail' => 'required|min:3|max:200',
            ],
            [
                'fullname.required' => 'Bạn chưa nhập họ và tên',
                'phone.unique' => 'Số điện thoại đã được sử dụng',
                'fullname.min' => 'Họ và tên phải có Độ dài  từ 3 đến 100 ký tự',
                'fullname.max' => 'Họ và tên phải có Độ dài  từ 3 đến 100 ký tự',
                'avatar.mimes' => 'Hình đại diện phải là tệp thuộc loại: image / jpeg, image / png.',
                'avatar.image' => 'Hình đại diện phải là tệp thuộc loại: image / jpeg, image / png.',
                'avatar.max' => 'avatar dụng lượng tối đa 2048mb',
                'phone.required' => 'Bạn chưa nhập số điện thoại',
                'phone.digits_between' => 'Độ dài số điện thoại không hợp lệ',
                'phone.numeric' => 'Số điện thoại không hợp lệ',
                'address_detail.required' => 'Bạn chưa nhập địa chỉ',
                'address_detail.unique' => 'Địa chỉ không được trùng',
                'address_detail.min' => 'Địa chỉ phải có Độ dài  từ 3 đến 200 ký tự',
                'address_detail.max' => 'Địa chỉ phải có Độ dài  từ 3 đến 200 ký tự',
            ]
        );


        if ($request->file('avatar') != null) {
            if (file_exists('storage/' . auth()->user()->avatar) && !empty(auth()->user()->avatar)) {
                unlink('storage/' . auth()->user()->avatar??'');
            }
            $pathAvatar = $request->file('avatar')->store('public/users/avatar');
            $pathAvatar = str_replace("public/", "", $pathAvatar);
        } else {
            $pathAvatar = auth()->user()->avatar;
        }
        $data = request(['fullname', 'phone', 'address_detail']);
        $data['avatar'] = $pathAvatar;
        $user = User::find(auth()->user()->id)->update($data);
        return redirect()->back()->with('message', 'Cập nhật thông tin thành công');
    }
    public function changePassword()
    {
        $customer = User::find(auth()->user()->id);
        $rules = [
            'current_password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6'
        ];
        $messages = [
            'current_password.required' => 'Mời nhập mật khẩu hiện tại !',
            'current_password.min' => 'Mật khẩu hiện tại  ít nhất 6 ký tự!',
            'new_password.required' => 'Mời nhập mật khẩu mới !',
            'new_password.min' => 'Mật khẩu mới  ít nhất 6 ký tự!',
            'confirm_password.required' => 'Mời nhập mật khẩu nhập lại !',
            'confirm_password.min' => 'Mật khẩu nhập lại  ít nhất 6 ký tự!'
        ];
        $this->validate(request(), $rules, $messages);
        $data = request()->all();
        if (!Hash::check($data['current_password'], $customer->password)) {
            return redirect()->route('cp-admin.profile')->with('error', 'Mật khẩu hiện tại không chính xác, vui lòng thử lại');
        } else {
            $customer->update([
                'password' => bcrypt($data['confirm_password'])
            ]);
            return redirect()->route('cp-admin.logout')->with('message', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại');
            // return response()->json([
            //     'message' => 'Your password update succesfully!',
            //     'data' => new CustomerResource($this->customerRepository->find($customer->id)),
            //     'status' => 200
            // ]);
        }
    }
}
