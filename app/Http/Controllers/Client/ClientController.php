<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\config;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Blogs;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\contact;
use App\Models\CategoryBlog;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Http\Requests\checkoutRequest;
use App\Common\Constants;
use Carbon\Carbon;
use App\Mail\ForgetPassMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\ProductVariant;
use App\Http\Controllers\VnPayController;


class ClientController extends Controller
{
    protected $categories;

    public function __construct( VnPayController $vnPayController)
    {
        $this->vnPayController = $vnPayController;
        $this->categories = Category::orderBy('id', 'DESC')->limit(15)->get();
        $this->categories->load('products');
        View::share('categories', $this->categories);
    }

    public function index()
    {

        $blogs = Blogs::where('status', 1)->orderBy('id', 'DESC')->get();
        // dd($this->currency_format(15656262));
        $category = $this->categories;
        return view('client.pages.home', compact('category', 'blogs'));
    }
    public function createComment(Request $request)
    {

        $comment = Comment::create($request->all());
        $comment->load('customer', 'product');
        if (!empty($comment)) {
            return response()->json([
                'message' => "Bình luận thành công",
                'data' => $comment,
                'status' => "200"
            ]);
        }
        return response()->json([
            'message' => "Bình luận không hợp lệ",
            'data' => [],
            'status' => "500"
        ]);
    }

    public function isDateGreaterThanToday($date)
    {
        $givenDate = Carbon::parse($date);
        $currentDate = Carbon::now();

        return $givenDate->greaterThan($currentDate);
    }

    public function isDateLessThanToday($date)
    {
        $givenDate = Carbon::parse($date);
        $currentDate = Carbon::now();

        return $givenDate->lessThan($currentDate);
    }

    public function convertToJSON($dataString)
    {
        // Loại bỏ dấu ngoặc kép không cần thiết nếu có
        $dataString = str_replace('"', '', $dataString);

        // Chuyển đổi thành mảng PHP
        $dataArray = explode(',', $dataString);

        // Chuyển đổi thành chuỗi JSON
        $json = json_encode($dataArray);

        return $json;
    }

    public function checkVoucher(Request $request)
    {
        $data = $request->all();
        $sales = Sale::where('code', $data["voucher"])
            ->where('active', 1)
            ->where('number_sale', '>', 0)
            ->first();
        if ($sales) {
            if ($this->isDateLessThanToday($sales->time_start) && $this->isDateGreaterThanToday($sales->time_end)) {
                $data = ["1", "3", "4", "5"];

                $sales->products_id = json_decode($sales->products_id);
                return response()->json([
                    'message' => "Mã hợp lệ",
                    'data' => $sales,
                    'status' => "200"
                ]);
            }
        }

        return response()->json([
            'message' => "Mã không hợp lệ",
            'data' => [],
            'status' => "500"
        ]);
    }

    public function products(Request $request)
    {
        $categories_slug = '';
        // kiểm tra xem có  slug_cate không. nếu có thì lấy id catte từ slug
        if (request('slug_cate')) {
            $categories_slug = Category::where('slug', request('slug_cate'))->first();
            $categories_slug = $categories_slug ? $categories_slug : "";
        }
        $products = Product::filter(array_merge(request(['search', 'min', 'max', 'sort']), ['categories_slug' => $categories_slug]))
            ->where('status', 1)
            ->with(['productVariant'])
            ->Paginate(10);
        foreach ($products as $index => $value) {
            if (count($value['productVariant']) > 0) {
                $sortedProducts = $products[$index]['productVariant']->sortBy('price');
                $minPriceProduct = $sortedProducts->first();
                $maxPriceProduct = $sortedProducts->last();
                $products[$index]['minPiceProduct'] = $minPriceProduct->price;
                $products[$index]['maxPriceProduct'] = $maxPriceProduct->price;
            }
        }
        //dd($products[0]);
        $category = $this->categories->load('products');
        return view('client.pages.products', compact('category', 'products', 'categories_slug'));
    }


    // // Sử dụng hàm để lấy sản phẩm có giá thấp nhất và cao nhất
    // $minMaxPriceProducts = getMinMaxPriceProducts($products);
    // $minPriceProduct = $minMaxPriceProducts['min_price_product'];
    // $maxPriceProduct = $minMaxPriceProducts['max_price_product'];

    // Bây giờ bạn có thể sử dụng $minPriceProduct và $maxPriceProduct như mong muốn


