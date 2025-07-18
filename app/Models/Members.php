<?php

namespace DownGrade\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Members extends Model
{
    
	
	
	public static function countryCheck($country_id)
  {

    $get=DB::table('country')->where('country_id', $country_id)->get(); 
    $value = $get->count(); 
    return $value;
	
  }
  
  public static function countryDATA($country_id)
  {

    $value=DB::table('country')->where('country_id', $country_id)->first(); 
    return $value;
	
  }
	
	public static function checkCoupon($coupon,$coupon_usage_type)
   {
    $today_date = date('Y-m-d h:i a');
    $get=DB::table('coupon')->where('coupon_start_date','<=',$today_date)->where('coupon_end_date','>=',$today_date)->where('coupon_code','=',$coupon)->where('coupon_status','=',1)->where('coupon_type','=',$coupon_usage_type)->get(); 
    $value = $get->count(); 
    return $value;
	
   }
   
   public static function getSubCoupon($coupon,$coupon_usage_type)
  {
    
    $value=DB::table('coupon')->where('coupon_code','=',$coupon)->where('coupon_status','=',1)->where('coupon_type','=',$coupon_usage_type)->get();
    return $value;
	
  }
  
  public static function singleCoupon($coupon,$coupon_usage_type)
   {
    
    $value=DB::table('coupon')->where('coupon_code','=',$coupon)->where('coupon_status','=',1)->where('coupon_type','=',$coupon_usage_type)->first(); 
    return $value;
	
   }
	
	/* administrator */
		public static function getadminData()
	  {
	
		$value=DB::table('users')->where('user_type','=','admin')->where('id','!=',1)->where('drop_status','=','no')->orderBy('id', 'desc')->get(); 
		return $value;
		
	  }
	  
	  public static function logindataUser($log_id)
	  {
            $value = DB::table('users')->where('id', $log_id)->first();
	        return $value;
      }
	  
	/* administrator */
	
	/* customer */
	
	public static function insertData($data){
   
      DB::table('users')->insert($data);
     
 
    }
	
	
	public static function savenewsletterData($data)
  {
   
      DB::table('newsletter')->insert($data);
     
 
  }
	
	

  public static function updateData($token,$data){
    DB::table('users')
      ->where('user_token', $token)
      ->update($data);
  }
  
  public static function editData($token){
    $value = DB::table('users')
      ->where('user_token', $token)
      ->first();
	return $value;
  }
  
  
  public static function getuserData()
  {

    $value=DB::table('users')->where('user_type','=','customer')->where('drop_status','=','no')->orderBy('id', 'desc')->get(); 
    return $value;
	
  }
  
     
  
 
  
  public static function checkNewsletter($token)
  {
  $get=DB::table('newsletter')->where('news_token','=',$token)->where('news_status','=',0)->get();
  $value = $get->count();  
    return $value;
  
  }
  
  
  
  public static function getuserSubscription($user_id)
  {
  $today = date('Y-m-d');
  $get=DB::table('users')->leftJoin('subscription','subscription.subscr_id','users.user_subscr_id')->where('subscription.subscr_status','=',1)->where('subscription.subscr_drop_status','=','no')->where('users.id','=',$user_id)->where('users.user_subscr_date','>',$today)->where('subscription.subscr_email_support','=',1)->get();
  $value = $get->count(); 
  return $value;
  
  }
  
  
  public static function deleteVolunteers($token){
   
    $image = DB::table('volunteers')->where('volu_token', $token)->first();
			$file= $image->volu_photo;
			$filename = public_path().'/storage/volunteers/'.$file;
			File::delete($filename); 
    
	DB::table('volunteers')->where('volu_token', '=', $token)->delete();	
	
	
  }	
  
  
    
  
  
  public static function deleteData($token,$data){
    
	$image = DB::table('users')->where('user_token', $token)->first();
        $file= $image->user_photo;
        $filename = public_path().'/storage/users/'.$file;
        File::delete($filename);
	
	DB::table('users')
      ->where('user_token', $token)
      ->update($data);
	
  }
  
  public static function droPhoto($token)
  {
     $image = DB::table('users')->where('user_token', $token)->first();
        $file= $image->user_photo;
        $filename = public_path().'/storage/users/'.$file;
        File::delete($filename);
  }
  
  
  public static function droBanner($token)
  {
     $image = DB::table('users')->where('user_token', $token)->first();
        $file= $image->user_banner;
        $filename = public_path().'/storage/users/'.$file;
        File::delete($filename);
  }
  
  /* customer */
  
  
 
	
	
	
	/* edit profile */
	
	
  
  
  public static function editprofileData($token){
    $value = DB::table('users')
      ->where('id', $token)
      ->first();
	return $value;
  }
  
  
  public static function editUser($slug){
    $value = DB::table('users')
      ->where('username', $slug)
      ->first();
	return $value;
  }
  
  
  
  public static function adminData(){
    $value = DB::table('users')
      ->where('id', 1)
      ->first();
	return $value;
  }
  
  
  public static function updateprofileData($token,$data){
    DB::table('users')
      ->where('id', $token)
      ->update($data);
  }
  
  
  public static function updateNewsletter($token,$data){
    DB::table('newsletter')
      ->where('news_token', $token)
      ->update($data);
  }
  
  
  public static function droprofilePhoto($token)
  {
     $image = DB::table('users')->where('id', $token)->first();
        $file= $image->user_photo;
        $filename = public_path().'/storage/users/'.$file;
        File::delete($filename);
  }
	
