<?php

namespace DownGrade\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DownGrade\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Session;
use DownGrade\Models\Product;
use DownGrade\Models\Attribute;
use DownGrade\Models\Settings;
use DownGrade\Models\Members;
use DownGrade\Models\Category;
use DownGrade\Models\SubCategory;
use DownGrade\Models\EmailTemplate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Mail;
use Illuminate\Support\Str;
use URL;
use Image;
use Storage;
use Carbon\Carbon;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Helper;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
		
    }
	
	public function custom()
	{
	    $dw_v = Helper::version_no();
		$custom = Settings::editCustom();
		return $custom->$dw_v;
	} 
	
	public function delete_refund($refund_id)
	{
	   
	   Product::deleteRefund($refund_id);
	   return redirect()->back()->with('success','Refund request has been deleted'); 
	
	}
	
	public function all_delete_refund(Request $request)
	{
	   
	   $refund_id = $request->input('refund_id');
	   foreach($refund_id as $id)
	   {
	      
		  Product::deleteRefund($id);
	   }
	   return redirect()->back()->with('success','Delete successfully.');
	
	}
	
	public function all_delete_withdrawal(Request $request)
	{
	   
	   $wd_id = $request->input('wd_id');
	   foreach($wd_id as $id)
	   {
	      
		  Product::deleteWithdraw($id);
	   }
	   return redirect()->back()->with('success','Delete successfully.');
	
	}
	
	public function delete_withdrawal($wd_id)
	{
	   
	   Product::deleteWithdraw($wd_id);
	   return redirect()->back()->with('success','Withdrawal request has been deleted'); 
	
	}
	
	/* compatible browsers */
	
	public function fileupload(Request $request)
	{
	 $product_token = $request->input('product_token');
	 if(!empty($product_token))
	 {
	 $edit['product'] = Product::editproductData($product_token);
	 $product_image['view'] = Product::getimagesData($product_token);
	 }
     $session_id = Session::getId();
	 $allsettings = Settings::allSettings();
     $watermark = $allsettings->site_watermark;
     $url = URL::to("/");
     if($request->hasFile('file')) {

       
       $destinationPath = public_path('/storage/product');

       // Create directory if not exists
       if (!file_exists($destinationPath)) {
          mkdir($destinationPath, 0755, true);
       }

       // Get file extension
       $extension = $request->file('file')->getClientOriginalExtension();

       // Valid extensions
       $validextensions = array("jpeg","jpg","png","zip");

       // Check extension
       if(in_array(strtolower($extension), $validextensions))
	   {

         // Rename file 
         $original = $request->file('file')->getClientOriginalName();
		 //$fileName = $this->brand_slug(Carbon::now()->toDayDateTimeString()).rand(11111, 99999) .'.' . $extension;

         // Uploading file to given path
         //$request->file('file')->move($destinationPath, $fileName);
		 
		 $image = $request->file('file');
		 $img_name = $this->brand_slug(Carbon::now()->toDayDateTimeString()).rand(11111, 99999) .'.' . $extension;
		 
		 /* wasabi */
		$wasabi_access_key_id = $allsettings->wasabi_access_key_id;
		$wasabi_secret_access_key = $allsettings->wasabi_secret_access_key;
		$wasabi_default_region = $allsettings->wasabi_default_region;
		$wasabi_bucket = $allsettings->wasabi_bucket;
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
		 if($allsettings->watermark_option == 1)
		 {
		            
					
					if($extension == "jpeg" or $extension == "jpg" or $extension == "png")
					{
					$imagePath = $destinationPath. "/".  $img_name;
					$image->move($destinationPath, $img_name);
					/* new code */		
					$watermarkImg=Image::make(public_path('/storage/settings/'.$watermark));
					$img=Image::make(public_path('/storage/product/'.$img_name));
					if($allsettings->watermark_repeat == 1)
					{
					
						$wmarkWidth=$watermarkImg->width();
						$wmarkHeight=$watermarkImg->height();
			
						$imgWidth=$img->width();
						$imgHeight=$img->height();
			
						$x=0;
						$y=0;
						while($y<=$imgHeight){
							$img->insert(public_path('/storage/settings/'.$watermark),'top-left',$x,$y);
							$x+=$wmarkWidth;
							if($x>=$imgWidth){
								$x=0;
								$y+=$wmarkHeight;
							}
						}
					}
					else
					{
					   if($allsettings->watermark_position == 'center')
					   {
					      $img->insert(public_path('/storage/settings/'.$watermark), $allsettings->watermark_position, 0, 0);
					   }
					   else
					   {
					     $img->insert(public_path('/storage/settings/'.$watermark), $allsettings->watermark_position, 10, 10);
					   }
					}
					$img->save(base_path('public/storage/product/'.$img_name));
					$fileName = $img_name;
					/* new code */
					}
					else
					{
					   
					   if($allsettings->site_s3_storage == 1)
				  		{
					 	//Storage::disk('wasabi')->put($img_name, file_get_contents($image));
						$s3->putObject([ 'Bucket' => $wasabi_bucket, 'Key' => $img_name, 'SourceFile' => $image]);
				 	    $fileName = $img_name;
				  		}
						else if($allsettings->site_s3_storage == 2)
			  	  		{
						Storage::disk('dropbox')->put($img_name, file_get_contents($image), '');
				        $fileName = $img_name;
				        }
						else if($allsettings->site_s3_storage == 3)
			  	  		{
						Storage::disk('google')->put($img_name, file_get_contents($image), '');
				        $fileName = $img_name;
				        }
						else if($allsettings->site_s3_storage == 4)
			  	  		{
						Storage::disk('s3')->put($img_name, file_get_contents($image), 'public');
				        $fileName = $img_name;
				        }
				  		else
						{
						   $imagePath = $destinationPath. "/".  $img_name;
						   $image->move($destinationPath, $img_name);
					       $fileName = $img_name;
						}
					
					}
					
					
			}
			else
			{
			       if($extension == "jpeg" or $extension == "jpg" or $extension == "png")
				 {
				    $imagePath = $destinationPath. "/".  $img_name;
					$image->move($destinationPath, $img_name);
					$fileName = $img_name;
			     }
				 else
				 {
					  if($allsettings->site_s3_storage == 1)
					  {
						 //Storage::disk('wasabi')->put($img_name, file_get_contents($image));
						 $s3->putObject([ 'Bucket' => $wasabi_bucket, 'Key' => $img_name, 'SourceFile' => $image]);
						 $fileName = $img_name;
					  }
					  else if($allsettings->site_s3_storage == 2)
			  	  	  {
						Storage::disk('dropbox')->put($img_name, file_get_contents($image), '');
				        $fileName = $img_name;
				      }
					  else if($allsettings->site_s3_storage == 3)
			  	  	  {
						Storage::disk('google')->put($img_name, file_get_contents($image), '');
				        $fileName = $img_name;
				      }
					  else if($allsettings->site_s3_storage == 4)
			  	  	  {
						Storage::disk('s3')->put($img_name, file_get_contents($image), 'public');
				        $fileName = $img_name;
				      }
					  else
					  {
					
						$imagePath = $destinationPath. "/".  $img_name;
						$image->move($destinationPath, $img_name);
						$fileName = $img_name;
					  }	
				}
			
			
			        
			}		
		  
		 
		 $data = array('original_file_name' => $original,'product_file_name' => $fileName, 'session_id' => $session_id);
         Product::proddataSave($data); 
		 $getdata['first'] = Product::getProdutData($session_id);
		 $getdata['second'] = Product::getProdutZip($session_id);
		 $getdata['third'] = Product::getProdutData($session_id);
		 $getdata['four'] = Product::getProdutData($session_id);
		 $record = '<div class="form-group">
                                                <label for="customer_earnings" class="control-label mb-1">Upload Thumbnail Image (Size : 296px X 200px) <span class="require">*</span></label>
                                                <select name="product_image2" class="form-control">
                                                <option value=""></option>';
												foreach($getdata['first'] as $get)
												{
												$record .= '<option value="'.$get->product_file_name.'">'.$get->original_file_name.'</option>';
												}
                                                $record .= '</select>';
                                            
											 if(!empty($product_token))
											 {
											   if($edit['product']->product_image!='')
											   {
											      $record .='<img src="'.url('/').'/public/storage/product/'.$edit['product']->product_image.'" alt="'.$edit['product']->product_name.'" class="item-thumb">';
											   }
											   else
											   {
											      $record .='<img src="'.url('/').'/public/img/no-image.png" alt="'.$edit['product']->product_name.'" class="item-thumb">';
											   }
                                             } 
											 $record .= '</div>';
									$record .= '<div class="form-group">
                                                <label for="customer_earnings" class="control-label mb-1">Upload Preview Image (Size : 762px X 508px) <span class="require">*</span></label>
                                                <select name="product_preview2" class="form-control">
                                                <option value=""></option>';
												foreach($getdata['four'] as $get)
												{
												$record .= '<option value="'.$get->product_file_name.'">'.$get->original_file_name.'</option>';
												}
                                                $record .= '</select>';
                                            
											 if(!empty($product_token))
											 {
											   if($edit['product']->product_preview!='')
											   {
											      $record .='<img src="'.url('/').'/public/storage/product/'.$edit['product']->product_preview.'" alt="'.$edit['product']->product_name.'" class="item-thumb">';
											   }
											   else
											   {
											      $record .='<img src="'.url('/').'/public/img/no-image.png" alt="'.$edit['product']->product_name.'" class="item-thumb">';
											   }
                                             } 
											 $record .= '</div>';
								$record .= '<div class="form-group">
                                                <label for="name" class="control-label mb-1">Upload Main File Type <span class="require">*</span></label>
                                               <select name="product_file_type2" id="product_file_type2" class="form-control" data-bvalidator="required">
                                                <option value=""></option>';
												if(!empty($product_token))
												{
												   if($edit['product']->product_file_type == 'file')
												   {
												   $record .= '<option value="file" selected>File</option>
												               <option value="link">Link / URL</option>';
															   
												   }
												   else if($edit['product']->product_file_type == 'link')
												   {
													 $record .= '<option value="file">File</option>
												                 <option value="link" selected>Link / URL</option>';
																
												   }
												   else
												   {
												      $record .= '<option value="file">File</option>
												                  <option value="link">Link / URL</option>';
																  
												   }
												}
												else
												{
												    $record .= '<option value="file">File</option>
												            <option value="link">Link / URL</option>';
															
												}
                                                $record .= '</select></div>';
								if(!empty($product_token))
								{
								   if($edit['product']->product_file_type == 'file')
								   {
								   $record .= '<div id="main_file" class="form-group display-block">';
								   }
								   else if($edit['product']->product_file_type == 'link')
								   {
								     $record .= '<div id="main_file" class="form-group display-none">';
									 
								   }
								   else
								   {
								      $record .= '<div id="main_file" class="form-group">';
								   }
								}
								else
								{			
								$record .= '<div id="main_file" class="form-group">';
								}										 
		                        $record .= '<div class="form-group">
                                                <label for="customer_earnings" class="control-label mb-1">Upload Main File (Zip Format Only)<span class="require">*</span></label>
                                                <select name="product_file2" class="form-control">
                                                <option value=""></option>';
												foreach($getdata['second'] as $get)
												{
												$record .= '<option value="'.$get->product_file_name.'">'.$get->original_file_name.'</option>';
												}
                                                $record .= '</select>';
											 if(!empty($product_token))
											 {
											     if($edit['product']->product_file!='')
												 {
												    $record .= '<span class="require">'.$edit['product']->product_file.'</span>';
												 }
                                             }
											 $record .= '</div></div>';
								             if(!empty($product_token))
								             {
												   if($edit['product']->product_file_type == 'file')
												   {
												   $record .= '<div id="main_link" class="form-group display-none">';
												   }
												   else if($edit['product']->product_file_type == 'link')
												   {
													 $record .= '<div id="main_link" class="form-group display-block">';
												   }
												   else
												   {
													  $record .= '<div id="main_link" class="form-group">';
												   }
												}
												else
												{			
												$record .= '<div id="main_link" class="form-group">';
												}
												if(!empty($product_token))
												 {
												   if(!empty($edit['product']->product_file_link))
												   {
												   $item_file_linked = $edit['product']->product_file_link;
												   }
												   else
												   {
													  $item_file_linked = "";
												   }
												 }
												 else
												 {
												  $item_file_linked = "";
												 }
                                                $record .= '<label for="name" class="control-label mb-1">Main File Link/URL <span class="require">*</span></label>
                                                <input type="text" id="product_file_link2" name="product_file_link2" class="form-control" value="'.$item_file_linked.'" data-bvalidator="required">
                                                
                                            </div>';
												 
                                     $record .= '<div class="form-group">
                                                <label for="customer_earnings" class="control-label mb-1">Upload Gallery Images (Multiselect)</label>
                                                <select id="product_gallery" name="product_gallery[]" class="form-control" multiple>';
												foreach($getdata['third'] as $get)
												{
												$record .= '<option value="'.$get->product_file_name.'">'.$get->original_file_name.'</option>';
												}
                                                $record .= '</select>';
												if(!empty($product_token))
											   {
											      $alerttext = 'Are you sure you want to delete?';
											      foreach($product_image['view'] as $product)
												  {
												      $record .= '<div class="item-img"><img src="'.url('/').'/public/storage/product/'.$product->product_gallery_image .'" alt="'.$product->product_gallery_image.'" class="item-thumb">';
													  $record .='<a href="'.url('/admin/edit-product').'/dropimg/'.base64_encode($product->prod_gal_id).'" onClick="return confirm("'.$alerttext.'");" class="drop-icon"><span class="ti-trash drop-icon"></span></a></div>';
													  
												  }
											   }
                                             $record .= '</div>';
											 $record .= '<script>
									        $("#product_file_type2").on("change", function() {
												  if ( this.value == "file")
												  {
													$("#main_file").show();
													$("#main_link").hide();
													
												  }
												  else if(this.value == "link")
												  {
													$("#main_file").hide();
													$("#main_link").show();
													
												  }
												  else
												  {
													$("#main_file").hide();
													$("#main_link").hide();
													
												  }
												});	
											</script>';
		 
		 return response()->json(['success' => true, 'record' => $record]);

        }

      }
    }
	
	
	public function view_compatible_browsers()
    {
      	$browserData['view'] = Product::browserData();
		if($this->custom() != 0)
	    {
		return view('admin.compatible-browsers',[ 'browserData' => $browserData]);
		}
	    else
	    {
		  return redirect('/admin/license');
	    }
    }
	
	public function add_compatible_browsers()
	{
	   if($this->custom() != 0)
	   {
	   return view('admin.add-compatible-browsers');
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	
	public function save_compatible_browsers(Request $request)
	{
         
		 $browser_name = $request->input('browser_name');
		 
		 
		 
         
		 $request->validate([
		                    
							'browser_name' => 'required',
							
							
							
         ]);
		 $rules = array(
				
			'browser_name' => ['required', Rule::unique('product_compatible_browsers') -> where(function($sql){ $sql->where('browser_drop_status','=','no');})],	
	     );
		 
		 $messsages = array(
		      
	    );
		 
		$validator = Validator::make($request->all(), $rules,$messsages);
		
		if ($validator->fails()) 
		{
		 $failedRules = $validator->failed();
		 return back()->withErrors($validator);
		} 
		else
		{
			   
		 
		$data = array('browser_name' => $browser_name);
        Product::insertbrowserData($data);
        return redirect('/admin/compatible-browsers')->with('success', 'Insert successfully.');
            
 
       } 
     
    
  }
  
  
   public function delete_compatible_browsers($browser_id){

      
	  $data = array('browser_drop_status' => 'yes');
      Product::deleteBrowserdata($browser_id,$data);
	  
	  return redirect()->back()->with('success', 'Delete successfully.');

    
  }
  
  public function edit_compatible_browsers($browser_id)
	{
	   
	   $edit['browser'] = Product::editbrowserData($browser_id);
	   if($this->custom() != 0)
	   {
	   return view('admin.edit-compatible-browsers', [ 'edit' => $edit, 'browser_id' => $browser_id]);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	
	public function update_compatible_browsers(Request $request)
	{
         
		 $browser_name = $request->input('browser_name');
		 $browser_id = $request->input('browser_id');
		 
		 
         
		 $request->validate([
		                    
							'browser_name' => 'required',
							
							
							
         ]);
		 $rules = array(
				
				'browser_name' => ['required', Rule::unique('product_compatible_browsers') ->ignore($browser_id, 'browser_id') -> where(function($sql){ $sql->where('browser_drop_status','=','no');})],
	     );
		 
		 $messsages = array(
		      
	    );
		 
		$validator = Validator::make($request->all(), $rules,$messsages);
		
		if ($validator->fails()) 
		{
		 $failedRules = $validator->failed();
		 return back()->withErrors($validator);
		} 
		else
		{
			   
		 
		$data = array('browser_name' => $browser_name);
        Product::updatebrowserData($browser_id,$data);
        return redirect('/admin/compatible-browsers')->with('success', 'Update successfully.');
            
 
       } 
     
    
  }
  
	/* compatible browsers */
	
	
	/* package includes */
	
	public function view_package_includes()
    {
      	$packData['view'] = Product::packData();
		if($this->custom() != 0)
	    {
		return view('admin.package-includes',[ 'packData' => $packData]);
		}
	    else
	    {
		  return redirect('/admin/license');
	    }
    }
	public function add_package_includes()
	{
	   if($this->custom() != 0)
	   {
	   return view('admin.add-package-includes');
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	
	public function save_package_includes(Request $request)
	{
         
		 $package_name = $request->input('package_name');
		 
		 
		 
         
		 $request->validate([
		                    
							'package_name' => 'required',
							
							
							
         ]);
		 $rules = array(
				
			'package_name' => ['required', Rule::unique('product_package_includes') -> where(function($sql){ $sql->where('package_drop_status','=','no');})],	
	     );
		 
		 $messsages = array(
		      
	    );
		 
		$validator = Validator::make($request->all(), $rules,$messsages);
		
		if ($validator->fails()) 
		{
		 $failedRules = $validator->failed();
		 return back()->withErrors($validator);
		} 
		else
		{
			   
		 
		$data = array('package_name' => $package_name);
        Product::insertpackData($data);
        return redirect('/admin/package-includes')->with('success', 'Insert successfully.');
            
 
       } 
     
    
  }
  
  public function delete_package_includes($package_id){

      
	  $data = array('package_drop_status' => 'yes');
      Product::deletePackdata($package_id,$data);
	  
	  return redirect()->back()->with('success', 'Delete successfully.');

    
  }
  
  public function edit_package_includes($package_id)
	{
	   
	   $edit['pack'] = Product::editpackData($package_id);
	   if($this->custom() != 0)
	   {
	   return view('admin.edit-package-includes', [ 'edit' => $edit, 'package_id' => $package_id]);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	
	public function update_package_includes(Request $request)
	{
         
		 $package_name = $request->input('package_name');
		 $package_id = $request->input('package_id');
		 
		 
         
		 $request->validate([
		                    
							'package_name' => 'required',
							
							
							
         ]);
		 $rules = array(
				
				'package_name' => ['required', Rule::unique('product_package_includes') ->ignore($package_id, 'package_id') -> where(function($sql){ $sql->where('package_drop_status','=','no');})],
	     );
		 
		 $messsages = array(
		      
	    );
		 
		$validator = Validator::make($request->all(), $rules,$messsages);
		
		if ($validator->fails()) 
		{
		 $failedRules = $validator->failed();
		 return back()->withErrors($validator);
		} 
		else
		{
			   
		 
		$data = array('package_name' => $package_name);
        Product::updatepackData($package_id,$data);
        return redirect('/admin/package-includes')->with('success', 'Update successfully.');
            
 
       } 
     
    
  }
  
	/* package includes */
	
	
	
	/* brands */
	
	
    
	
	
	
	
	public function brand_slug($string)
	{
		   
		$string = preg_replace('/[^\p{L}\p{N}\s]/u', '', $string);
		$string = str_replace(' ', '-', $string);
		$string = strtolower($string);
		return $string; 
		
		
		 
		   
    }
	
	
	
	
  
  
  public function complete_orders($ord_id)
  {
                    $sid = 1;
					$setting['setting'] = Settings::editGeneral($sid);
	                $custom_settings = Settings::editCustom();
					$payment_status = 'completed';
					$purchased_token = base64_decode($ord_id);
					$orderdata = array('order_status' => $payment_status);
					$checkoutdata = array('payment_status' => $payment_status);
					Product::singleordupdateData($purchased_token,$orderdata);
					Product::singlecheckoutData($purchased_token,$checkoutdata);
					
					$token = $purchased_token;
					
					$check['display'] = Product::getcheckoutData($token);
					$order_id = $check['display']->order_ids;
					$order_loop = explode(',',$order_id);
					   /* download file */
					$download_file = "";
					/* download file */
					  foreach($order_loop as $order)
					  {
						
						$getitem['item'] = Product::getorderData($order);
						$token = $getitem['item']->product_token;
						$item['display'] = Product::solditemData($token);
						$product_sold = $item['display']->product_sold + 1;
						$item_token = $token; 
						$data = array('product_sold' => $product_sold);
					    Product::updateitemData($item_token,$data);
						
						$orderdata = array('approval_status' => 'payment released to admin');
		                Product::singleorderupData($order,$orderdata);
						/* download file */
						$encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
						$download_file .= URL::to('/download-file').'/'.$encrypter->encrypt($item['display']->product_token).'<br/><br/>';
						/* download file */
						
					  }
					
					 $final_amount = $check['display']->total;
					 $admin['info'] = Members::adminData();
					 $admin_token = $admin['info']->user_token;
					 $admin_earning = $admin['info']->earnings + $final_amount;
					 $admin_record = array('earnings' => $admin_earning);
					 Members::updateadminData($admin_token, $admin_record);
		             
					 $user_id = $check['display']->user_id;
					 
					$to_name = $setting['setting']->sender_name;
					$to_email = $setting['setting']->sender_email;
					$currency = $setting['setting']->site_currency_code;
					$from['info'] = Members::singlevendorData($user_id);
					$from_name = $from['info']->name;
					$from_email = $from['info']->email;
					$data = array('to_name' => $to_name, 'to_email' => $to_email, 'final_amount' => $final_amount, 'currency' => $currency, 'from_name' => $from_name, 'from_email' => $from_email, 'purchased_token' => $purchased_token, 'download_file' => $download_file);
					/* email template code */
					$checktemp = EmailTemplate::checkTemplate(21);
					if($checktemp != 0)
					{
						$template_view['mind'] = EmailTemplate::viewTemplate(21);
						$template_subject = $template_view['mind']->et_subject;
					}
					else
					{
						$template_subject = "Item Purchase Notifications";
					}
					/* email template code */
					Mail::send('admin_payment_mail', $data , function($message) use ($from_name, $from_email, $to_name, $to_email, $purchased_token, $template_subject) {
							$message->to($to_email, $to_name)
									->subject($template_subject);
							$message->from($from_email,$from_name);
						});
					 
					if($purchased_token != "")
					{
					Mail::send('admin_payment_mail', $data , function($message) use ($from_name, $from_email, $to_name, $to_email, $purchased_token, $template_subject) {
							$message->to($from_email,$from_name)
									->subject($template_subject);
							$message->from($to_email, $to_name);
						});
					}
					 
					/* referral per sale earning */
					if($custom_settings->affiliate_referral == 1)
					{
						$logged_id = $check['display']->user_id;
						$buyer_details = Members::singlebuyerData($logged_id);
						$referral_by = $buyer_details->referral_by;
						
						/* new code */
						if($custom_settings->per_sale_referral_commission_type == 'fixed')
						{
						$per_sale_commission = $setting['setting']->per_sale_referral_commission;
						}
						else
						{
						$per_sale_commission = ($setting['setting']->per_sale_referral_commission * $final_amount) / 100;
						}
						$referral_commission = $per_sale_commission;
						/* new code */
						$check_referral = Members::referralCheck($referral_by);
						if($check_referral != 0)
						{
							$referred['display'] = Members::referralUser($referral_by);
							$wallet_amount = $referred['display']->earnings + $referral_commission;
							$referral_amount = $referred['display']->referral_amount + $referral_commission;
							$update_data = array('earnings' => $wallet_amount, 'referral_amount' => $referral_amount);
							Members::updateReferral($referral_by,$update_data);
						} 
					}
					/* referral per sale earning */
					return redirect()->back()->with('success', 'Payment details has been completed');	
					
					
					
  
  
  }
  
  
  public function all_delete_orders(Request $request)
	{
	   
	   $purchase_token = $request->input('purchase_token');
	   foreach($purchase_token as $id)
	   {
	      
		  Product::deleteOrderdata($id);
	   }
	   return redirect()->back()->with('success','Delete successfully.');
	
	}
  
  public function view_orders_delete($delete,$purchase_id)
  {
     
	 Product::deleteOrderdata($purchase_id);
	  
	 return redirect()->back()->with('success', 'Delete successfully.');
	 
  }
  
  
	/* brands */
	
	
	public function update_rating(Request $request)
	{
	  
	 $or_product_token = $request->input('or_product_token');       
	 $rating_id = $request->input('rating_id');
	 $rating = $request->input('rating');
	 $rating_comment = $request->input('rating_comment');
	 $rating_reason = $request->input('rating_reason');
         $rating_date = date('Y-m-d H:i:s');
		 $request->validate([
		                    
							
							
							
         ]);
		 $rules = array(
				
				
	     );
		 
		 $messsages = array(
		      
	    );
		 
		$validator = Validator::make($request->all(), $rules,$messsages);
		
		if ($validator->fails()) 
		{
		 $failedRules = $validator->failed();
		 return back()->withErrors($validator);
		} 
		else
		{
		
		$updata = array('rating' => $rating, 'rating_reason' => $rating_reason, 'rating_comment' => $rating_comment, 'rating_date' => $rating_date); 
		Product::updateratingData($rating_id,$updata);
        return redirect('/admin/reviews/'.$or_product_token)->with('success', 'Update successfully.');
            
 
       } 
	 
	 
	 
       
	
	
	}
	
	
	/* products */
	
	public function view_products()
    {
      	$itemData['item'] = Product::productData();
		$search = "";
		$reviews = Product::getcountreviewData();
		$data = array('itemData' => $itemData, 'search' => $search, 'reviews' => $reviews);
		if($this->custom() != 0)
	    {
		return view('admin.products')->with($data);
		}
	    else
	    {
		  return redirect('/admin/license');
	    }
    }
	
	
	public function search_products(Request $request)
	{
	 
	  if(!empty($request->input('search')))
	   {
	      
		  
		  $search = $request->input('search');
		  $itemData['item'] = Product::searchentireProduct($search);
		  
	   }
	   else
	   {
	     $itemData['item'] = Product::productData();
		 $search = "";
	  
	   }
	  $reviews = Product::getcountreviewData(); 
	  $data = array('itemData' => $itemData, 'search' => $search, 'reviews' => $reviews); 
	  if($this->custom() != 0)
	  {
	  return view('admin.products')->with($data);
	  }
	  else
	  {
		  return redirect('/admin/license');
	  }
	}
	
	
	
	
	
	public function add_product()
	{
	   $sid = 1;
	   $allsettings = Settings::editGeneral($sid);
	   $browser['view'] = Product::browserData();
	   $package['view'] = Product::packData();
	   $session_id = Session::getId();
	   $getdata1['first'] = Product::getProdutData($session_id);
	   $getdata2['second'] = Product::getProdutZip($session_id);
	   $getdata3['third'] = Product::getProdutData($session_id);
	   $getdata4 = Product::getProdutData($session_id);
	   $re_categories['menu'] = Category::with('SubCategory')->where('category_status','=','1')->where('drop_status','=','no')->orderBy('display_order',$allsettings->menu_categories_order)->get();
		$attribute['fields'] = Attribute::selectedAttribute();
	   return view('admin.add-product',[ 're_categories' => $re_categories, 'browser' => $browser, 'package' => $package, 'getdata1' => $getdata1, 'getdata2' => $getdata2, 'getdata3' => $getdata3, 'attribute' => $attribute, 'getdata4' => $getdata4]);
	}
	
	public function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
	
	public function save_product(Request $request)
{
    $session_id         = Session::getId();
    $product_name       = $request->input('product_name');
    $product_slug       = $request->input('product_slug')
                          ?: $this->brand_slug($product_name);
    $image_size         = $request->input('image_size');
    $zip_size           = $request->input('zip_size');
    $product_short_desc = $request->input('product_short_desc');
    $product_desc       = $request->input('product_desc');
    $product_category   = $request->input('product_category');
    
    list($cat_name, $cat_id) = explode('_', $product_category, 2);
    $parent_category_id = $cat_name === 'subcategory'
        ? Category::editsubcategoryData($cat_id)->cat_id
        : $cat_id;

    $subscription_item  = $request->input('subscription_item');
    $regular_price      = $request->input('regular_price');
    $extended_price     = $request->input('extended_price');
    $product_tags       = $request->input('product_tags');
    $product_featured   = $request->input('product_featured');
    $product_demo_url   = $request->input('product_demo_url');
    $product_allow_seo  = $request->input('product_allow_seo');
    $product_seo_keyword= $request->input('product_seo_keyword');
    $product_seo_desc   = $request->input('product_seo_desc');
    $product_video_url  = $request->input('product_video_url');
    $product_flash_sale = $request->input('product_flash_sale');
    $product_free       = $request->input('product_free');
    $user_id            = $request->input('user_id');
    $product_token      = $this->generateRandomString();
    $product_date       = now()->format('Y-m-d H:i:s');
    $product_update     = now()->format('Y-m-d H:i:s');
    $product_status     = 1;
    $product_fake_stars = $request->input('product_fake_stars');
    $future_update      = $request->input('future_update');
    $item_support       = $request->input('item_support');

    // choose existing or uploaded values
    $product_image      = $request->input('product_image1', $request->input('product_image2'));
    $product_preview    = $request->input('product_preview1', $request->input('product_preview2'));
    $product_file       = $request->input('product_file1',  $request->input('product_file2'));
    $product_file_type  = $request->input('product_file_type1', $request->input('product_file_type2'));
    $product_file_link  = $request->input('product_file_link1', $request->input('product_file_link2'));
    $product_gallery    = $request->input('product_gallery')
                          ? implode(',', $request->input('product_gallery'))
                          : '';
    $product_sold       = $request->input('product_sold');

    // 1) Base validation
    $rules = [
        'type'         => 'required|in:downloadable,non_downloadable',
        'product_name' => [
            'required','max:100',
            Rule::unique('product')->where('product_drop_status','no')
        ],
        'product_desc' => 'required',
    ];

    // 2) Downloadable-only rules
    if ($request->input('type') === 'downloadable') {
        $rules['product_image1']     = "required|mimes:jpeg,jpg,png|max:{$image_size}";
        $rules['product_preview1']   = "required|mimes:jpeg,jpg,png|max:{$image_size}";
        $rules['product_file_type1'] = 'required';
        $rules['product_file1']      = "required|mimes:zip|max:{$zip_size}";
        $rules['product_gallery.*']  = "image|mimes:jpeg,jpg,png|max:{$image_size}";
    }

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // 3) Data assembly
    $data = [
        'user_id'                   => $user_id,
        'product_token'             => $product_token,
        'product_name'              => $product_name,
        'type'                      => $request->input('type'),
        'product_slug'              => $product_slug,
        'product_category'          => $cat_id,
        'product_category_parent'   => $parent_category_id,
        'product_category_type'     => $cat_name,
        'product_type_cat_id'       => $product_category,
        'product_short_desc'        => $product_short_desc,
        'product_desc'              => $product_desc,
        'regular_price'             => $regular_price,
        'extended_price'            => $extended_price,
        'product_image'             => $product_image,
        'product_preview'           => $product_preview,
        'product_video_url'         => $product_video_url,
        'product_demo_url'          => $product_demo_url,
        'product_allow_seo'         => $product_allow_seo,
        'product_seo_keyword'       => $product_seo_keyword,
        'product_seo_desc'          => $product_seo_desc,
        'product_tags'              => $product_tags,
        'product_featured'          => $product_featured,
        'product_file'              => $product_file,
        'product_date'              => $product_date,
        'product_update'            => $product_update,
        'product_status'            => $product_status,
        'product_flash_sale'        => $product_flash_sale,
        'product_free'              => $product_free,
        'item_support'              => $item_support,
        'future_update'             => $future_update,
        'product_sold'              => $product_sold,
        'product_file_type'         => $product_file_type,
        'product_file_link'         => $product_file_link,
        'product_fake_stars'        => $product_fake_stars,
        'subscription_item'         => $subscription_item,
    ];

    // 4) Insert
    Product::insertproductData($data);

    // 5) Attributes
    foreach (Attribute::selectedAttribute() as $attr) {
        if ($vals = $request->input("attributes_{$attr->attr_id}")) {
            Product::saveAttribute([
                'product_token'            => $product_token,
                'attribute_id'             => $attr->attr_id,
                'product_attribute_label'  => $attr->attr_label,
                'product_attribute_values' => implode(',', $vals),
            ]);
        }
    }

    // 6) Gallery
    if ($product_gallery) {
        foreach (explode(',', $product_gallery) as $img) {
            Product::saveproductImages([
                'product_token'          => $product_token,
                'product_gallery_image'  => $img,
            ]);
        }
    }

    Product::deleteDATA($session_id);
    return redirect('/admin/products')->with('success', 'Insert successfully.');
}
 
     
    
  
  
  
  public function all_delete_product(Request $request)
	{
	   
	   $product_token = $request->input('product_token');
	   $data = array('product_drop_status' => 'yes');
	   foreach($product_token as $id)
	   {
	      
		  Product::deleteProductdata($id,$data);
	   }
	   return redirect()->back()->with('success','Delete successfully.');
	
	}
  
  
  public function delete_product($product_token){

      
	  $data = array('product_drop_status' => 'yes');
      Product::deleteProductdata($product_token,$data);
	  
	  return redirect()->back()->with('success', 'Delete successfully.');

    
  }
  
  
  public function edit_product($product_token)
	{
	   $sid = 1;
	   $allsettings = Settings::editGeneral($sid);
	   $edit['product'] = Product::editproductData($product_token);
	   $cat_name = $edit['product']->product_category_type; 
        $cat_id = $edit['product']->product_category;
	   $product_image['view'] = Product::getimagesData($product_token);
	   $re_categories['menu'] = Category::with('SubCategory')->where('category_status','=','1')->where('drop_status','=','no')->orderBy('display_order',$allsettings->menu_categories_order)->get();
	   
	   $session_id = Session::getId();
	   $getdata1['first'] = Product::getProdutData($session_id);
	   $getdata2['second'] = Product::getProdutZip($session_id);
	   $getdata3['third'] = Product::getProdutData($session_id);
	   $getdata4 = Product::getProdutData($session_id);
	   $attri_field['display'] = Attribute::selectedAttribute();
	   if($this->custom() != 0)
	   {
	   return view('admin.edit-product', [ 'edit' => $edit, 'product_token' => $product_token, 'product_image' => $product_image, 're_categories' => $re_categories,  'getdata1' => $getdata1, 'getdata2' => $getdata2, 'getdata3' => $getdata3, 'cat_id' => $cat_id, 'cat_name' => $cat_name, 'attri_field' => $attri_field, 'getdata4' => $getdata4]);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	public function drop_image_product($dropimg,$token)
	{
	   
	   $token = base64_decode($token); 
	   Product::deleteimgdata($token);
	  
	  return redirect()->back()->with('success', 'Delete successfully.');
	
	}
	
	
	public function update_product(Request $request)
{
    $session_id         = Session::getId();
    $product_name       = $request->input('product_name');
    $product_slug       = $request->input('product_slug')
                          ?: $this->brand_slug($product_name);
    $image_size         = $request->input('image_size');
    $zip_size           = $request->input('zip_size');
    $product_short_desc = $request->input('product_short_desc');
    $product_desc       = $request->input('product_desc');
    $product_category   = $request->input('product_category');
    list($cat_name, $cat_id) = explode('_', $product_category, 2);
    $parent_category_id = $cat_name === 'subcategory'
        ? Category::editsubcategoryData($cat_id)->cat_id
        : $cat_id;

    $regular_price      = $request->input('regular_price');
    $extended_price     = $request->input('extended_price');
    $product_tags       = $request->input('product_tags');
    $product_featured   = $request->input('product_featured');
    $product_demo_url   = $request->input('product_demo_url');
    $product_allow_seo  = $request->input('product_allow_seo');
    $product_seo_keyword= $request->input('product_seo_keyword');
    $product_seo_desc   = $request->input('product_seo_desc');
    $product_video_url  = $request->input('product_video_url');
    $user_id            = $request->input('user_id');
    $product_token      = $request->input('product_token');
    $product_date       = now()->format('Y-m-d H:i:s');
    $product_status     = $request->input('product_status');
    $save_image         = $request->input('save_product_image');
    $save_preview       = $request->input('save_product_preview');
    $save_file          = $request->input('save_product_file');
    $product_flash_sale = $request->input('product_flash_sale');
    $product_free       = $request->input('product_free');
    $subscription_item  = $product_free == 1
                          ? 0
                          : $request->input('subscription_item');
    $future_update      = $request->input('future_update');
    $item_support       = $request->input('item_support');
    $product_fake_stars = $request->input('product_fake_stars');
    $product_image      = $request->input('product_image1', $save_image);
    $product_preview    = $request->input('product_preview1', $save_preview);
    $product_file       = $request->input('product_file1', $save_file);
    $product_file_type  = $request->input('product_file_type1', $request->input('save_file_type'));
    $product_file_link  = $request->input('product_file_link1', $request->input('product_file_link2'));
    $product_gallery    = $request->input('product_gallery')
                          ? implode(',', $request->input('product_gallery'))
                          : '';
    $product_sold       = $request->input('product_sold');
    $type               = $request->input('type');

    // 1) Base validation rules
    $rules = [
        'type'         => 'required|in:downloadable,non_downloadable',
        'product_name' => [
            'required','max:100',
            Rule::unique('product')
                ->ignore($product_token,'product_token')
                ->where('product_drop_status','no')
        ],
        'product_desc' => 'required',
    ];

    // 2) Downloadable-only rules
    if ($type === 'downloadable') {
        $rules['product_image1']     = "required|mimes:jpeg,jpg,png|max:{$image_size}";
        $rules['product_preview1']   = "required|mimes:jpeg,jpg,png|max:{$image_size}";
        $rules['product_file_type1'] = 'required';
        $rules['product_file1']      = "required|mimes:zip|max:{$zip_size}";
        $rules['product_gallery.*']  = "image|mimes:jpeg,jpg,png|max:{$image_size}";
    }

    // 3) Run validation
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // 4) Assemble data (including type)
    $data = [
        'user_id'                   => $user_id,
        'type'                      => $type,
        'product_name'              => $product_name,
        'product_slug'              => $product_slug,
        'product_category'          => $cat_id,
        'product_category_parent'   => $parent_category_id,
        'product_category_type'     => $cat_name,
        'product_type_cat_id'       => $product_category,
        'product_short_desc'        => $product_short_desc,
        'product_desc'              => $product_desc,
        'regular_price'             => $regular_price,
        'extended_price'            => $extended_price,
        'product_image'             => $product_image,
        'product_preview'           => $product_preview,
        'product_video_url'         => $product_video_url,
        'product_demo_url'          => $product_demo_url,
        'product_allow_seo'         => $product_allow_seo,
        'product_seo_keyword'       => $product_seo_keyword,
        'product_seo_desc'          => $product_seo_desc,
        'product_tags'              => $product_tags,
        'product_featured'          => $product_featured,
        'product_file'              => $product_file,
        'product_update'            => $product_date,
        'product_status'            => $product_status,
        'product_flash_sale'        => $product_flash_sale,
        'product_free'              => $product_free,
        'future_update'             => $future_update,
        'item_support'              => $item_support,
        'product_sold'              => $product_sold,
        'product_file_type'         => $product_file_type,
        'product_file_link'         => $product_file_link,
        'product_fake_stars'        => $product_fake_stars,
        'subscription_item'         => $subscription_item,
    ];

    // 5) Update product
    Product::updateproductData($product_token, $data);

    // 6) Update attributes
    Product::dropAttribute($product_token);
    foreach (Attribute::selectedAttribute() as $attr) {
        if ($vals = $request->input("attributes_{$attr->attr_id}")) {
            Product::saveAttribute([
                'product_token'            => $product_token,
                'attribute_id'             => $attr->attr_id,
                'product_attribute_label'  => $attr->attr_label,
                'product_attribute_values' => implode(',', $vals),
            ]);
        }
    }

    // 7) Update gallery
    if ($product_gallery) {
        foreach (explode(',', $product_gallery) as $img) {
            Product::saveproductImages([
                'product_token'         => $product_token,
                'product_gallery_image' => $img,
            ]);
        }
    }

    Product::deleteDATA($session_id);
    return redirect('/admin/products')->with('success', 'Update successfully.');
} 
     
    

  
	
	/* products */
	
	/* admin orders */
	public function search_orders(Request $request)
	{
	 
	  if(!empty($request->input('search')))
	   {
	      
		  
		  $search = $request->input('search');
		  $itemData['item'] = Product::searchentireOrder($search);
		  
	   }
	   else
	   {
	     $itemData['item'] = Product::getorderItem();
		 $search = "";
	  
	   }
	  
	  $data = array('itemData' => $itemData, 'search' => $search);
	  if($this->custom() != 0)
	  { 
	  return view('admin.orders')->with($data);
	  }
	  else
	  {
		  return redirect('/admin/license');
	  }
	}
	public function view_orders()
	{
	   
	   $itemData['item'] = Product::getorderItem();
	   $search = '';
	   $data = array('itemData' => $itemData, 'search' => $search);
	   if($this->custom() != 0)
	   { 
	   return view('admin.orders')->with($data);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	public function view_order_single($token)
	{
	  $itemData['item'] = Product::adminorderItem($token);
	  $data = array('itemData' => $itemData);
	  if($this->custom() != 0)
	  { 
	  return view('admin.order-details')->with($data);
	  }
	  else
	  {
		  return redirect('/admin/license');
	  }
	}
	
	
	public function view_more_info($token)
	{
	   $itemData['item'] = Product::getsingleOrder($token);
	   $data = array('itemData' => $itemData);
	   if($this->custom() != 0)
	   { 
	   return view('admin.more-info')->with($data);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	 
	}
	
	/* admin orders */
	
	
	/* admin refund */
	
	public function view_refund()
	{
	  
	  $itemData['item'] = Product::getrefundItem();
	   $data = array('itemData' => $itemData);
	   if($this->custom() != 0)
	   { 
	   return view('admin.refund')->with($data);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	
	public function view_payment_refund($ord_id,$refund_id,$user_type)
	{
	  $order = $ord_id; 
	  $ordered['data'] = Product::singleorderData($order);
	  $user_id = $ordered['data']->user_id;
	  $item_user_id = $ordered['data']->product_user_id;
	  $price = $ordered['data']->total_price;
	  $approval_status = $ordered['data']->approval_status;
	  
	  
	  if($user_type == "customer")
	  {
	  
	      if($approval_status == "")
		  {
		  
		    $buyer['info'] = Members::singlebuyerData($user_id);
			 $user_token = $buyer['info']->user_token;
			 $to_name = $buyer['info']->name;
			 $to_email = $buyer['info']->email;
			 $buyer_earning = $buyer['info']->earnings + $price;
			 $record = array('earnings' => $buyer_earning);
			 Members::updatepasswordData($user_token, $record);
			 
			$orderdata = array('approval_status' => 'payment released to customer');
			$refundata = array('ref_refund_approval' => 'accepted');
			Product::singleorderupData($order,$orderdata);
			Product::refundupData($refund_id,$refundata);
			Product::deleteRating($ord_id);
			
			
			
			$sid = 1;
			$setting['setting'] = Settings::editGeneral($sid);
			$admin_name = $setting['setting']->sender_name;
			$admin_email = $setting['setting']->sender_email;
			$currency = $setting['setting']->site_currency_symbol;
			$data = array('to_name' => $to_name, 'to_email' => $to_email, 'price' => $price, 'currency' => $currency);
			/* email template code */
	          $checktemp = EmailTemplate::checkTemplate(13);
			  if($checktemp != 0)
			  {
			  $template_view['mind'] = EmailTemplate::viewTemplate(13);
			  $template_subject = $template_view['mind']->et_subject;
			  }
			  else
			  {
			  $template_subject = "Payment Refund Accepted";
			  }
			  /* email template code */
			Mail::send('admin.buyer_refund_mail', $data , function($message) use ($admin_name, $admin_email, $to_name, $to_email, $template_subject) {
					$message->to($to_email, $to_name)
							->subject($template_subject);
					$message->from($admin_email,$admin_name);
				});
				
				
			
			return redirect()->back()->with('success','Payment released to customer'); 
		
		  
		     
		  }
		  else if($approval_status == 'payment released to customer')
		  {
		     $refundata = array('ref_refund_approval' => 'accepted');
			 Product::refundupData($refund_id,$refundata);
			 Product::deleteRating($ord_id);
		     return redirect()->back()->with('success','Payment released to customer');
		  }
		  else if($approval_status == 'payment released to admin')
		  {
		  
		     $buyer['info'] = Members::singlebuyerData($user_id);
			 $user_token = $buyer['info']->user_token;
			 $to_name = $buyer['info']->name;
			 $to_email = $buyer['info']->email;
			 $buyer_earning = $buyer['info']->earnings + $price;
			 $record = array('earnings' => $buyer_earning);
			 Members::updatepasswordData($user_token, $record);
			 
			$orderdata = array('approval_status' => 'payment released to customer');
			$refundata = array('ref_refund_approval' => 'accepted');
			Product::singleorderupData($order,$orderdata);
			Product::refundupData($refund_id,$refundata);
			Product::deleteRating($ord_id);
			
			
			 $vendor['info'] = Members::singlevendorData($item_user_id);
			 $vendor_token = $vendor['info']->user_token;
			 $to_name = $vendor['info']->name;
			 $to_email = $vendor['info']->email;
			 $vendor_earning = $vendor['info']->earnings - $price;
			 $record_vendor = array('earnings' => $vendor_earning);
			 Members::updatevendorRecord($vendor_token, $record_vendor);
			 			
			$sid = 1;
			$setting['setting'] = Settings::editGeneral($sid);
			$admin_name = $setting['setting']->sender_name;
			$admin_email = $setting['setting']->sender_email;
			$currency = $setting['setting']->site_currency_symbol;
			$data = array('to_name' => $to_name, 'to_email' => $to_email, 'price' => $price, 'currency' => $currency);
			/* email template code */
	          $checktemp = EmailTemplate::checkTemplate(13);
			  if($checktemp != 0)
			  {
			  $template_view['mind'] = EmailTemplate::viewTemplate(13);
			  $template_subject = $template_view['mind']->et_subject;
			  }
			  else
			  {
			  $template_subject = "Payment Refund Accepted";
			  }
			  /* email template code */
			Mail::send('admin.buyer_refund_mail', $data , function($message) use ($admin_name, $admin_email, $to_name, $to_email, $template_subject) {
					$message->to($to_email, $to_name)
							->subject($template_subject);
					$message->from($admin_email,$admin_name);
				});
				
				
			
			return redirect()->back()->with('success','Payment released to customer'); 
		
		  
		  
		    
		  }
	  
	  
	  
	  }
	  if($user_type == "admin")
	  {
	         
			 $buyer['info'] = Members::singlebuyerData($user_id);
			 $user_token = $buyer['info']->user_token;
			 $to_name = $buyer['info']->name;
			 $to_email = $buyer['info']->email;
			 $sid = 1;
			$setting['setting'] = Settings::editGeneral($sid);
			$admin_name = $setting['setting']->sender_name;
			$admin_email = $setting['setting']->sender_email;
			$currency = $setting['setting']->site_currency_symbol;
			$refundata = array('ref_refund_approval' => 'declined');
			 Product::refundupData($refund_id,$refundata);
			$data = array('to_name' => $to_name, 'to_email' => $to_email, 'price' => $price, 'currency' => $currency);
			/* email template code */
	          $checktemp = EmailTemplate::checkTemplate(11);
			  if($checktemp != 0)
			  {
			  $template_view['mind'] = EmailTemplate::viewTemplate(11);
			  $template_subject = $template_view['mind']->et_subject;
			  }
			  else
			  {
			  $template_subject = "Payment Refund Declined";
			  }
			  /* email template code */
			Mail::send('admin.buyer_declined_mail', $data , function($message) use ($admin_name, $admin_email, $to_name, $to_email, $template_subject) {
					$message->to($to_email, $to_name)
							->subject($template_subject);
					$message->from($admin_email,$admin_name);
				});
			 
			  
	         
		    return redirect()->back()->with('success','Refund request is declined');
	  
	  } 
	  
	  
	  
	  
	
	
	}
	
	
	
	
	/* admin refund */
	
	/* admin reports */
	
	public function view_report()
	{
	   $itemData['item'] = Product::getreports();
	   $data = array('itemData' => $itemData);
	   if($this->custom() != 0)
	   { 
	   return view('admin.reports')->with($data);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	/* admin reports */
	
	
	/* admin rating */
	
	public function save_reviews(Request $request)
	{
	
	 $or_product_id = $request->input('or_product_id');
	 $or_product_token = $request->input('or_product_token');
	 $or_product_user_id = $request->input('or_product_user_id');
	 
	 
	        
	 $or_username = $request->input('or_username');
	 $rating = $request->input('rating');
	 $rating_comment = $request->input('rating_comment');
	 $rating_reason = $request->input('rating_reason');
         $rating_date = date('Y-m-d H:i:s');
		 $request->validate([
		                    
							
							
							
         ]);
		 $rules = array(
				
				
	     );
		 
		 $messsages = array(
		      
	    );
		 
		$validator = Validator::make($request->all(), $rules,$messsages);
		
		if ($validator->fails()) 
		{
		 $failedRules = $validator->failed();
		 return back()->withErrors($validator);
		} 
		else
		{
		
		$updata = array('or_username' => $or_username, 'rating' => $rating, 'rating_reason' => $rating_reason, 'rating_comment' => $rating_comment, 'rating_date' => $rating_date, 'or_product_id' => $or_product_id, 'or_product_token' => $or_product_token, 'or_product_user_id' => $or_product_user_id); 
		Product::saveRatings($updata);
        return redirect('/admin/reviews/'.$or_product_token)->with('success', 'Insert successfully.');
            
 
       } 
	 
	 
	 
       
	
	
	}
	
	
	public function selected_rating($product_token)
	{
	   $itemData['item'] = Product::getratingSingle($product_token);
	   $product_details = Product::solditemData($product_token);
	   $data = array('itemData' => $itemData, 'product_details' => $product_details);
	   if($this->custom() != 0)
	   { 
	   return view('admin.reviews')->with($data);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	public function add_rating($product_token)
	{
	   
	   $product_details = Product::solditemData($product_token);
	   $data = array('product_details' => $product_details);
	   if($this->custom() != 0)
	   { 
	   return view('admin.add-reviews')->with($data);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	public function view_rating()
	{
	   $itemData['item'] = Product::getratingItem();
	   $data = array('itemData' => $itemData);
	   if($this->custom() != 0)
	   {
	   return view('admin.rating')->with($data);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	public function edit_rating($rating_id)
	{
	   $rating = Product::singleratingItem($rating_id);
	   $product_details = Product::solditemData($rating->or_product_token);
	   $data = array('rating' => $rating, 'product_details' => $product_details);
	   if($this->custom() != 0)
	   {
	   return view('admin.edit-reviews')->with($data);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	
	public function rating_delete($rating_id)
	{
	   Product::dropRating($rating_id);
	   return redirect()->back()->with('success','Item rating has been removed'); 
	 
	}
	
	/* admin rating */
	
	/* admin report */
	
	public function report_delete($report_id)
	{
	   Product::dropReport($report_id);
	   return redirect()->back()->with('success','Report has been removed'); 
	 
	}
	
	/* admin report */
	
	/* admin withdrawal */
	
	public function view_withdrawal()
	{
	  $itemData['item'] = Product::getwithdrawalData();
	   $data = array('itemData' => $itemData);
	   if($this->custom() != 0)
	   {
	   return view('admin.withdrawal')->with($data);
	   }
	   else
	   {
		  return redirect('/admin/license');
	   }
	}
	
	
	public function view_withdrawal_update($wd_id,$user_id)
	{
	         $drawal_data = array('wd_status' => 'paid');
			 Product::updatedrawalData($wd_id,$user_id,$drawal_data);
			 
	         $buyer['info'] = Members::singlebuyerData($user_id);
			 $user_token = $buyer['info']->user_token;
			 $to_name = $buyer['info']->name;
			 $to_email = $buyer['info']->email;
			 $sid = 1;
			$setting['setting'] = Settings::editGeneral($sid);
			$admin_name = $setting['setting']->sender_name;
			$admin_email = $setting['setting']->sender_email;
			$currency = $setting['setting']->site_currency_symbol;
			$with['data'] = Product::singledrawalData($wd_id);
			$wd_amount = $with['data']->wd_amount;
			
			$data = array('to_name' => $to_name, 'to_email' => $to_email, 'wd_amount' => $wd_amount, 'currency' => $currency);
			/* email template code */
	          $checktemp = EmailTemplate::checkTemplate(17);
			  if($checktemp != 0)
			  {
			  $template_view['mind'] = EmailTemplate::viewTemplate(17);
			  $template_subject = $template_view['mind']->et_subject;
			  }
			  else
			  {
			  $template_subject = "Payment Withdrawal Request Accepted";
			  }
			  /* email template code */
			Mail::send('admin.user_withdrawal_mail', $data , function($message) use ($admin_name, $admin_email, $to_name, $to_email, $template_subject) {
					$message->to($to_email, $to_name)
							->subject($template_subject);
					$message->from($admin_email,$admin_name);
				});
	   return redirect()->back()->with('success','Payment withdrawal request has been completed'); 			
	   
	}
	/* admin withdrawal */
	
	
	public function file_download($token)
	{
	    
		        $allsettings = Settings::allSettings();
				$item['data'] = Product::solditemData($token);
				$tempsplit= explode('.',$item['data']->product_file);
				$extension = end($tempsplit);
				/* wasabi */
			   $wasabi_access_key_id = $allsettings->wasabi_access_key_id;
			   $wasabi_secret_access_key = $allsettings->wasabi_secret_access_key;
			   $wasabi_default_region = $allsettings->wasabi_default_region;
			   $wasabi_bucket = $allsettings->wasabi_bucket;
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
				
				if($allsettings->site_s3_storage == 1)
				{
						$result = $s3->getObject(['Bucket' => $wasabi_bucket,'Key' => $item['data']->product_file]);
	                    $myFile = $result["@metadata"]["effectiveUri"];
						$newName = uniqid().time().'.'.$extension;
						header("Cache-Control: public");
						header("Content-Description: File Transfer");
						header("Content-Disposition: attachment; filename=" . basename($newName));
						header("Content-Type: application/octet-stream");
						return readfile($myFile);
						
				}
				else if($allsettings->site_s3_storage == 2)
				{
						$myFile = Storage::disk('dropbox')->url($item['data']->product_file);
						$newName = uniqid().time().'.zip';
						header("Cache-Control: public");
						header("Content-Description: File Transfer");
						header("Content-Disposition: attachment; filename=" . basename($newName));
						header("Content-Type: application/octet-stream");
						return readfile($myFile);
				}
				else if($allsettings->site_s3_storage == 3)
				{
						$filename = $item['data']->product_file;
					    $dir = '/';
					    $recursive = false; 
					    $contents = collect(Storage::disk('google')->listContents($dir, $recursive));
					    $file = $contents
					    ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
					    ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
					    ->first(); 
					    $display_product_file = Storage::disk('google')->download($file['path']);
			            return $display_product_file;
			    }
				else if($allsettings->site_s3_storage == 4)
				{
				        $myFile = Storage::disk('s3')->url($item['data']->product_file);
						$newName = uniqid().time().'.'.$extension;
						header("Cache-Control: public");
						header("Content-Description: File Transfer");
						header("Content-Disposition: attachment; filename=" . basename($newName));
						header("Content-Type: application/octet-stream");
						return readfile($myFile);
				   
				}			
				else
				{
						$filename = public_path().'/storage/product/'.$item['data']->product_file;
						$headers = ['Content-Type: application/octet-stream'];
						$new_name = uniqid().time().'.zip';
						return response()->download($filename,$new_name,$headers);
				}
			 
				
				
	}
	
	
	/* tickets */
	public function view_tickets()
	{
	  
	  $tickets = Product::allticketData();
	  $data = array('tickets' => $tickets);
	  
	  return view('admin.tickets')->with($data);
	}
	
	
	public function delete_tickets($token)
	{
	    $image1 = DB::table('tickets')->where('ticket_token', '=', $token)->first();
		$file1= $image1->ticket_file;
		$filename1 = public_path().'/storage/ticket/'.$file1;
		File::delete($filename1);	
		$image2 = DB::table('tickets_reply')->where('tickets_token', '=', $token)->first();
		$file2 = $image2->tickets_file;
		$filename2 = public_path().'/storage/ticket/'.$file2;
		File::delete($filename2);
	    Product::deleteTicket($token);
		return redirect()->back()->with('success','Delete successfully.');
	
	}
	
	public function all_delete_tickets(Request $request)
	{
	   
	   $tid = $request->input('tid');
	   foreach($tid as $token)
	   {
	      $image1 = DB::table('tickets')->where('ticket_token', '=', $token)->first();
		  $file1= $image1->ticket_file;
		  $filename1 = public_path().'/storage/ticket/'.$file1;
		  File::delete($filename1);	
		  $image2 = DB::table('tickets_reply')->where('tickets_token', '=', $token)->first();
		  $file2 = $image2->tickets_file;
		  $filename2 = public_path().'/storage/ticket/'.$file2;
		  File::delete($filename2);
	      Product::deleteTicket($token);
	   }
	   return redirect()->back()->with('success','Delete successfully.');
	
	}
	
	public function new_ticket()
	{
	  
	  
	  return view('new-ticket');
	}
	
	public function display_ticket($ticket)
	{
	  $single_ticket = Product::singleticketData($ticket);
	  $reply_ticket =  Product::getreplyticketAdmin($ticket);
	  $data = array('ticket' => $ticket, 'single_ticket' => $single_ticket, 'reply_ticket' => $reply_ticket);
	  
	  return view('admin.ticket')->with($data);
	}
	
	public function save_ticket(Request $request)
	{
	   $ticket_token = rand(111111,999999);
	   $ticket_user_token = $request->input('ticket_user_token');
	   $ticket_subject = $request->input('ticket_subject');
	   $ticket_message = $request->input('ticket_message');
	   $ticket_status = 'open';
	   $ticket_priority = $request->input('ticket_priority');
	   $ticket_date_time = date('Y-m-d H:i:s');
	   $image_size = $request->input('image_size');
	   
	   
	   $request->validate([
							'ticket_subject' => 'required',
							'ticket_message' => 'required',
							'ticket_file' => 'mimes:jpeg,jpg,png,pdf|max:'.$image_size,
							
         ]);
		 $rules = array(
				
				
	     );
		 
		 $messsages = array(
		      
	    );
		 
		$validator = Validator::make($request->all(), $rules,$messsages);
		
		if ($validator->fails()) 
		{
		 $failedRules = $validator->failed();
		 return back()->withErrors($validator);
		} 
		else
		{
	   
	   
	     if ($request->hasFile('ticket_file')) {
		     
			$image = $request->file('ticket_file');
			$img_name = time() . '.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/storage/ticket');
			$imagePath = $destinationPath. "/".  $img_name;
			$image->move($destinationPath, $img_name);
			$ticket_file = $img_name;
		  }
		  else
		  {
		     $ticket_file = "";
		  }
	   
	   $tickdata = array('ticket_token' => $ticket_token, 'ticket_user_token' => $ticket_user_token, 'ticket_subject' => $ticket_subject, 'ticket_message' => $ticket_message, 'ticket_file' => $ticket_file, 'ticket_status' => $ticket_status, 'ticket_priority' => $ticket_priority, 'ticket_date_time' => $ticket_date_time);
	  
	     Product::saveticket($tickdata);
		 
		 
		    $sid = 1;
			$setting['setting'] = Settings::editGeneral($sid);
			$to_name = $setting['setting']->sender_name;
			$to_email = $setting['setting']->sender_email;
			$from['info'] = Members::editData($ticket_user_token);
			$from_name = $from['info']->name;
			$from_email = $from['info']->email;
			$data = array('to_name' => $to_name, 'to_email' => $to_email, 'from_name' => $from_name, 'from_email' => $from_email, 'ticket_token' => $ticket_token, 'ticket_subject' => $ticket_subject, 'ticket_priority' => $ticket_priority, 'ticket_message' => $ticket_message);
			/* email template code */
							$checktemp = EmailTemplate::checkTemplate(26);
							if($checktemp != 0)
							{
								$template_view['mind'] = EmailTemplate::viewTemplate(26);
								$template_subject = $template_view['mind']->et_subject;
							}
							else
							{
								$template_subject = "New Ticket Received";
							}
							/* email template code */
							Mail::send('new_ticket_mail', $data , function($message) use ($from_name, $from_email, $to_name, $to_email, $ticket_token, $ticket_subject, $ticket_priority, $ticket_message, $template_subject) {
									$message->to($to_email, $to_name)
											->subject($template_subject);
									$message->from($from_email,$from_name);
								});
		
		 return redirect('my-tickets')->with('success', 'Your ticket has been sent');
	   }
	   
	   
	   
	   
	}
	
	public function download_ticket_file($token,$files)
	{
	
	    $encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
	    $filed   = $encrypter->decrypt($files);
		$filename = public_path().'/storage/ticket/'.$filed;
		return response()->download($filename);
	    
	}
	
	
	public function close_ticket($token)
	{
	  $data = array('ticket_status' => 'close');
	  Product::updateTicket($token,$data);
	  return redirect('admin/tickets')->with('success', '#'.$token.' Ticket has been closed');
	}
	
	
	public function reply_ticket(Request $request)
	{
	   $tickets_token = $request->input('tickets_token');
	   $tickets_user_token = $request->input('tickets_user_token');
	   $tickets_message = $request->input('tickets_message');
	   $ticket_status = 'admin replied';
	   $tickets_date_time = date('Y-m-d H:i:s');
	   $image_size = $request->input('image_size');
	   
	   
	   $request->validate([
							
							'tickets_message' => 'required',
							'tickets_file' => 'mimes:jpeg,jpg,png,pdf|max:'.$image_size,
							
         ]);
		 $rules = array(
				
				
	     );
		 
		 $messsages = array(
		      
	    );
		 
		$validator = Validator::make($request->all(), $rules,$messsages);
		
		if ($validator->fails()) 
		{
		 $failedRules = $validator->failed();
		 return back()->withErrors($validator);
		} 
		else
		{
	   
	   
	     if ($request->hasFile('tickets_file')) {
		     
			$image = $request->file('tickets_file');
			$img_name = time() . '.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/storage/ticket');
			$imagePath = $destinationPath. "/".  $img_name;
			$image->move($destinationPath, $img_name);
			$tickets_file = $img_name;
		  }
		  else
		  {
		     $tickets_file = "";
		  }
	   
	   $tickdata = array('tickets_token' => $tickets_token, 'tickets_user_token' => $tickets_user_token, 'tickets_message' => $tickets_message, 'tickets_file' => $tickets_file, 'tickets_date_time' => $tickets_date_time);
	  
	     Product::savereplyticket($tickdata);
		 $ticket_data = array('ticket_status' => $ticket_status);
		 Product::updateTicket($tickets_token,$ticket_data);
		 
		 
		    $sid = 1;
			$setting['setting'] = Settings::editGeneral($sid);
			$to_name = $setting['setting']->sender_name;
			$to_email = $setting['setting']->sender_email;
			$from['info'] = Members::editData($tickets_user_token);
			$from_name = $from['info']->name;
			$from_email = $from['info']->email;
			$data = array('to_name' => $to_name, 'to_email' => $to_email, 'from_name' => $from_name, 'from_email' => $from_email, 'tickets_token' => $tickets_token, 'tickets_message' => $tickets_message);
			/* email template code */
							$checktemp = EmailTemplate::checkTemplate(28);
							if($checktemp != 0)
							{
								$template_view['mind'] = EmailTemplate::viewTemplate(28);
								$template_subject = $template_view['mind']->et_subject;
							}
							else
							{
								$template_subject = "Ticket Replied By Admin";
							}
							/* email template code */
							Mail::send('ticket_replied_admin_mail', $data , function($message) use ($from_name, $from_email, $to_name, $to_email, $tickets_token, $tickets_message, $template_subject) {
									$message->to($from_email,$from_name)
											->subject($template_subject);
									$message->from($to_email,$to_name);
								});
		
		 return redirect('admin/ticket/'.$tickets_token)->with('success', 'Ticket reply message has been sent');
	   }
	   
	   
	   
	   
	}
	
	/* tickets */
	
	
	public function edit_withdrawal_methods($wm_id)
	{
	  $withdrawal_methods = Product::editWithMethod($wm_id); 
	 $data = array('withdrawal_methods' => $withdrawal_methods); 
	 if($this->custom() != 0)
	 {
	 return view('admin.edit-withdrawal-methods')->with($data);
	 }
	 else
	 {
		  return redirect('/admin/license');
	 }
	
	}
	
	public function withdrawal_methods()
	{
	  $withdrawal_methods = Product::getWithMethod(); 
	 $data = array('withdrawal_methods' => $withdrawal_methods);
	 if($this->custom() != 0)
	 { 
	 return view('admin.withdrawal-methods')->with($data);
	 }
	 else
	 {
		  return redirect('/admin/license');
	 }
	}
	
	public function add_withdrawal_methods()
	{
	 if($this->custom() != 0)
	 { 
	 return view('admin.add-withdrawal-methods');
	 }
	 else
	 {
		  return redirect('/admin/license');
	 }
	  
	}
	
	
	public function update_withdrawal_methods(Request $request)
	{
	
	     $withdrawal_name = $request->input('withdrawal_name');
		 
		 $withdrawal_order = $request->input('withdrawal_order');
		 $withdrawal_status = $request->input('withdrawal_status');
		 $wm_id = $request->input('wm_id');
		 
		 $request->validate([
							'withdrawal_name' => 'required',
							
							
         ]);
		 $rules = array(
		 
		        
				
				
	     );
		 
		 $messsages = array(
		      
	    );
		 
		$validator = Validator::make($request->all(), $rules,$messsages);
		
		if ($validator->fails()) 
		{
		 $failedRules = $validator->failed();
		 return back()->withErrors($validator);
		} 
		else
		{
		
		
		 
		$data = array('withdrawal_name' => $withdrawal_name, 'withdrawal_order' => $withdrawal_order, 'withdrawal_status' => $withdrawal_status);
       
        Product::updateWithMethod($wm_id, $data);
            
 
       } 
     
       return redirect('/admin/withdrawal-methods')->with('success', 'Update successfully.');
	
	}
	
	public function save_withdrawal_methods(Request $request)
	{
	   
	     $withdrawal_name = $request->input('withdrawal_name');
		 $withdrawal_key = $request->input('withdrawal_key');
		 $withdrawal_order = $request->input('withdrawal_order');
		 $withdrawal_status = $request->input('withdrawal_status');
		 $request->validate([
							'withdrawal_name' => 'required',
							'withdrawal_key' => 'required',
							
         ]);
		 $rules = array(
				'withdrawal_key' => ['required', 'max:255', Rule::unique('withdrawal_methods') -> where(function($sql){ $sql->where('wm_id','!=','');})],
				
	     );
		 
		 $messsages = array(
		      
	    );
		 
		$validator = Validator::make($request->all(), $rules,$messsages);
		
		if ($validator->fails()) 
		{
		 $failedRules = $validator->failed();
		 return back()->withErrors($validator);
		} 
		else
		{
		
		
		 
		$data = array('withdrawal_name' => $withdrawal_name, 'withdrawal_key' => $withdrawal_key, 'withdrawal_order' => $withdrawal_order, 'withdrawal_status' => $withdrawal_status);
        Product::saveWithMethod($data);
        
            
 
       } 
     
       return redirect('/admin/withdrawal-methods')->with('success', 'Insert successfully.');
	
	}
	
	
	
}
