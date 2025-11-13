<?php

namespace App;

//use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    //use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','email','password','role','type','bio','city','state','country','profile_image'.
        'facebook','linkln','gplus','twitter','pincode','status','email_verified_at','type',
        'admin'
    ];

   use HasSlug;
    
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
  

    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function favorite_posts()
    {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function admin()
    {
        return $this->hasMany('App\Admin');
    }
    public function scopeAuthors($query)
    {
        return $query->where('role_id',2);
    }

    public function manuscripts(){
        return $this->hasMany('App\Manuscript','user_id');
    }

    public function manuscript_orders() {
        return $this->hasMany('App\ManuscriptOrder', 'user_id');
    }

    public function subscriptions() {
        return $this->hasMany('App\UserSubscription', 'user_id');
    }

    public function sub() {
        return UserSubscription::where('user_id',$this->id)->orderBy('id','desc')->first();
    }

    public function active_subscription() {
        return UserSubscription::where('user_id',$this->id)->whereStatus('Active')->where('subscription_name','!=','Indie.Africa')->first();
    }

    public function premium_subscription() {
        return UserSubscription::where('user_id',$this->id)->whereStatus('Active')->where('subscription_name','Indie.Africa')->first();
    }

    public function getAttributeFirstName() {
        $name = explode(' ',$this->name);
        return $name[0];
    }

    public function getAttributeLastName() {
        $name = explode(' ',$this->name);
        return $name[1];
    }

    public function products(){
        return $this->hasMany('App\Product','user_id');
    }

    public function orders($product_id){
        $order_ids = OrdersProduct::where('product_id',$product_id)->pluck('order_id')->toArray();
        return Order::whereIn('id',$order_ids)->get();
    }

    function snippet( $str, $wordCount = 10 ) {
        return implode(
            '',
            array_slice(
                preg_split(
                    '/([\s,\.;\?\!]+)/',
                    $str,
                    $wordCount*2+1,
                    PREG_SPLIT_DELIM_CAPTURE
                ),
                0,
                $wordCount*2-1
            )
        );
    }



}
