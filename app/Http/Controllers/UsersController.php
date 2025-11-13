<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\User;
use App\Product;
use App\Country;
use Auth;
use Session;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Exports\usersExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Image; // Intervention Image for user images

class UsersController extends Controller
{
    public function userLoginRegister(){
        $meta_title = "User Login/Register - Publishing Books";
        return view('users.login_register')->with(compact('meta_title'));
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                $userStatus = auth()->user();

                if($userStatus->status == 0){
                    return redirect()->back()->with('flash_message_error','Your account is not activated! Please confirm your email to activate.');
                } else {
                    if($userStatus->type == 'Author'){
                        Session::put('frontSession',$data['email']);

                        if(!empty(Session::get('session_id'))){
                            $session_id = Session::get('session_id');
                            DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]);
                        }
                        return redirect()->route('author.dashboard');
                    } else {
                        Session::put('frontSession',$data['email']);

                        if(!empty(Session::get('session_id'))){
                            $session_id = Session::get('session_id');
                            DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]);
                        }

                        return redirect('/cart');
                    }
                }

            } else {
                return redirect()->back()->with('flash_message_error','Invalid Username or Password!');
            }
        }
    }

    public function register(Request $request){
        // Validate including Turnstile response
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required',
            'cf-turnstile-response' => 'required',
        ], [
            'cf-turnstile-response.required' => 'Please confirm you are not a robot.',
        ]);

        // Server-side Turnstile verification
        $token    = $request->input('cf-turnstile-response');
        $remoteIp = $request->ip();

        if (!$this->verifyTurnstile($token, $remoteIp)) {
            return redirect()->back()
                ->withInput($request->except('password'))
                ->withErrors(['cf-turnstile-response' => 'Captcha verification failed. Please try again.']);
        }

        if($request->isMethod('post')){
            $data = $request->except(['_token','password']);
            $data['password'] = bcrypt($request->password);

            if($this->userExists($data['email'])){
                return redirect()->back()->with('flash_message_error','Email already exists!');
            }

            // Create user
            $user = new \App\User;
            $user->name     = $data['name']     ?? '';
            $user->email    = $data['email'];
            $user->password = $data['password'];
            $user->status   = 1;
            $user->type     = $data['type'] ?? 'Customer';
            $user->save();

            // (Optional) send welcome/verification email – your original code
            // Mail::send(...)

            // Login & redirect (preserve your original flow)
            Auth::loginUsingId($user->id);

            if ($user->type === 'Author') {
                Session::put('frontSession',$data['email']);
                if(!empty(Session::get('session_id'))){
                    $session_id = Session::get('session_id');
                    DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]);
                }
                return redirect()->route('author.dashboard');
            }

            Session::put('frontSession',$data['email']);
            if(!empty(Session::get('session_id'))){
                $session_id = Session::get('session_id');
                DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]);
            }

            return redirect('/');
        }
    }

    public function forgotPassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $userCount = User::where('email',$data['email'])->count();
            if($userCount == 0){
                return redirect()->back()->with('flash_message_error', 'Email does not exist');
            }
            $userDetails = User::where('email', $data['email'])->first();
            $random_password = str_random(8);
            $new_password = bcrypt($random_password);
            User::where('email',$data['email'])->update(['password' => $new_password]);

            $email = $data ['email'];
            $name = $userDetails->name;
            $messageData = [
                'email'=>$email,
                'name'=>$name,
                'password' =>$random_password
            ];
            Mail::send('emails.forgotpassword', $messageData, function($message)use($email){
                $message->to($email)->subject('New Password - Helpmyorld Publishing');
            });
            return redirect('login-register')->with('flash_message_success', 'Please check your email for new password');

        }

        return view ('users.forgot_password');
    }

    public function create($data){

        $user = User::create($data);

        // Send Confirmation Email
        $email = $user->email;
        $messageData = ['email'=>$user->email,'name'=>$data['name'],'code'=>base64_encode($data['email'])];
        Mail::send('emails.confirmation',$messageData,function($message) use($email){
            $message->to($email)->subject('Confirm your Account');
        });

        return $user;
    }

    public function userExists($email){
        return User::whereEmail($email)->exists();
    }

    public function confirmAccount($email){
        $email = base64_decode($email);
        $userCount = User::where('email',$email)->count();
        if($userCount > 0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status == 1){
                return redirect('login-register')->with('flash_message_success','Your Email account is already activated. You can login now.');
            }else{
                User::where('email',$email)->update(['status'=>1]);

                $messageData = ['email'=>$email,'name'=>$userDetails->name];
                Mail::send('emails.welcome',$messageData,function($message) use($email){
                    $message->to($email)->subject('Welcome to Helpmyworld ');
                });

                return redirect('login-register')->with('flash_message_success','Your Email account is activated. You can login now.');
            }
        }else{
            abort(404);
        }
    }

    public function account(Request $request){
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id);
        $countries = Country::get();

        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['name'])){
                return redirect()->back()->with('flash_message_error','Please enter your Name to update your account details!');
            }

            if(empty($data['address'])){ $data['address'] = ''; }
            if(empty($data['city'])){ $data['city'] = ''; }
            if(empty($data['state'])){ $data['state'] = ''; }
            if(empty($data['country'])){ $data['country'] = ''; }
            if(empty($data['pincode'])){ $data['pincode'] = ''; }
            if(empty($data['mobile'])){ $data['mobile'] = ''; }

            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();
            return redirect()->back()->with('flash_message_success','Your account details has been successfully updated!');
        }

        return view('users.account')->with(compact('countries','userDetails'));
    }

    public function chkUserPassword(Request $request){
        $data = $request->all();
        $current_password = $data['current_pwd'];
        $user_id = Auth::User()->id;
        $check_password = User::where('id',$user_id)->first();
        if(Hash::check($current_password,$check_password->password)){
            echo "true"; die;
        }else{
            echo "false"; die;
        }
    }

    public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $old_pwd = User::where('id',Auth::User()->id)->first();
            $current_pwd = $data['current_pwd'];
            if(Hash::check($current_pwd,$old_pwd->password)){
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id',Auth::User()->id)->update(['password'=>$new_pwd]);
                return redirect()->back()->with('flash_message_success',' Password updated successfully!');
            }else{
                return redirect()->back()->with('flash_message_error','Current Password is incorrect!');
            }
        }
    }

    public function logout(){
        Auth::logout();
        Session::forget('frontSession');
        Session::forget('session_id');
        return redirect('/');
    }

    public function checkEmail(Request $request){
        $data = $request->all();
        $usersCount = User::where('email',$data['email'])->count();
        if($usersCount>0){
            echo "false";
        }else{
            echo "true"; die;
        }
    }

    public function viewUsers()
    {
        // 0 = featured authors, 1 = other authors, 2 = non-authors
        $users = User::orderByRaw("
                CASE
                    WHEN type = 'Author' AND featured_author = 1 THEN 0
                    WHEN type = 'Author' AND featured_author = 0 THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.view_users')->with(compact('users'));
    }

    public function deleteUser($id = null){
        User::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'User has been deleted successfully');
    }

    public function exportUsers(){
        return Excel::download(new usersExport,'users.xlsx');
    }

    public function viewUsersCharts(){
        $current_month_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $last_month_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
        $last_to_last_month_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2))->count();
        return view('admin.users.view_users_charts')->with(compact('current_month_users','last_month_users','last_to_last_month_users'));
    }

    public function viewUsersCountriesCharts(){
        $getUserCountries = User::select('country',DB::raw('count(country) as count'))->groupBy('country')->get();
        $getUserCountries = json_decode(json_encode($getUserCountries),true);
        return view('admin.users.view_users_countries_charts')->with(compact('getUserCountries'));
    }

    public function addUser(Request $request)
    {
        if ($request->method() === 'POST') {
            try {
                DB::beginTransaction();

                // relaxed validation
                $request->validate([
                    'name'  => ['nullable','string','max:255'],
                    'email' => ['nullable','email','max:255'],
                    'type'  => ['nullable','in:User,Author'],
                    'profile_image' => ['nullable','image','mimes:jpeg,png,gif','max:4096'],
                    'product_ids.*' => ['nullable','integer'],
                ]);

                $user = new User;
                $user->name   = $request->input('name');
                $user->email  = $request->input('email');
                $user->type   = $request->input('type', 'User');
                $user->bio    = $request->input('bio');
                $user->status = 1; // auto active
                $user->featured_author = $request->filled('featured_author') ? 1 : 0;

                // optional slug if your table uses it
                if (isset($user->slug) && empty($user->slug) && !empty($user->name)) {
                    $user->slug = Str::slug($user->name).'-'.time();
                }

                // User image handling
                if ($request->hasFile('profile_image')) {
                    $image_tmp = $request->file('profile_image');
                    if ($image_tmp->isValid()) {
                        $extension = $image_tmp->getClientOriginalExtension();
                        $fileName  = rand(111, 99999) . '.' . $extension;

                        $large_path  = 'images/backend_images/authors/large/'  . $fileName;
                        $medium_path = 'images/backend_images/authors/medium/' . $fileName;
                        $small_path  = 'images/backend_images/authors/small/'  . $fileName;

                        @mkdir(public_path('images/backend_images/authors/large'), 0775, true);
                        @mkdir(public_path('images/backend_images/authors/medium'), 0775, true);
                        @mkdir(public_path('images/backend_images/authors/small'), 0775, true);

                        Image::make($image_tmp)->save(public_path($large_path));
                        Image::make($image_tmp)->resize(700, 700)->save(public_path($medium_path));
                        Image::make($image_tmp)->resize(700, 700)->save(public_path($small_path));

                        $user->profile_image = $fileName;
                    }
                }

                $user->save();

                // associate selected products
                $ids = $request->input('product_ids', []);
                if (is_array($ids) && count($ids)) {
                    Product::whereIn('id', $ids)->update(['user_id' => $user->id]);
                }

                DB::commit();
                return redirect('/admin/view-users')->with('flash_message_success', 'User added successfully');
            } catch (\Throwable $e) {
                DB::rollBack();
                return back()->withInput()->with('flash_message_error', $e->getMessage());
            }
        }

        $products = Product::orderBy('product_name', 'asc')->get();
        return view('admin.users.add_users', compact('products'));
    }

    public function editUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->method() === 'POST') {
            try {
                DB::beginTransaction();

                // relaxed validation
                $request->validate([
                    'name'  => ['nullable','string','max:255'],
                    'email' => ['nullable','email','max:255'],
                    'type'  => ['nullable','in:User,Author'],
                    'profile_image' => ['nullable','image','mimes:jpeg,png,gif','max:4096'],
                    'product_ids.*' => ['nullable','integer'],
                ]);

                $user->name   = $request->input('name', $user->name);
                $user->email  = $request->input('email', $user->email);
                $user->type   = $request->input('type', $user->type);
                $user->bio    = $request->input('bio', $user->bio);
                $user->featured_author = $request->filled('featured_author') ? 1 : 0;

                if ($request->hasFile('profile_image')) {
                    $image_tmp = $request->file('profile_image');
                    if ($image_tmp->isValid()) {
                        $extension = $image_tmp->getClientOriginalExtension();
                        $fileName  = rand(111, 99999) . '.' . $extension;

                        $large_path  = 'images/backend_images/authors/large/'  . $fileName;
                        $medium_path = 'images/backend_images/authors/medium/' . $fileName;
                        $small_path  = 'images/backend_images/authors/small/'  . $fileName;

                        @mkdir(public_path('images/backend_images/authors/large'), 0775, true);
                        @mkdir(public_path('images/backend_images/authors/medium'), 0775, true);
                        @mkdir(public_path('images/backend_images/authors/small'), 0775, true);

                        Image::make($image_tmp)->save(public_path($large_path));
                        Image::make($image_tmp)->resize(700, 700)->save(public_path($medium_path));
                        Image::make($image_tmp)->resize(700, 700)->save(public_path($small_path));

                        $user->profile_image = $fileName;
                    }
                }

                $user->save();

                $ids = $request->input('product_ids', []);
                if (is_array($ids)) {
                    Product::whereIn('id', $ids)->update(['user_id' => $user->id]);
                }

                DB::commit();
                return redirect('/admin/view-users')->with('flash_message_success', 'User updated successfully');
            } catch (\Throwable $e) {
                DB::rollBack();
                return back()->withInput()->with('flash_message_error', $e->getMessage());
            }
        }

        $products = Product::orderBy('product_name', 'asc')->get();
        $selectedProductIds = Product::where('user_id', $user->id)->pluck('id')->toArray();

        return view('admin.users.edit_users', compact('user', 'products', 'selectedProductIds'));
    }

    // =========================
    // NEW: Bulk hard delete
    // =========================
    public function bulkDeleteUsers(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || count($ids) === 0) {
            return redirect()->back()->with('flash_message_error', 'No users selected.');
        }

        try {
            DB::beginTransaction();

            // Hard delete in bulk
            User::whereIn('id', $ids)->delete();

            DB::commit();
            return redirect()->back()->with('flash_message_success', 'Selected users have been deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('flash_message_error', $e->getMessage());
        }
    }

    /**
     * Verify Cloudflare Turnstile token server-side.
     */
    private function verifyTurnstile(?string $token, ?string $remoteIp): bool
    {
        $secret = config('turnstile.secret_key');
        $url    = config('turnstile.verify_url');

        if (empty($secret) || empty($token)) {
            return false;
        }

        $postData = http_build_query([
            'secret'   => $secret,
            'response' => $token,
            'remoteip' => $remoteIp,
        ]);

        $opts = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n"
                           . "Content-Length: " . strlen($postData) . "\r\n",
                'content' => $postData,
                'timeout' => 10,
            ],
            'ssl' => [
                'verify_peer'      => true,
                'verify_peer_name' => true,
            ],
        ];

        $context = stream_context_create($opts);
        $result  = @file_get_contents($url, false, $context);

        if ($result === false) {
            return false;
        }

        $json = json_decode($result, true);
        return isset($json['success']) && $json['success'] === true;
    }
}
