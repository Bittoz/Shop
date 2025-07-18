<?php

namespace DownGrade\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Pages extends Model
{
    
	/* pages */
	
	
	
  public static function getcontactData()
  {

    $value=DB::table('contact')->orderBy('cid', 'desc')->get(); 
    return $value;
	
  }	
  
  
   public static function getpageViews()
  {

    $value=DB::table('pages')->where('page_status','=','1')->orderBy('page_id', 'desc')->get(); 
    return $value;
	
  }	
  
  public static function getnewsletterData()
  {

    $value=DB::table('newsletter')->orderBy('news_id', 'desc')->get(); 
    return $value;
	
  }	
  
  
  public static function getactiveNewsletter()
  {

    $value=DB::table('newsletter')->where('news_status','=',1)->orderBy('news_id', 'desc')->get(); 
    return $value;
	
  }	
  
  
	
  public static function getfeatureData()
  {

    $value=DB::table('features')->orderBy('feature_id', 'asc')->get(); 
    return $value;
	
  }	
	
	
  public static function menupageData()
  {

    $value=DB::table('pages')->where('page_status','=','1')->where('main_menu','=','1')->orderBy('menu_order', 'asc')->get(); 
    return $value;
	
  }	
  
  public static function mainmenuPageCount()
  {

    $get=DB::table('pages')->where('page_status','=','1')->where('main_menu','=','1')->orderBy('menu_order', 'asc')->get(); 
    $value = $get->count(); 
    return $value;
	
  }
  
  
  public static function getpageData()
  {

    $value=DB::table('pages')->orderBy('page_id', 'desc')->get(); 
    return $value;
	
  }
  
  
  public static function pagelinkData()
  {

    $value=DB::table('pages')->where('page_status','=','1')->orderBy('menu_order', 'asc')->get(); 
    return $value;
	
  }
    
  public static function footermenuData()
  {

    $value=DB::table('pages')->where('page_status','=','1')->where('footer_menu','=','1')->orderBy('menu_order', 'asc')->get(); 
    return $value;
	
  }
  
  
  public static function insertpageData($data){
   
      DB::table('pages')->insert($data);
     
 
    }
  
  public static function deletePagedata($page_id){
    
	DB::table('pages')->where('page_id', '=', $page_id)->delete();	
	
	
  }
  
  
  public static function deleteContact($id){
    
	DB::table('contact')->where('cid', '=', $id)->delete();	
	
	
  }
  
  
  public static function deleteNewsletter($id){
    
	DB::table('newsletter')->where('news_id', '=', $id)->delete();	
	
	
  }
  
  
  public static function updatefeatureData($feature_id,$data){
    DB::table('features')
      ->where('feature_id', $feature_id)
      ->update($data);
  }
  
  public static function dropFeatures($feature_id)
	  {
		 $image = DB::table('features')->where('feature_id', $feature_id)->first();
			$file= $image->feature_image;
			$filename = public_path().'/storage/features/'.$file;
			File::delete($filename);
	  }
  
  public static function editfeatureData($feature_id){
    $value = DB::table('features')
      ->where('feature_id', $feature_id)
      ->first();
	return $value;
  }
  
  public static function editpageData($page_slug){
    $value = DB::table('pages')
      ->where('page_slug', $page_slug)
      ->first();
	return $value;
  }
  
  
  public static function editadminPage($page_id){
    $value = DB::table('pages')
      ->where('page_id', $page_id)
      ->first();
	return $value;
  }
  
  
  public static function updatepageData($page_id,$data){
    DB::table('pages')
      ->where('page_id', $page_id)
      ->update($data);
  }
  
  
  public static function totalpageData()
  {

    $get=DB::table('pages')->where('page_status','=','1')->get(); 
    $value = $get->count(); 
    return $value;
	
  }
  
  public static function ccpageCount($page_slug){
    $get = DB::table('pages')
      ->where('page_slug', $page_slug)
      ->get();
	$value = $get->count(); 
    return $value;
  }
  
  /* pages */
  
  
  
	
	
	
	
	
  
  
  
  
}
