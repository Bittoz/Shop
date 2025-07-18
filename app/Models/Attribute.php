<?php

namespace DownGrade\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Attribute extends Model
{
    
	/* attribute */
	
	
	public static function getattributeViews($token)
   {
   
     $value=DB::table('product_attributes')->where('product_token','=',$token)->orderBy('product_attribute_label', 'asc')->get(); 
     return $value;
   
   }
	
   
   public static function SingleAttributes($product_token,$attribute_id)
  {

    $value=DB::table('product_attributes')->where('product_token', '=', $product_token)->where('attribute_id', '=', $attribute_id)->get(); 
    return $value;
	
  }		
	
	
   public static function getattributeData()
  {

    $value=DB::table('attributes')->where('attr_drop_status','=','no')->orderBy('attr_id', 'desc')->get(); 
    return $value;
	
  }	
  
  
  public static function allAttribute(){
    $value = DB::table('attributes')
      ->where('attr_field_status', 1)
	  ->where('attr_drop_status', 'no')
	  ->orderBy('attr_field_order', 'asc')
      ->get();
	return $value;
  }
  
  public static function selectedAttribute(){
    $value = DB::table('attributes')
      ->where('attr_field_status', 1)
	  ->where('attr_drop_status', 'no')
	  ->orderBy('attr_field_order', 'asc')
      ->get();
	return $value;
  }
  
  public static function againAttribute($token){
    $value = DB::table('attributes')
	  ->join('product_attributes','product_attributes.attribute_id','attributes.attr_id')
	  ->where('product_attributes.product_token', $token)
      ->where('attributes.attr_field_status', 1)
	  ->where('attributes.attr_drop_status', 'no')
	  ->orderBy('attributes.attr_field_order', 'asc')
      ->get();
	return $value;
  }
  
  
  public static function insertattributeData($data){
   
      DB::table('attributes')->insert($data);
     
 
    }
	
	
	public static function deleteAttributedata($attr_id,$data){
    
		
	DB::table('attributes')
      ->where('attr_id', $attr_id)
      ->update($data);
	
  }
  
  
  public static function editattributeData($attr_id){
    $value = DB::table('attributes')
      ->where('attr_id', $attr_id)
      ->first();
	return $value;
  }
	
	
  
  
  
  public static function updateattributeData($attr_id, $data){
    DB::table('attributes')
      ->where('attr_id', $attr_id)
      ->update($data);
  }
  
  
  
  
  /* category */
  
  
  
  
  
  
  
  
}
