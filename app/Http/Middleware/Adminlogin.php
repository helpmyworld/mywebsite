<?php

namespace App\Http\Middleware;

use function GuzzleHttp\uri_template;
use Illuminate\Support\Facades\Route;
use Closure;
use Session;
use App\Admin;

class Adminlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty(Session::has('adminSession'))){
            return redirect('/admin');
        }else{
            // Get Admin/Sub Admin Details
            $adminDetails = Admin::where('username',Session::get('adminSession'))->first();
            $adminDetails = json_decode(json_encode($adminDetails),true);
            if($adminDetails['type']=="Admin"){
                $adminDetails['categories_access']=1;
                $adminDetails['products_access']=1;
                $adminDetails['orders_access']=1;
                $adminDetails['users_access']=1;
                $adminDetails['coupons_access']=1;
                $adminDetails['manuscripts_access']=1;
                $adminDetails['banners_access']=1;
                $adminDetails['posts_access']=1;
                $adminDetails['cats_access']=1;
                $adminDetails['tags_access']=1;
                $adminDetails['subscriptions_access']=1;
                $adminDetails['benefits_access']=1;
                $adminDetails['admins_access']=1;
                $adminDetails['posters_access']=1;
                $adminDetails['works_access']=1;
                $adminDetails['websites_access']=1;
                $adminDetails['website_work_access']=1;
                $adminDetails['hosts_access']=1;
            }
            Session::put('adminDetails', $adminDetails);
//            echo "<pre>"; print_r(Session::get('adminDetails')); die;

            //Get Current Path
            $currentPath = Route::getFacadeRoot()->current()->uri();

            if($currentPath=="/admin/view-categories" && Session::get('adminDetails')['
                categories_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/view-users" && Session::get('adminDetails')['
                users_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/view-products" && Session::get('adminDetails')['
                products_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/view-orders" && Session::get('adminDetails')['
                orders_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/view-coupons" && Session::get('adminDetails')['
                coupons_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/view-banners" && Session::get('adminDetails')['
                banners_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/view-admins" && Session::get('adminDetails')['
                admins_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/posts.index" && Session::get('adminDetails')['
                posts_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/tags.index" && Session::get('adminDetails')['
                tags_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/cats.index" && Session::get('adminDetails')['
               cats_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/view-cms-pages" && Session::get('adminDetails')['
                cms_pages_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/view-posters" && Session::get('adminDetails')['
                posters_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }
            if($currentPath=="/admin/admin.subscription.authors.index" && Session::get('adminDetails')['
                	user_subscription_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }
            if($currentPath=="/admin/admin.websites.index" && Session::get('adminDetails')['
                websites_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }
            if($currentPath=="/admin/admin.websites.index" && Session::get('adminDetails')['
                website_work_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }
            if($currentPath=="/admin/admin.work.index" && Session::get('adminDetails')['
                works_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }

            if($currentPath=="/admin/admin.hosts.index" && Session::get('adminDetails')['
                hosts_access']==0){
                return redirect('/admin/dashboard')->with('flash_message_error',
                    'You have no access for this function');
            }
        }
        return $next($request);
    }
}
