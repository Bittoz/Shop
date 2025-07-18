<?php

namespace DownGrade\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use DownGrade\Models\Settings;
use Auth;
use Session;
use Storage;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class Product extends Model
{

   protected $table = 'product';
   
   public function Ratings()
    {
        return $this->hasMany(Ratings::class, 'or_product_id', 'product_id');
    } 
	
	public static function savereport($savedata)
   {
   
      DB::table('product_report')->insert($savedata);
     
 
  }
	
	
	public static function deleteWithdraw($wd_id){
    
		
	DB::table('product_withdrawal')->where('wd_id', '=', $wd_id)->delete();	
	
	
  }
  
  public static function deleteRefund($refund_id)
	{
    
		
	DB::table('product_refund')->where('refund_id', '=', $refund_id)->delete();	
	
	}
	
	public static function purchasedBuyer($token)
  {

    $value=DB::table('product_order')->where('product_token','=', $token)->where('order_status','=', 'completed')->where('approval_status','!=', 'payment released to customer')->get();
	return $value;
	
  }
  
   public static function checkVerify($purchase_code) 
  {

    $get=DB::table('product_order')->join('users','users.id','product_order.user_id')->join('product','product.product_id','product_order.product_id')->where('product_order.order_status','=', 'completed')->where('product_order.approval_status','=', 'payment released to admin')->where('product_order.purchase_code','=', $purchase_code)->get();
	$value = $get->count();
	return $value;
	
  }
  
	public static function possibleVerify($purchase_code) 
  {

    $get=DB::table('product_order')->join('users','users.id','product_order.user_id')->join('product','product.product_id','product_order.product_id')->where('product_order.order_status','=', 'completed')->where('product_order.approval_status','=', 'payment released to admin')->where('product_order.purchase_code','=', $purchase_code)->first();
	return $get;
	
  }
	
	public static function checkPurchased($logged,$token)
  {

    $get=DB::table('product_order')->where('product_token','=', $token)->where('user_id','=', $logged)->where('approval_status','!=', 'payment released to customer')->get();
	$value = $get->count(); 
    return $value;
	
  }
  
  public static function autoSearch($query)
  {

    $value=DB::table('product')->where('product_name', 'LIKE', '%'. $query. '%')->where('product_drop_status','=','no')->where('product_status','=',1)->orderBy('product_name', 'asc')->get(); 
    return $value;
	
  }
  
  
  public static function getgroupitemData()
  {

    $value=DB::table('product')->where('product_drop_status','=','no')->where('product_status','=',1)->get()->groupBy('product_category'); 
    return $value;
	
  }	
   
   /* single item */
   
      
   
   public static function singleitemData($slug)
   {
     $value=DB::table('product')->join('category', 'category.cat_id', '=', 'product.product_category_parent')->join('users','users.id','product.user_id')->where('product.product_drop_status','=','no')->where('product.product_status','=',1)->where('product.product_slug','=',$slug)->first(); 
     return $value;
   }
   
   
   public static function singleitemCount($slug)
   {
     $get=DB::table('product')->join('users','users.id','product.user_id')->where('product.product_drop_status','=','no')->where('product.product_status','=',1)->where('product.product_slug','=',$slug)->get(); 
     $value = $get->count(); 
     return $value;
   }
   
   public static function getimagesCount($token)
  {

    $get=DB::table('product_images')->where('product_token','=', $token)->orderBy('prod_gal_id', 'desc')->get();
	$value = $get->count(); 
    return $value;
	
  }
  public static function getimagesFirst($token)
  {
    $value=DB::table('product_images')->where('product_token','=', $token)->orderBy('prod_gal_id', 'desc')->first();
	return $value;
  } 
  
  public static function getimagesAll($token)
  {
    $value=DB::table('product_images')->where('product_token','=', $token)->orderBy('prod_gal_id', 'desc')->get();
	return $value;
  }
  
  public static function getProdutData($session_id)
  {
    $query = ".zip";
    $value=DB::table('product_data')->where('session_id','=', $session_id)->where('original_file_name', 'NOT LIKE', '%'. $query. '%')->orderBy('prd_id', 'asc')->get();
	return $value;
  }
  
  public static function getProdutZip($session_id)
  { 
    $query = ".zip";
    $value=DB::table('product_data')->where('session_id','=', $session_id)->where('original_file_name', 'LIKE', '%'. $query. '%')->orderBy('prd_id', 'asc')->get();
	return $value;
  }
  
  public static function ifpurchaseCount($token)
  {
    $today = date('Y-m-d');
	$user_id = Auth::user()->id;
    $get=DB::table('product_order')->where('product_token','=', $token)->where('user_id','=', $user_id)->where('order_status','=','completed')->where('approval_status','=','payment released to admin')->where('end_date','>',$today)->get();
	$value = $get->count(); 
    return $value;
	
  }
  
  public static function savecommentData($comment_data)
  {
   
      DB::table('product_comments')->insert($comment_data);
     
 
  }
  public static function replycommentData($comment_data)
  {
   
      DB::table('product_comment_reply')->insert($comment_data);
     
 
  }
  public static function getreviewItems($product_id)
  {
    $value = DB::table('product_ratings')->join('product','product.product_id','product_ratings.or_product_id')->where('product_ratings.or_product_id','=', $product_id)->orderBy('product_ratings.rating_date', 'desc')->get();
	return $value;
  }
  
  public static function getreviewCount($product_id)
  {
    $get = DB::table('product_ratings')->join('product','product.product_id','product_ratings.or_product_id')->where('product_ratings.or_product_id','=', $product_id)->orderBy('product_ratings.rating_date', 'desc')->get();
	$value = $get->count(); 
	return $value;
  }
  
  
  public static function getreviewView($product_id)
  {
    $value = DB::table('product_ratings')->where('or_product_id','=', $product_id)->get();
	return $value;
  }
  
  public static function getreviewRecord($product_id)
  {

    $get=DB::table('product_ratings')->where('or_product_id','=', $product_id)->get();
	$value = $get->count(); 
    return $value;
	
  }
  
  public static function itemapprovedCheck($status)
  {
    
    $get=DB::table('product')->where('product_drop_status','=','no')->where('product_status','=',$status)->get(); 
	$value = $get->count();
    return $value;
	
  }	
  
  public static function minpriceData()
  {

    $value=DB::table('product')->where('product_status','=',1)->where('product_drop_status','=','no')->orderBy('regular_price', 'asc')->first(); 
    return $value;
	
  }	
  
  public static function maxpriceData()
  {

    $value=DB::table('product')->where('product_status','=',1)->where('product_drop_status','=','no')->orderBy('extended_price', 'desc')->first(); 
    return $value;
	
  }
  
  
  public static function minpriceCount()
  {

    $get=DB::table('product')->where('product_status','=',1)->where('product_drop_status','=','no')->orderBy('regular_price', 'asc')->get();
	$value = $get->count();  
    return $value;
	
  }	
  
  public static function maxpriceCount()
  {

    $get=DB::table('product')->where('product_status','=',1)->where('product_drop_status','=','no')->orderBy('extended_price', 'desc')->get();
	$value = $get->count();  
    return $value;
	
  }
  
  public static function getallItems()
	{
	  $value=DB::table('product')->where('product_status','=',1)->where('product_drop_status','=','no')->orderBy('product_id', 'desc')->get();
	  return $value;
	}
  
  public static function SoldProduct()
  {

    $value=DB::table('product')->where('product_status','=',1)->where('product_drop_status','=','no')->get();
	return $value;
	
  }	
  
  public static function DemoProduct()
  {

    $value=DB::table('product')->where('product_status','=',1)->where('product_demo_url','!=','')->where('product_drop_status','=','no')->get();
	return $value;
	
  }	
  
  
  public static function findProduct($product_token)
  {

    $get=DB::table('product')->where('product_token','=',$product_token)->get();
	$value = $get->count(); 
    return $value;
	
	
  }	
  
  
  public static function GetAllProducts()
  {

    $value=DB::table('product')->get();
	return $value;
	
  }	
  
  public static function getfavouriteCount($product_id,$log_user)
  {

    $get=DB::table('product_favorite')->where('product_id','=', $product_id)->where('user_id','=', $log_user)->get();
	$value = $get->count(); 
    return $value;
	
  }
  
  public static function savefavouriteData($data)
  {
   
      DB::table('product_favorite')->insert($data);
     
 
  }
  
  public static function offFlash($off_flash)
  {
    DB::table('product')
      ->where('product_id','!=','')
      ->update($off_flash);
  }
  
  
  public static function updatefavouriteData($product_id,$record)
  {
    DB::table('product')
      ->where('product_id', $product_id)
      ->update($record);
  }
  
 
  public static function dropFavitem($fav_id){
    
		
	DB::table('product_favorite')->where('fav_id', '=', $fav_id)->delete();	
	
	
  }
  
  public static function deleteDATA($session_id)
  {
     DB::table('product_data')->where('session_id', '=', $session_id)->delete();	
  }
  
  public static function selecteditemData($item_id)
  {

    $value=DB::table('product')->where('product_id','=',$item_id)->first(); 
    return $value;
	
  }	
 
  
 
   /* single item */
   
   
   
   /* cart */
  
  public static function getorderCount($product_id,$session_id,$order_status)
  {

    $get=DB::table('product_order')->where('product_id','=', $product_id)->where('session_id','=', $session_id)->where('order_status','=', $order_status)->get();
	$value = $get->count(); 
    return $value;
	
  }
  
  
  public static function savecartData($savedata)
  {
   
      DB::table('product_order')->insert($savedata);
     
 
  }
  
  
  public static function updatecartData($product_id,$session_id,$order_status,$updatedata)
  {
    DB::table('product_order')
      ->where('session_id', $session_id)
	  ->where('product_id', $product_id)
	  ->where('order_status', $order_status)
      ->update($updatedata);
  }
  
  
   public static function getcartData()
  {
    $session_id = Session::getId();
    $value=DB::table('product_order')->join('product','product.product_id','product_order.product_id')->where('product_order.session_id','=',$session_id)->where('product.product_status','=',1)->where('product.product_drop_status','=','no')->where('product_order.order_status','=','pending')->orderBy('product_order.ord_id', 'desc')->get(); 
    return $value;
	
  }
  
  public static function getcartCount()
  {
    $session_id = Session::getId();
    $get=DB::table('product_order')->join('product','product.product_id','product_order.product_id')->where('product_order.session_id','=',$session_id)->where('product.product_status','=',1)->where('product.product_drop_status','=','no')->where('product_order.order_status','=','pending')->orderBy('product_order.ord_id', 'desc')->get(); 
	$value = $get->count();
    return $value;
	
  }
  
  public static function changeOrder($session_id,$updata)
   {
    DB::table('product_order')
	  ->where('session_id', $session_id)
	  ->where('order_status', 'pending')
	  ->update($updata);
   }
   
  public static function deletecartdata($ord_id){
    
	
	
	DB::table('product_order')->where('ord_id', '=', $ord_id)->where('order_status','=','pending')->delete();	
	
	
  }
  
  
  public static function clearcartdata($session_id){
    
	
	
	DB::table('product_order')->where('session_id', '=', $session_id)->where('order_status','=','pending')->delete();	
	
	
  }
  
  /* cart */
	
   
   
   
   /* search */
   
   public static function getitemcatData()
  {

    $value=DB::table('category')->where('drop_status','=','no')->where('category_status','=',1)->orderBy('display_order', 'asc')->get(); 
    return $value;
	
  }
   
   /* search */

    
   /* compatible browsers */
   public static function browserData()
  {

    $value=DB::table('product_compatible_browsers')->where('browser_drop_status','=','no')->orderBy('browser_id', 'desc')->get(); 
    return $value;
	
  }
   public static function insertbrowserData($data)
   {
   
      DB::table('product_compatible_browsers')->insert($data);
     
 
    }
	
	public static function deleteBrowserdata($browser_id,$data){
    DB::table('product_compatible_browsers')
      ->where('browser_id', $browser_id)
      ->update($data);
  }
  
  public static function editbrowserData($browser_id){
    $value = DB::table('product_compatible_browsers')
      ->where('browser_id', $browser_id)
      ->first();
	return $value;
  }
  
  public static function updatebrowserData($browser_id,$data){
    DB::table('product_compatible_browsers')
      ->where('browser_id', $browser_id)
      ->update($data);
  }
   /* compatible browsers */	
	
	

   /* package includes */
   
   public static function packData()
  {

    $value=DB::table('product_package_includes')->where('package_drop_status','=','no')->orderBy('package_id', 'desc')->get(); 
    return $value;
	
  }
   public static function insertpackData($data){
   
      DB::table('product_package_includes')->insert($data);
     
 
    }
	
	public static function deletePackdata($package_id,$data){
    DB::table('product_package_includes')
      ->where('package_id', $package_id)
      ->update($data);
  }
  
  public static function editpackData($package_id){
    $value = DB::table('product_package_includes')
      ->where('package_id', $package_id)
      ->first();
	return $value;
  }
  
   public static function updatepackData($package_id,$data){
    DB::table('product_package_includes')
      ->where('package_id', $package_id)
      ->update($data);
  }
  
   /* package includes */

    
	/* brands */
	
  
  public static function brandData()
  {

    $value=DB::table('development_logo')->orderBy('logo_id', 'desc')->get(); 
    return $value;
	
  }
  
 public static function insertbrandData($data){
   
      DB::table('development_logo')->insert($data);
     
 
    }
	
    public static function deleteBranddata($brand_id){
   
    $image = DB::table('development_logo')->where('logo_id', $brand_id)->first();
			$file= $image->logo_image;
			$filename = public_path().'/storage/brands/'.$file;
			File::delete($filename); 
    
	DB::table('development_logo')->where('logo_id', '=', $brand_id)->delete();	
	
	
  }	
  
  
  public static function deleteOrderdata($purchase_id)
  {
   
   
   DB::table('product_order')->where('purchase_token', '=', $purchase_id)->delete();	
   DB::table('product_checkout')->where('purchase_token', '=', $purchase_id)->delete();	
	
  }	
  
  
  public static function editbrandData($brand_id){
    $value = DB::table('development_logo')
      ->where('logo_id', $brand_id)
      ->first();
	return $value;
  }
	
	
	
  public static function updatebrandData($brand_id,$data){
    DB::table('development_logo')
      ->where('logo_id', $brand_id)
      ->update($data);
  }
  	
  
  public static function dropBrand($brand_id)
	  {
		 $image = DB::table('development_logo')->where('logo_id', $brand_id)->first();
			$file= $image->logo_image;
			$filename = public_path().'/storage/brands/'.$file;
			File::delete($filename);
	  }
  
  
  /* brands */
  
  
  
	/* products */
	
		
	public static function productData()
  {
    /*$sid = 1;
	$setting['setting'] = Settings::editGeneral($sid);
	$product_per_page = $setting['setting']->product_per_page;*/
    $value=DB::table('product')->where('product_drop_status','=','no')->orderBy('product_id', 'desc')->get(); 
    return $value;
	
  }
  
  public static function getcountreviewData()
  {

    
	$value=DB::table('product_ratings')->get()->groupBy('or_product_id'); 
    return $value;
	
  }	
  
  public static function searchentireProduct($search)
  {
    $sid = 1;
	$setting['setting'] = Settings::editGeneral($sid);
	$product_per_page = $setting['setting']->product_per_page;
    $value=DB::table('product')->where('product_drop_status','=','no')->where('product_name', 'LIKE', "%$search%")->orderBy('product_id', 'desc')->paginate($product_per_page); 
    return $value;
	
  }	
  
	
  public static function proddataSave($data){
   
      DB::table('product_data')->insert($data);
     
 
    }	

	
  public static function insertproductData($data){
   
      DB::table('product')->insert($data);
     
 
    }	
	
	public static function saveproductImages($imgdata)
  {
   
      DB::table('product_images')->insert($imgdata);
     
 
  }
  
  
   public static function deleteProductdata($product_token,$data)
   {
            $settings = DB::table('settings')->where('sid', 1)->first();
            $image = DB::table('product')->where('product_token', $product_token)->first();
			$file= $image->product_image;
			$filename = public_path().'/storage/product/'.$file;
			File::delete($filename); 
			
			
			
	        if($settings->site_s3_storage == 1)
			{
			
			   /* wasabi */
			$wasabi_access_key_id = $settings->wasabi_access_key_id;
			$wasabi_secret_access_key = $settings->wasabi_secret_access_key;
			$wasabi_default_region = $settings->wasabi_default_region;
			$wasabi_bucket = $settings->wasabi_bucket;
			$wasabi_endpoint = 'https://s3.'.$wasabi_default_region.'.wasabisys.com';
			$raw_credentials = array(
											'credentials' => [
												'key' => $wasabi_access_key_id,
												'secret' => $wasabi_secret_access_key
											],
											'endpoint' => $wasabi_endpoint, 
											'region' => $wasabi_default_region, 
											'version' => 'latest',
											'use_path_style_endpoint' => true
										);
			$s3 = S3Client::factory($raw_credentials);
			/* wasabi */
			
			   //Storage::disk('wasabi')->delete($image->product_file);
			   $s3->deleteObject(['Bucket' => $wasabi_bucket, 'Key' => $image->product_file]);
	  		   $drop = public_path().'/storage/product/'.$image->product_file;  // my server
               File::delete($drop);
			}
			else if($settings->site_s3_storage == 2)
			{
			   Storage::disk('dropbox')->delete($image->product_file);
			}
			else if($settings->site_s3_storage == 3)
			{
			   Storage::disk('google')->delete($image->product_file);
			}
			else if($settings->site_s3_storage == 4)
			{
			    $exists = Storage::disk('s3')->has($image->product_file);
				if($exists)
				{
				  Storage::disk('s3')->delete($image->product_file); // s3
				  
				}
				
			
			}
			else
			{
			   $file_new= $image->product_file;
			   $filename_new = public_path().'/storage/product/'.$file_new;
			   File::delete($filename_new);
			} 
			
			$image_two = DB::table('product_images')->where('product_token', '=', $product_token)->get();
			foreach($image_two as $gallery)
			{
            $file_gallery = $gallery->product_gallery_image;
            $filename_gallery = public_path().'/storage/product/'.$file_gallery;
            File::delete($filename_gallery);
			DB::table('product_images')->where('prod_gal_id', '=', $gallery->prod_gal_id)->delete();
			}
		        
			DB::table('product')->where('product_token', $product_token)->update($data);	
	
	
  }	
  
  
  public static function editproductData($product_token){
    $value = DB::table('product')
	  
      ->where('product_token', $product_token)
      ->first();
	return $value;
  }
  
  public static function getimagesData($product_token)
  {

    $value=DB::table('product_images')->where('product_token','=', $product_token)->orderBy('prod_gal_id', 'desc')->get(); 
    return $value;
	
  }
  
  public static function deleteimgdata($token){
    
	$image = DB::table('product_images')->where('prod_gal_id', '=', $token)->first();
    $file= $image->product_gallery_image;
    $filename = public_path().'/storage/product/'.$file;
    File::delete($filename);
	
	DB::table('product_images')->where('prod_gal_id', '=', $token)->delete();	
	
	
  }
  
  public static function updateproductData($product_token,$data){
    DB::table('product')
      ->where('product_token', $product_token)
      ->update($data);
  }
	/* products */
	
	
	
	 /* checkout */
  
  public static function getcheckoutCount($purchase_token,$user_id,$payment_status)
  {

    $get=DB::table('product_checkout')->where('purchase_token','=', $purchase_token)->where('user_id','=', $user_id)->where('payment_status','=', $payment_status)->get();
	$value = $get->count(); 
    return $value;
	
  }
  
  
  public static function savecheckoutData($savedata)
  {
   
      DB::table('product_checkout')->insert($savedata);
     
 
  }
  
  public static function updateitemData($item_token,$data)
  {
    DB::table('product')
      ->where('product_token', $item_token)
      ->update($data);
  }
  
  
  public static function updatecheckoutData($purchase_token,$user_id,$payment_status,$updatedata)
  {
    DB::table('product_checkout')
      ->where('purchase_token', $purchase_token)
	  ->where('user_id', $user_id)
	  ->where('payment_status', $payment_status)
      ->update($updatedata);
  }
  
  
  public static function singleorderupData($order,$orderdata)
  {
    DB::table('product_order')
      ->where('ord_id', $order)
	  ->update($orderdata);
  }
  
  
  public static function singleorderData($order)
  {
    $value = DB::table('product_order')
      ->where('ord_id', $order)
      ->first();
	return $value;
  }
  
  
   public static function singleordupdateData($purchased_token,$orderdata)
  {
    DB::table('product_order')
      ->where('purchase_token', $purchased_token)
	  ->update($orderdata);
  }
  
  
  public static function singlecheckoutData($purchased_token,$checkoutdata)
  {
    DB::table('product_checkout')
      ->where('purchase_token', $purchased_token)
	  ->update($checkoutdata);
  }
  
  
  
  
  public static function solditemData($token)
  {

    $value=DB::table('product')->where('product_token','=',$token)->first(); 
    return $value;
	
  }
  
  
  public static function getcheckoutData($token)
  {

    $value=DB::table('product_checkout')->where('purchase_token','=',$token)->first(); 
    return $value;
	
  }
  
  
  public static function getorderData($order)
  {

    $value=DB::table('product_order')->where('ord_id','=',$order)->first(); 
    return $value;
	
  }
  /* checkout */	
	
  
  /* purchases */
  
  public static function getuserOrders()
  {
    $user_id = Auth::user()->id;
    $value=DB::table('product')->join('users','users.id','product.user_id')->join('product_order','product.product_id','product_order.product_id')->leftjoin('product_ratings', 'product_ratings.order_id', '=', 'product_order.ord_id')->where('product_order.user_id','=',$user_id)->where('product_order.order_status','=','completed')->orderBy('product_order.ord_id', 'desc')->get(); 
    return $value;
	
  }
  
  
  public static function checkRating($product_token,$user_id)
  {

    $get=DB::table('product_ratings')->where('or_product_token','=', $product_token)->where('or_user_id','=', $user_id)->get();
	$value = $get->count(); 
    return $value;
	
  }
  
  
  public static function saveRating($savedata)
  {
   
      DB::table('product_ratings')->insert($savedata);
     
 
  }
  
  
  public static function updateRating($product_token,$user_id,$updata)
  {
    DB::table('product_ratings')
      ->where('or_product_token', $product_token)
	  ->where('or_user_id', $user_id)
      ->update($updata);
  }
  
  /* purchases */
  
  /* refund */
  
  public static function checkRefund($product_token,$user_id)
  {

    $get=DB::table('product_refund')->where('ref_product_token','=', $product_token)->where('ref_user_id','=', $user_id)->where('ref_refund_approval','=', 'accepted')->get();
	$value = $get->count(); 
    return $value;
	
  }
  
  public static function saveRefund($savedata)
  {
   
      DB::table('product_refund')->insert($savedata);
     
 
  }
  
  
  
  /* refund */
  
  
  
  /* withdrawal */
  
  public static function savedrawalData($data)
  {
   
      DB::table('product_withdrawal')->insert($data);
     
 
  }
  
  
  public static function getdrawalData()
  {
    $user_id = Auth::user()->id;
    $value=DB::table('product_withdrawal')->where('wd_user_id','=',$user_id)->orderBy('wd_id', 'desc')->get(); 
    return $value;
	
  }
  
  
  public static function getdrawalView()
  {
    $user_id = Auth::user()->id;
    $value=DB::table('product_withdrawal')->where('wd_user_id','=',$user_id)->where('wd_status','=','paid')->orderBy('wd_id', 'desc')->get(); 
    return $value;
	
  }
  
  /* withdrawal */
  
  
  /* admin orders */
  
  public static function getorderItem()
  {
    $sid = 1;
	$setting['setting'] = Settings::editGeneral($sid);
	$product_per_page = $setting['setting']->product_per_page;
    $value=DB::table('product_checkout')->join('users','users.id','product_checkout.user_id')->orderBy('product_checkout.chout_id', 'desc')->paginate($product_per_page); 
    return $value;
	
  }	
  
  public static function searchentireOrder($search)
  {
    $sid = 1;
	$setting['setting'] = Settings::editGeneral($sid);
	$product_per_page = $setting['setting']->product_per_page;
    $value=DB::table('product_checkout')
	       ->join('users','users.id','product_checkout.user_id')
		   ->where(function ($query) use ($search) { 
		   $query->where('product_checkout.purchase_token', 'LIKE', "%$search%");
		   $query->orWhere('users.username', 'LIKE', "%$search%");
		   })->orderBy('product_checkout.chout_id', 'desc')
		   ->paginate($product_per_page); 
    return $value;
	
  }	
  
  
   public static function adminorderItem($token)
  {
    
    $value=DB::table('product_order')->join('users','users.id','product_order.product_user_id')->where('product_order.purchase_token','=',$token)->where('product_order.order_status','=','completed')->orderBy('product_order.ord_id', 'desc')->get(); 
    return $value;
	
  }	
  
  
  public static function getsingleOrder($token)
  {
    
    $value=DB::table('product_checkout')->join('users','users.id','product_checkout.user_id')->where('product_checkout.purchase_token','=',$token)->where('product_checkout.payment_status','=','completed')->orderBy('product_checkout.chout_id', 'desc')->first(); 
    return $value;
	
  }
  
  /* admin orders */
  
  
  /* admin refund */
  
   public static function getrefundItem()
  {
    
    $value=DB::table('product_refund')->join('users','users.id','product_refund.ref_user_id')->join('product','product.product_id','product_refund.ref_product_id')->orderBy('product_refund.refund_id', 'desc')->get(); 
    return $value;
	
  }
  
  
  public static function refundupData($refund_id,$refundata)
  {
    DB::table('product_refund')
      ->where('refund_id', $refund_id)
	  ->update($refundata);
  }
  
  
  public static function deleteRating($ord_id){
    
	
	
	DB::table('product_ratings')->where('order_id', '=', $ord_id)->delete();	
	
	
  }
  /* admin refund */
  
  
  /* reports */
  
  public static function getreports()
  {
    
    $value=DB::table('product_report')->join('product','product.product_token','product_report.report_product_token')->orderBy('product_report.report_id', 'desc')->get(); 
    return $value;
	
  }
  
   public static function checkReport($report_email,$report_product_token)
  {

    $get=DB::table('product_report')->where('report_email','=',$report_email)->where('report_product_token','=',$report_product_token)->get();
	$value = $get->count(); 
	return $value;
	
  }	
  
  
  public static function dropReport($report_id){
    
	
	
	DB::table('product_report')->where('report_id', '=', $report_id)->delete();	
	
	
  }
  /* reports */
  
  
  /* rating */
  
  public static function saveRatings($data)
  {
   
      DB::table('product_ratings')->insert($data);
     
 
  }
  
  public static function updateratingData($rating_id,$updata){
    DB::table('product_ratings')
      ->where('rating_id', $rating_id)
      ->update($updata);
  }
  
  public static function getratingSingle($product_token)
  {
    
    $value=DB::table('product_ratings')->where('product_ratings.or_product_token', '=', $product_token)->get(); 
    return $value;
	
  }
  
  
  public static function getratingItem()
  {
    
    $value=DB::table('product_ratings')->join('users','users.id','product_ratings.or_user_id')->join('product','product.product_id','product_ratings.or_product_id')->orderBy('product_ratings.rating_id', 'desc')->get(); 
    return $value;
	
  }
  
  
  public static function singleratingItem($rating_id)
  {
    
    $value=DB::table('product_ratings')->where('rating_id', '=', $rating_id)->first(); 
    return $value;
	
  }
  
  public static function dropRating($rating_id){
    
	
	
	DB::table('product_ratings')->where('rating_id', '=', $rating_id)->delete();	
	
	
  }
  
  /* rating */
  
  
  
   /* admin withdrawal */
  
  public static function getwithdrawalData()
  {
    
    $value=DB::table('product_withdrawal')->join('users','users.id','product_withdrawal.wd_user_id')->orderBy('product_withdrawal.wd_id', 'desc')->get(); 
    return $value;
	
  }
  
  
  public static function updatedrawalData($wd_id,$user_id,$drawal_data)
  {
    DB::table('product_withdrawal')
      ->where('wd_id', $wd_id)
	  ->where('wd_user_id',$user_id)
      ->update($drawal_data);
  }
  
  public static function singledrawalData($wd_id)
  {
    $value = DB::table('product_withdrawal')
      ->where('wd_id', $wd_id)
      ->first();
	return $value;
  }
  
  /* admin withdrawal */
  
  public static function totalProduct()
  {

    $get=DB::table('product')->where('product_drop_status','=','no')->get();
	$value = $get->count(); 
	return $value;
	
  }	
  
  
  public static function totalOrder()
  {

    $get=DB::table('product_order')->where('order_status','=','completed')->get();
	$value = $get->count(); 
	return $value;
	
  }	
  
  
  public static function totalRefund()
  {

    $get=DB::table('product_refund')->where('ref_refund_approval','=','')->get();
	$value = $get->count(); 
	return $value;
	
  }	
  
  
  public static function totalWithdrawal()
  {

    $get=DB::table('product_withdrawal')->where('wd_status','=','pending')->get();
	$value = $get->count(); 
	return $value;
	
  }	
  
  public static function totalSubscription()
  {

    $get=DB::table('subscription')->where('subscr_drop_status','=','no')->get();
	$value = $get->count(); 
	return $value;
	
  }	
  
  
  public static function totalSubadmin()
  {

    $get=DB::table('users')->where('user_type','=','admin')->where('id','!=',1)->get();
	$value = $get->count(); 
	return $value;
	
  }	
  
   public static function totalCoupon()
  {

    $get=DB::table('coupon')->get();
	$value = $get->count(); 
	return $value;
	
  }	
  
  
  public static function orderdataCheck($check_date)
  {
    
    $get=DB::table('product_checkout')->where('payment_status','=','completed')->where('payment_date','=',$check_date)->get(); 
	$value = $get->count();
    return $value;
	
  }	
  
  public static function saveAttribute($data)
  {
   
      DB::table('product_attributes')->insert($data);
     
 
  }
  
  public static function dropAttribute($product_token){
    
		
	DB::table('product_attributes')->where('product_token', '=', $product_token)->delete();	
	
	
  }
  
  /* coupon */
	
	public static function singleCoupon($coupon,$coupon_usage_type)
   {
    
    $value=DB::table('coupon')->where('coupon_code','=',$coupon)->where('coupon_status','=',1)->where('coupon_type','=',$coupon_usage_type)->first(); 
    return $value;
	
   }
	
	
	public static function checkCoupon($coupon,$coupon_usage_type)
   {
    $today_date = date('Y-m-d h:i a');
    $get=DB::table('coupon')->where('coupon_start_date','<=',$today_date)->where('coupon_end_date','>=',$today_date)->where('coupon_code','=',$coupon)->where('coupon_status','=',1)->where('coupon_type','=',$coupon_usage_type)->get(); 
    $value = $get->count(); 
    return $value;
	
   }
   
   public static function getCoupon($coupon,$coupon_usage_type,$session_id)
  {
    
    $value=DB::table('coupon')->join('product_order','product_order.product_user_id','coupon.user_id')->where('coupon.coupon_code','=',$coupon)->where('coupon.coupon_status','=',1)->where('coupon.coupon_type','=',$coupon_usage_type)->where('product_order.order_status','=','pending')->where('product_order.session_id','=',$session_id)->get();
    return $value;
	
  }
  
  
  
  public static function updateCoupon($order_id,$data)
  {
    DB::table('product_order')
      ->where('ord_id', $order_id)
      ->update($data);
  }
  
  public static function removeCoupon($coupon,$session_id,$data)
  {
    DB::table('product_order')
      ->where('coupon_code', $coupon)
	  ->where('session_id', $session_id)
	  ->where('order_status', 'pending')
      ->update($data);
  }
  /* coupon */
  
  
  /* tickets */
  public static function allticketData()
  {
    
    $value=DB::table('tickets')->orderBy('ticket_id', 'desc')->get(); 
    return $value;
	
  }
  
  public static function getticketData()
  {
    $user_token = Auth::user()->user_token;
    $value=DB::table('tickets')->where('ticket_user_token','=',$user_token)->orderBy('ticket_id', 'desc')->get(); 
    return $value;
	
  }
  
  public static function saveticket($data)
  {
   
      DB::table('tickets')->insert($data);
     
 
  }
  public static function singleticketData($ticket)
  {
    
    $value=DB::table('tickets')->where('ticket_token','=',$ticket)->first(); 
    return $value;
	
  }
  
  public static function updateTicket($token,$data)
  {
    DB::table('tickets')
      ->where('ticket_token', $token)
      ->update($data);
  }
  
  public static function savereplyticket($data)
  {
   
      DB::table('tickets_reply')->insert($data);
     
 
  }
  
  public static function getreplyticketData($tickets_token)
  {
    $user_token = Auth::user()->user_token;
    $value=DB::table('tickets_reply')->where('tickets_user_token','=',$user_token)->where('tickets_token','=',$tickets_token)->orderBy('tr_id', 'desc')->get(); 
    return $value;
	
  }
  
  public static function getreplyticketAdmin($tickets_token)
  {
    
    $value=DB::table('tickets_reply')->where('tickets_token','=',$tickets_token)->orderBy('tr_id', 'desc')->get(); 
    return $value;
	
  }
  
  public static function deleteTicket($token)
	{
    
	
	DB::table('tickets')->where('ticket_token', '=', $token)->delete();
	DB::table('tickets_reply')->where('tickets_token', '=', $token)->delete();		
	
	}
	
    public static function totalTickets()
   {

    $get=DB::table('tickets')->get();
	$value = $get->count(); 
	return $value;
	
   }		
  /* tickets */
  
  public static function getAllWithMethod()
  {
    
    $value=DB::table('withdrawal_methods')->where('withdrawal_status','=',1)->orderBy('withdrawal_order', 'asc')->get(); 
    return $value;
	
  }
  
  
  public static function editWithMethod($wm_id)
  {
    $value = DB::table('withdrawal_methods')
      ->where('wm_id', $wm_id)
      ->first();
	return $value;
  }
  
  
   public static function getWithMethod()
  {
    
    $value=DB::table('withdrawal_methods')->orderBy('withdrawal_order', 'asc')->get(); 
    return $value;
	
  }
  
  
   public static function updateWithMethod($wm_id, $data){
    DB::table('withdrawal_methods')
      ->where('wm_id', $wm_id)
      ->update($data);
  }
  
  
  public static function saveWithMethod($data)
  {
   
      DB::table('withdrawal_methods')->insert($data);
     
 
  }	

  public function accountInventories()
{
    return $this->hasMany(AccountInventory::class);
}

  
  
}