	/* edit profile */
	
	
	/* verify user */
	
	public static function verifyuserData($user_token,$data){
    DB::table('users')
      ->where('user_token', $user_token)
      ->update($data);
  }
  
  public static function refCount($token){
    $get = DB::table('users')
      ->where('user_token', $token)
	  ->where('drop_status', 'no')
	  ->where('referral_by', '!=', 0)
	  ->where('referral_payout', 'pending')
      ->get();
	$value = $get->count(); 
    return $value;
  }
  
  /* verify user */
  
  
  /* verify user available or not */
  
  
  public static function verifycheckData($data){
    $value=DB::table('users')->where('email', $data['email'])->where('drop_status', 'no')->get();
    if($value->count() != 0){
      return 1;
     }else{
       return 0;
     }
	
  }
  
  
  public static function getemailData($email){
    $value = DB::table('users')
      ->where('email', $email)
	  ->where('drop_status', 'no')
      ->first();
	return $value;
  }
  
  
  
  public static function verifytokenData($data){
    $value=DB::table('users')->where('user_token', $data['user_token'])->where('drop_status', 'no')->get();
    if($value->count() != 0){
      return 1;
     }else{
       return 0;
     }
	
  }
  
  public static function getJoinData($user_token){
    $value = DB::table('users')->join('subscription', 'subscription.subscr_id', '=', 'users.user_subscr_id')->where('users.user_token', $user_token)->first();
	return $value;
  }
  
  
  public static function gettokenData($user_token){
    $value = DB::table('users')->where('user_token', $user_token)->where('drop_status', 'no')->first();
	return $value;
  }
  
  
   public static function updatepasswordData($user_token, $record){
    DB::table('users')
      ->where('user_token', $user_token)
      ->update($record);
  }
  
  
  public static function updateadminData($admin_token, $admin_record){
    DB::table('users')
      ->where('user_token', $admin_token)
      ->update($admin_record);
  }
  
  
  
  public static function updateuserPrice($user_id, $user_data){
    DB::table('users')
      ->where('id', $user_id)
      ->update($user_data);
  }
  
  
  
  /* verify user available or not */
  
  
  /* single user get */
  
  public static function chData($item_user_id)
  {

    $get=DB::table('users')->where('id', $item_user_id)->get();
	$value = $get->count(); 
    return $value;
	
  }
  
  public static function singlevendorData($item_user_id){
    $value = DB::table('users')
      ->where('id', $item_user_id)
      ->first();
	return $value;
  }
  
  
  public static function singlebuyerData($user_id){
    $value = DB::table('users')
      ->where('id', $user_id)
      ->first();
	return $value;
  }
  
  
  
  public static function updatevendorRecord($vendor_token, $record_vendor){
    DB::table('users')
      ->where('user_token', $vendor_token)
      ->update($record_vendor);
  }
  
  
  public static function updateSubCoupon($user_id,$data)
  {
    DB::table('users')
      ->where('id', $user_id)
      ->update($data);
  }
  
  /* single user get */
  
  
  /* total members */
  
  public static function getmemberData()
  {

    $get=DB::table('users')->where('user_type','=','vendor')->where('drop_status','=','no')->orderBy('id', 'desc')->get();
	$value = $get->count(); 
    return $value;
	
  }
  
  public static function totaluserCount()
  {

    $get=DB::table('users')->where('user_type','=','customer')->where('drop_status','=','no')->orderBy('id', 'desc')->get();
	$value = $get->count();  
    return $value;
	
  }
  
  
    
 
  
  /* total members */
	
	
	 public static function getcontactCount($from_email)
  {
    
    $get=DB::table('contact')->where('from_email','=',$from_email)->get(); 
	$value = $get->count();
    return $value;
	
  }	
  
  public static function saveContact($record)
  {
   
      DB::table('contact')->insert($record);
     
 
  }
  
  public static function GetLifetime($user_id)
  {
     $get = DB::table('users')->join('subscription', 'subscription.subscr_id', '=', 'users.user_subscr_id')->where('users.id', $user_id)->where('subscription.subscr_duration','=','1000 Year')->get();
	$value = $get->count(); 
	return $value;
  }
  
  public static function SubscribedUser()
  {

    $value=DB::table('users')->select('users.user_subscr_date','users.id','users.email','users.user_subscr_type','users.name')->where('users.user_type','=','customer')->where('users.user_subscr_type','!=','')->where('users.drop_status','=','no')->orderBy('users.id', 'desc')->get(); 
    return $value;
	
  }
  
  /* referral */
   public static function referralUser($referral_by)
  {

    $value=DB::table('users')->where('id', $referral_by)->first(); 
    return $value;
	
  }
  
  public static function referralCheck($referral_by)
  {

    $get=DB::table('users')->where('id', $referral_by)->get(); 
    $value = $get->count(); 
    return $value;
	
  }
  
  
  
  public static function updateReferral($referral_by,$update_data){
    DB::table('users')
      ->where('id', $referral_by)
      ->update($update_data);
  }
  
  /* referral */
  
  public static function checkdownloadDate($user_id,$today_date)
  {

    $value=DB::table('users')->where('id', $user_id)->where('user_today_download_date', $today_date)->first(); 
    return $value;
	
  }
  
}
