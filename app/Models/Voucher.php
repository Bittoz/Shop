<?php

namespace DownGrade\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;


class Voucher extends Model
{
    
	protected $table = 'voucher';
	
  public static function getVoucherData()
  {

    $value=DB::table('voucher')->orderBy('vid', 'desc')->get(); 
    return $value;
	
  }	
	
	
  public static function insertvoucherData($data){
   
      DB::table('voucher')->insert($data);
     
 
    }
	
	public static function existsVoucher($code)
   {
            $get = DB::table('voucher')->where('voucher_code', '=', $code)->get();
			$value = $get->count();
	        return $value;
   }	
	
	public static function singleVoucher($vid)
	{
    $value = DB::table('voucher')
       ->where('vid', $vid)
      ->first();
	return $value;
  }
  
  public static function deleteVoucher($vid){
    
	DB::table('voucher')->where('voucher_token', '=', $vid)->delete();	
	
	
  }
  
  
  public static function viewUser($user_id)
  {
            $value = DB::table('users')->where('id', $user_id)->first();
	        return $value;
  }
  public static function viewUserCount($user_id)
  {
            $get = DB::table('users')->where('id', $user_id)->get();
			$value = $get->count();
	        return $value;
  }
  
  
   public static function getUnSoldVoucher()
  {
    $today = date('Y-m-d h:i:s');
    $value=DB::table('voucher')->where('voucher_redeem_user_id','=',0)->where('voucher_expiry_date','>',$today)->orderBy('vid', 'desc')->get(); 
    return $value;
	
  }	
  
  public static function singleUnSoldVoucher($token)
  {
    $today = date('Y-m-d h:i:s');
    $value=DB::table('voucher')->where('voucher_redeem_user_id','=',0)->where('voucher_expiry_date','>',$today)->where('voucher_token','=',$token)->first();
    return $value;
	
  }	
  
  public static function saveData($savedata)
  {
   
      DB::table('voucher_purchase')->insert($savedata);
     
 
  }
  
  public static function updateData($voucher_token,$updatedata)
  {
    DB::table('voucher')
      ->where('voucher_token', $voucher_token)
	  ->update($updatedata);
  }
  
    
  public static function singleordupdateData($purchase_token,$orderdata)
  {
    DB::table('voucher_purchase')
      ->where('purchase_token', $purchase_token)
	  ->update($orderdata);
  }
  
  
  
  public static function singlePurchase($purchase_token)
  {
    
    $value=DB::table('voucher_purchase')->where('purchase_token','=', $purchase_token)->first();
    return $value;
	
  }
  
  public static function againPurchase($purchase_token)
  {
    
    $value=DB::table('voucher')->where('purchase_token','=', $purchase_token)->first();
    return $value;
	
  }
  
	
  public static function singlecheckoutData($purchase_token,$voucher_token,$checkoutdata)
  {
    DB::table('voucher')
      ->where('purchase_token', $purchase_token)
	  ->where('voucher_token', $voucher_token)
	  ->update($checkoutdata);
  }	
  
  
  public static function getPurchasesData()
  {

    $value=DB::table('voucher_purchase')->join('voucher','voucher.purchase_token','voucher_purchase.purchase_token')->join('users','users.id','voucher_purchase.voucher_redeem_user_id')->orderBy('vid', 'desc')->get(); 
    return $value;
	
  }
	
	
  public static function deleteEntire($order_id){
    
		
	DB::table('voucher_purchase')->where('purchase_token', '=', $order_id)->delete();	
	
	
  } 
  
  public static function checkVoucher($voucher_code)
  {
            $today = date('Y-m-d h:i:s');
            $get = DB::table('voucher')->where('voucher_expiry_date','>',$today)->where('voucher_status','=','Unused')->where('voucher_code','=',$voucher_code)->get();
			$value = $get->count();
	        return $value;
  }	
  public static function getVoucher($voucher_code)
  {
            $today = date('Y-m-d h:i:s');
            $value = DB::table('voucher')->where('voucher_expiry_date','>',$today)->where('voucher_status','=','Unused')->where('voucher_code','=',$voucher_code)->first();
			return $value;
  }	
  
  public static function VoucherData()
  {

    $value=DB::table('voucher')->orderBy('vid', 'desc')->get(); 
    return $value;
	
  }	
  
  
  /* edited */	
	
	
  
  
 
	
	
  
  
  
  
}