    public function productDetail(Request $request, $slug)
    {
        $categories_slug = '';
        $Product = Product::with(['User', 'User.groupUser', 'comments.customer', 'productVariant', 'productImage'])->where('slug', $slug)->where('status', 1)->first();
        $Product->load('category');
        if (!$Product) {
            return redirect()->back();
        }
        $RelatedProducts = Product::where('slug', '!=', $slug)
            ->where('status', 1)
            ->where('category_id', $Product->category->id)
            ->orderBy('id', 'DESC')
            ->get();
        if (count($Product['productVariant']) > 0) {
            $sortedProducts = $Product['productVariant']->sortBy('price');
            $minPriceProduct = $sortedProducts->first();
            $maxPriceProduct = $sortedProducts->last();
            $Product['minPiceProduct'] = $minPriceProduct->price;
            $Product['maxPriceProduct'] = $maxPriceProduct->price;
        }
        // dd($Product->productVariant);
        return view('client.pages.product', compact('Product', 'RelatedProducts'));
    }

    public function blogs(Request $request)
    {
        $categories_slug = '';
        // kiểm tra xem có  slug_cate không. nếu có thì lấy id catte từ slug
        if (request('Category_Blog')) {
            $categories_slug = CategoryBlog::where('slug', request('Category_Blog'))->first();
            $categories_slug = $categories_slug ? $categories_slug : "";
        }
        // dd($categories_slug);
        $CategoryBlogs = CategoryBlog::all();
        $CategoryBlogs->load('blogs');
        $blogs = Blogs::filter(array_merge(request(['search']), ['categories_slug' => $categories_slug]))->orderBy('id', 'DESC')->Paginate(15);
        $blogs->load('CategoryBlog'); // gọi blogs bên modelBlogSeed
        $blogs->load('User');

        return view('client.pages.blogs', compact('blogs', 'CategoryBlogs', 'categories_slug'));
    }

    public function blog(Request $request, $slug)
    {
        $categories_slug = '';
        $Blog = Blogs::where('slug_blog', $slug)->where('status', 1)->first();
        $Blog->load('CategoryBlog');
        if (!$Blog) {
            return redirect()->back();
        }
        $CategoryBlogs = CategoryBlog::all();
        $CategoryBlogs->load('blogs');

        $RelatedCategorys = Blogs::where('slug_blog', '!=', $slug)
            ->where('status', 1)
            ->where('cate_blog_id', $Blog->CategoryBlog->id)
            ->orderBy('id', 'DESC')
            ->get();
        $Blog->load('CategoryBlog'); // gọi blogs bên modelBlogSeed
        $Blog->load('User');
        //dd($Blog);
        return view('client.pages.blog', compact('Blog', 'CategoryBlogs', 'categories_slug', 'RelatedCategorys'));
    }

