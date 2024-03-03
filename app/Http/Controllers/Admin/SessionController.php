<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Constants;
use App\Models\User;

class SessionController extends Controller
{

    // số lần đăng nhập 
    protected $maxAttempts = 3;
    // thời gian bị khóa tài khoản là 60 giây
    protected $decayMinutes = 60;

    public function create()
    {
        return view('admin.pages.auth.login');
    }
    public  function store()
    {
        request()->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Mời nhập e-mail !',
            'password.required' => 'Mời nhập Mật khẩu !',

        ]);
        // tạo key để nhớ lần đăng nhập sai của tài khoản : key ==> login|admin@gmail,com|http://127.0.0.1:8000
        $key = "login|" . request('email') . '|' . request()->ip();
        
        // kiểm tra xem người dùng có click vào luôn luôn đăng nhập ko
        $remember = request('remember') == "1" ? true : false;

        // kiểm tra xem tài khoản đã quá số lần đăng nhập chưa . nếu quá 3 lần thì khóa tài khoản , nếu chưa quá 3 lần thì bỏ qua if
        if (RateLimiter::tooManyAttempts($key, $this->maxAttempts)) {
            // Xử lý khóa tài khoản 
            $user = User::where('email', request('email'))->where('is_admin', 1)->first();
            if ($user) {
                $user->update(['status' => Constants::DISABLE_ACCOUNT]); // cho trạng thái tài khoản bằng 0 tương đương với khóa tài khoản
            }

            return redirect()->back()->with('error', "Tài khoản của bạn tạm thời dừng hoạt động do đăng nhập sai quá nhiều | Vui lòng viên hệ với quản trị viên để được hỗ trợ !");
        }
        if (auth()->user()) {
            auth()->logout();
        }
        // sử dụng auth để đăng nhập . nếu đăng nhập sai thì chạy vào if . còn nếu đúng bỏ qua if
        if (!auth()->attempt(request(['email', 'password']), $remember)) {

            // khi đăng nhập sai ta dùng hit để tăng số lần đăng nhập sai
            RateLimiter::hit($key, $this->decayMinutes);
            return redirect()->back()->with('error', "Tài khoản hoặc mật khẩu không hợp lệ !")->with('retriesLeft', RateLimiter::retriesLeft($key, $this->maxAttempts));
        }
        // kiểm tra xem tài khoản ta vừa đăng nhập trên đã đóng chưa. nếu quá status = 0 thì chạy if , nếu status = 1 thì bỏ qua if
        if (auth()->user()->status == Constants::DISABLE_ACCOUNT) {
            // logout tk vừa đăng nhập ra
            $this->logout();
            return redirect()->back()->with('error', "Tài khoản của bạn đã bị vô hiệu hóa !");
        }
        // kiểm tra xem tài khoản ta vừa đăng nhập trên có phải của nhân viênhay khách hàng. nếu quá is_admin = 0 thì chuyển về trang khách hàng , nếu is_admin = 1 mặc định về trang admin
        if (auth()->user()->is_admin == Constants::DISABLE_ACCOUNT) {
            // logout tk vừa đăng nhập ra
            return redirect()->route('home')->with('message', "Tài khoản của bạn đăng nhập thành công !");
        }
        RateLimiter::clear($key);
        return redirect()->intended(route('cp-admin.dashboad'));
    }


    
    public function logout()
    {
        // kiểm tra xem đã đăng nhập chưa . nếu đăng r thì logout . còn chưa thì về quay về trang login
        if (auth()->user()) {
            auth()->logout();
        }
        return redirect()->route('login');
    }
}