    public function addCart(Request $request, $product_id)
    {
        $data = $request->all();
        $productQuantity = 0;
        $productVariantId = null;
        $quantity = request(['quantity']) ? (int)request()->quantity : 1;

        $config = config::first();
        if ($config->market_status == 0) {
            return response()->json([
                'message' => "Xin lỗi phiên chợ đã đóng ",
                'status' => "error"
            ]);
        }
        $Product = Product::with(['productVariant'])
            ->where('id', $product_id)
            ->where('status', 1)
            ->first();

        $CartQuery = Cart::where('product_id', $product_id)
            ->where('customer_id', auth()->user()->id);

        if (!empty($data['productVariant'])) {
            $CartQuery->where('product_variant_id', $data['productVariant']['id']);
        }

        $Cart = $CartQuery->first();


        // return [$data['productVariant']['id'], $Product,$Cart];
        try {
            DB::beginTransaction();
            if (!empty($data['productVariant'])) {
                $dataProductVariant =  $data['productVariant'];
                $productQuantity =  (int)$dataProductVariant["quantity"];
                $productVariantId = (int)$dataProductVariant["id"];
                $productVariantById = ProductVariant::find($productVariantId);
                if (!empty($productVariantById)) {
                    $newQuantity =  $productVariantById->quantity - $productQuantity;
                    $productVariantById->update(['quantity' =>  $newQuantity]);
                }
            } else {
                $productQuantity =  $Product->quantity;
                $newQuantity =  $productQuantity - $quantity;
                $Product->update(['quantity' =>  $newQuantity]);
            }
            if (!$Product) { // kiểm tra xem sản phẩm có tồn tại
                return response()->json([
                    'message' => "Không tìm thấy sản phẩm",
                    'status' => "error"
                ], $status = 401);
            }

            // check Sản phẩm hiện đã hết hàng
            if ($productQuantity <= 0) {
                return response()->json([
                    'message' => "Sản phẩm hiện đã hết hàng",
                    'status' => "error"
                ]);
            }
            // check số lượng san phẩm mua với số lượng hàng tồn kho
            if ($productQuantity < $quantity) {
                return response()->json([
                    'message' => "Sản phẩm hiện tại không còn đủ so với số lượng mua yêu cầu",
                    'status' => "error"
                ], $status = 401);
            }

            if (!empty($Cart)) { // kiểm tra xem sản phẩm đã có trong giỏ hàng chưa nếu có r thì update thêm sl sản phẩm
                $quantitys = (int)$Cart->quantity + $quantity;
                $Cart->update(['quantity' => $quantitys]);
            } else {
                $data = array_merge(['customer_id' => auth()->user()->id, 'product_id' => $product_id, 'quantity' => $quantity, 'product_variant_id' => $productVariantId]);
                Cart::create($data);
            }
            DB::commit();
            return response()->json([
                'message' => "Mua hàng thành công",
                'status' => "success"
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('message :', $exception->getMessage() . '--line :' . $exception->getLine());
            return redirect()->route('cp-admin.products.index')->with('error', 'Thêm sản phẩm thất bại !');
        }
    }

    public function removeCart(Request $request, $product_id)
    {

        $data = $request->all();
        $productCart = Cart::with(['productVariant'])->find($product_id);
        $variantValues = json_decode($productCart->productVariant->variant_value, true);
        try {
            DB::beginTransaction();
            $variantValues['quantity'] = $productCart->productVariant->quantity + $productCart->quantity;
            $newData= ['quantity' => $variantValues['quantity'],'variant_value' => json_encode($variantValues)];
            ProductVariant::find($productCart->productVariant->id)->update($newData);
            $productCart->delete();
            DB::commit();
            return response()->json([
                'message' => "Xóa sản phẩm thành công",
                'status' => "success"
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('message :', $exception->getMessage() . '--line :' . $exception->getLine());
            return response()->json([
                'message' => "Xin lỗi Xóa sản phẩm thất bại  ",
                'status' => "error"
            ]);
        }
    }

    public function carts()
    {
        $carts = Cart::where('customer_id', auth()->user()->id)
            ->orderBy('id', 'DESC')
            ->with(['user', 'products', 'productVariant'])
            ->get();

        $totalMoney = 0;
        foreach ($carts as $cart) {
            $totalMoney += ceil(($cart->products->price - ($cart->products->price * $cart->products->discounts) / 100) * $cart->quantity);
        }

        return view('client.pages.carts', compact('carts', 'totalMoney'));
    }

    public function payment()
    {
        $carts = Cart::where('customer_id', auth()->user()->id)
        ->orderBy('id', 'DESC')
        ->with(['user', 'products', 'productVariant'])
        ->get();

        $totalMoney = 0;
        foreach ($carts as $cart) {
            $totalMoney += ceil($cart->productVariant->price * $cart->quantity);
        }
        return view('client.pages.payment', compact('carts', 'totalMoney'));
    }

    public function updateCarts(Request $request)
    {
        for ($i = 0; $i < count($request->id); $i++) {
            $carts = Cart::with('products')->where('customer_id', auth()->user()->id)->where('id', $request->id[$i])->first();

            if ($carts) {
                $quantity = (int)$request->quantity[$i] == 0 ? 1 : (int)$request->quantity[$i];
                if ($carts->products->quantity >= $quantity) {
                    $carts->update(['quantity' => $quantity]);
                } else {
                    return redirect()->back()->with('error', 'Cập nhập thất bại ');
                }
            }
        }
        return redirect()->back();
    }

    public function updateProductCarts(Request $request, $product_id)
    {
        $data = $request->all();
        $productCart = Cart::with(['productVariant'])->find($product_id);
        $variantValues = json_decode($productCart->productVariant->variant_value, true);
        try {
            DB::beginTransaction();
            // số lượng lớn hơn đã có trong giỏ hàng thì - kho hàng
            if ((int)$data['quantity'] > $productCart->quantity) {
                $addQuantityProd = (int)$data['quantity'] - $productCart->quantity;

                if ($addQuantityProd > $productCart->productVariant->quantity) {
                    return response()->json([
                        'message' => "Xin lỗi phân loại của sản phẩm không còn đủ ",
                        'status' => "error"
                    ]);
                }
                $variantValues['quantity'] = $productCart->productVariant->quantity - $addQuantityProd;
                $newData= ['quantity' => $variantValues['quantity'],'variant_value' => json_encode($variantValues)];
                ProductVariant::find($productCart->productVariant->id)->update($newData);
                $productCart->update(['quantity' => (int)$data['quantity']]);
            } else if ((int)$data['quantity'] < $productCart->quantity) {
                $addQuantityProd = $productCart->quantity - (int)$data['quantity'];

                if ($addQuantityProd < 0) {
                    return response()->json([
                        'message' => "Xin lỗi phân loại của sản phẩm số lượng tối thiểu là 1  ",
                        'status' => "error"
                    ]);
                }
                $variantValues['quantity'] = $productCart->productVariant->quantity + $addQuantityProd;
                $newData= ['quantity' => $variantValues['quantity'],'variant_value' => json_encode($variantValues)];
                ProductVariant::find($productCart->productVariant->id)->update($newData);
                $productCart->update(['quantity' => (int)$data['quantity']]);
            }
            DB::commit();
            return response()->json([
                'message' => "Cập nhật số lượng thành công",
                'status' => "success"
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('message :', $exception->getMessage() . '--line :' . $exception->getLine());
            return response()->json([
                'message' => "Xin lỗi cập nhật số lượng thất bại  ",
                'status' => "error"
            ]);
        }
    }

    public function savePayment(Request $request)
    {

        DB::beginTransaction();
        try {
            $sales = [];
            $data = session()->get('order');
//            if (!empty($data['voucher'])) {
//                $sales = Sale::where('code', $data["voucher"])->where('number_sale', '>', 0)->where('active', 1)->first();
//                if (empty($sales)) {
//                    return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ');
//                }
//                if (!$this->isDateLessThanToday($sales->time_start) || !$this->isDateGreaterThanToday($sales->time_end)) {
//                    return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ');
//                }
//                $sales->update(['number_sale', $sales->number_sale -= 1]);
//            }
            if (empty($request->vnp_ResponseCode) || $request->vnp_ResponseCode != "00") {
                return redirect()->route('payment')->with('error', 'Đơn hàng mua thất bại');
            }



            $order = Order::create(array_merge(request()->all(), ['users_id' => auth()->user()->id]));


            $carts = Cart::where('customer_id', auth()->user()->id)
                ->orderBy('id', 'DESC')
                ->with(['products','user','productVariant'])
                ->get();

            if ($carts->count() <= 0) {
                return redirect()->back()->with('error', 'Không có sản phẩm nào trong giỏ hàng');
            }

            foreach ($carts as $cart) {
                $product = Product::find($cart->products->id);
                if ($product->quantity < $cart->quantity) {
                    return redirect()->back()->with('error', 'Sản phẩm không dủ trong kho');
                }
                $data['name'] = $cart->products->namePro;
                $data['slug'] = $cart->products->slug;
                $data['price'] = ceil($cart->productVariant->price);
                $data['quantity'] = $cart->quantity;
                $data['order_id'] = $order->id;
                $data['users_id'] = $cart->products->users_id;
                $data['totalPrice'] = ceil($data['price'] * $cart->quantity);
                $data['product_variant_id'] = $cart->productVariant->id;
                OrderDetail::create($data);
                $cart->delete();
            }

            DB::commit();
            session()->forget('order');
            return redirect()->route('payment')->with('message', 'Đơn hàng mua thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('payment')->with('error', 'Đơn hàng mua thất bại');
        }
    }
    public function checkout(checkoutRequest $request)
    {
        $sales = [];
        $data = $request->all();
        dump(asset('api/vn-pay'));
        session()->put('order', $data);
        DB::beginTransaction();
        try {
            $carts = Cart::where('customer_id', auth()->user()->id)
            ->orderBy('id', 'DESC')
            ->with(['products','user','productVariant'])
            ->get();
            if ($data['exampleRadios'] == "cash") {
                $order = Order::create(array_merge(request()->all(), ['users_id' => auth()->user()->id]));
                if ($carts->count() <= 0) {
                    return redirect()->back()->with('error', 'Không có sản phẩm nào trong giỏ hàng');
                }
                foreach ($carts as $cart) {
                    $product = Product::find($cart->products->id);
                    if ($product->quantity < $cart->quantity) {
                        return redirect()->back()->with('error', 'Sản phẩm không dủ trong kho');
                    }
                    $data['name'] = $cart->products->namePro;
                    $data['slug'] = $cart->products->slug;
                    $data['price'] = ceil($cart->productVariant->price);
                    $data['quantity'] = $cart->quantity;
                    $data['order_id'] = $order->id;
                    $data['users_id'] = $cart->products->users_id;
                    $data['totalPrice'] = ceil($data['price'] * $cart->quantity);
                    $data['product_variant_id'] = $cart->productVariant->id;
                    OrderDetail::create($data);
                    $cart->delete();
                }
            } else {
                $totalPayment = 0;
                if ($carts->count() <= 0) {
                    return redirect()->back()->with('error', 'Không có sản phẩm nào trong giỏ hàng');
                }
                foreach ($carts as $cart) {
                    $product = Product::find($cart->products->id);
                    if ($product->quantity < $cart->quantity) {
                        return redirect()->back()->with('error', 'Sản phẩm không dủ trong kho');
                    }
                    $totalPayment += ceil($cart->productVariant->price * $cart->quantity);
                }

                $response = $this->makeCurlRequestAndRedirect($totalPayment);
                return redirect()->to($response);
            }
            DB::commit();
            return redirect()->back()->with('message', 'Đơn hàng mua thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đơn hàng mua thất bại');
        }
    }
    public function makeCurlRequestAndRedirect($price)
    {
        // Your cURL request
        $data = [
            'vnp_TmnCode' => 'NRQRJA4J',
            'vnp_HashSecret' => 'GLQYEDNCQMOQNNTMBWMPAAEDPWTWLFOH',
            'vnp_Returnurl' => route('payment-vnpay'),
            'vnp_Amount' => $price,
        ];
        $response = $this->vnPayController->create($data);
        return $response["data"];
    }
    public function order()
    {
        $Orders = Order::where('users_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $Orders->load('order_detail');
        return view('client.pages.order', compact('Orders'));
    }

    public function order_detail(Request $request, $id)
    {
        $Orders = Order::where('users_id', auth()->user()->id)->where('id', $id)->first();
        $Orders->load('order_detail');
        if ($Orders) {
            //  dd($Orders);
            $totalMoney = 0;
            foreach ($Orders->order_detail as $order) {
                $totalMoney += $order->price * $order->quantity;
            }

            return view('client.pages.order_detail', compact('Orders', 'totalMoney'));
        }
        return redirect()->back()->with('error', 'Không tìm thấy sản phẩn của đơn hàng');
    }

    public function contact()
    {
        return view('client.pages.contact');
    }

    public function sentContact(Request $request)
    {
        $this->validate(
            request(),
            [
                'name' => 'required|min:3|max:100',
                'email' => 'required|email|unique:users,email',
            ],
            [
                'name.required' => 'Bạn chưa nhập họ và tên',
                'name.min' => 'Họ và tên phải có Độ dài  từ 3 đến 100 ký tự',
                'name.max' => 'Họ và tên phải có Độ dài  từ 3 đến 100 ký tự',
                'email.required' => 'Bạn chưa nhập email',
                'email.email' => 'Email không đúng định dạng',
            ]
        );
        contact::create(request()->all());
        return redirect()->back()->with('message', ' Giửi liên hệ thành công');
    }

    public function registerCreate(Request $request)
    {
        request()->validate([
            'email' => 'email|required|unique:users,email',
            'password' => 'confirmed|min:6|required',
            // 'password_confirmation' => 'confirmed'
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ e-mail !!',
            'email.unique' => 'Email đã tồn tại trong hệ thống!! Nếu bạn đã có tài khoản, Xin vui lòng đăng nhập',
            'password.required' => "Vui lòng nhập mật khẩu .",
            'email.email' => 'Email không hợp lệ, Xin vui lòng thử lại!!',
            'password.min' => "Mật khẩu phải có ít nhất 6 ký tự.",
            'password.confirmed' => "Mật khẩu xác nhận không đúng.",
            // 'password_confirmation.confirmed' => 'Mật khẩu xác nhận không đúng'
        ]);
        $data = [
            'password' => bcrypt(request('password')),
            'email' => request('email'),
            'status' => true,
            'fullname' => "new customer",
            'role_id' => 1,
            'avatar' => '0',
            'is_admin' => 0,
            'group_user' => 1
        ];

        $createUser = User::create($data);
        if ($createUser) {
            auth()->attempt(request(['email', 'password']));
            return redirect()->route('home')->with('message', ' Tạo tài khoản thành công');
        }

        return redirect()->back()->with('error', ' Tạo tài khoản thất bại');
    }

    public function register()
    {
        return view('admin.pages.auth.register');
    }

    public function logout()
    {
        // kiểm tra xem đã đăng nhập chưa . nếu đăng r thì logout . còn chưa thì về quay về trang login
        if (auth()->user()) {
            auth()->logout();
        }
        return redirect()->route('home')->with('message', ' Thoát tài khoản thành công');
    }

    public function forgetPassword()
    {
        return view('admin.pages.auth.ForgetPassword');
    }

    public function SentPassword()
    {
        request()->validate([
            'email' => 'email|required|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ e-mail !!',
            'email.email' => 'Email không hợp lệ, Xin vui lòng thử lại!!',
            'email.exists' => 'Email chưa được đăng ký!!'
        ]);
        $PasswordReset = User::where('email', request('email'))->first();
        $data['token'] = bcrypt(request('email'));
        $data['email'] = request('email');
        $data['user'] = $PasswordReset;
        if ($Password = PasswordReset::where('email', request('email'))->first()) {
            $Password->update($data);
        } else {
            $PasswordReset = PasswordReset::create($data);
        }

        Mail::to(request('email'))->send(new ForgetPassMail($data));
        return view('admin.pages.auth.ForgetPassword')->with('message', ' Yêu cầu đã được giửi đi vui lòng kiêm tra email');
    }

    public function ChangePassword()
    {
        return view('admin.pages.auth.ChangePass');
    }

    public function SentChangePassword()
    {
        request()->validate([
            'email' => 'email|required|exists:users,email',
            'password' => 'confirmed|min:6|required',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ e-mail !!',
            'email.exists' => 'Email chưa được đăng ký!!',
            'password.required' => "Vui lòng nhập mật khẩu .",
            'email.email' => 'Email không hợp lệ, Xin vui lòng thử lại!!',
            'password.min' => "Mật khẩu phải có ít nhất 6 ký tự.",
            'password.confirmed' => "Mật khẩu xác nhận không đúng.",

        ]);
        $PasswordReset = PasswordReset::where('email', request('email'))->where('token', request('token'))->first();
        // dd( $PasswordReset,$token);
        if ($PasswordReset) {
            $customer = User::where('email', request('email'))->first();
            $customer->update([
                'password' => bcrypt(request('password')),
                'status' => 1
            ]);
            auth()->attempt(request(['email', 'password']));
            $PasswordReset->delete();
            return redirect()->route('home')->with('message', ' Đổi mật khẩu  thành công');
        }
        return redirect()->back()->with('error', 'Thông tin đổi mật khẩu không đúng');
    }

    public function profile(Request $request)
    {
        return view('client.pages.profile');
    }

    public function UpdateProfile(Request $request)
    {
        request()->validate([
            'email' => 'email|required|unique:users,email,' . auth()->user()->id,
            'fullname' => 'required|min:3|max:100',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'phone' => 'required|numeric|digits_between:10,12|unique:users,phone,' . auth()->user()->id,
            'address' => 'required|min:3|max:200',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ e-mail !!',
            'email.unique' => 'Email đã tồn tại trong hệ thống!!',
            'email.email' => 'Email không hợp lệ, Xin vui lòng thử lại!!',
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

        ]);
        if ($request->file('avatar') != null) {
            if (file_exists('storage/' . auth()->user()->avatar)) {
                unlink('storage/' . auth()->user()->avatar);
            }
            $pathAvatar = $request->file('avatar')->store('public/users/avatar');
            $pathAvatar = str_replace("public/", "", $pathAvatar);
        } else {
            $pathAvatar = auth()->user()->avatar;
        }
        $data = request(['fullname', 'phone', 'address']);
        $data['avatar'] = $pathAvatar;
        $user = User::find(auth()->user()->id)->update($data);
        return redirect()->back()->with('message', 'Cập nhật thông tin thành công');
    }
}
