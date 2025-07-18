<?php

namespace DownGrade\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use DownGrade\Models\Product;
use DownGrade\Models\Members;
use DownGrade\Models\Voucher;
use DownGrade\Models\Pages;
use DownGrade\Models\Settings;
use DownGrade\Models\EmailTemplate;
use Mail;
use Auth;
use PDF;
use Paystack;
use Razorpay\Api\Api;
use CoinGate\CoinGate;
use Cache;
use Storage;
use Currency;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use URL;
use Cashfree;
use UddoktaPay\LaravelSDK\UddoktaPay;
use UddoktaPay\LaravelSDK\Requests\CheckoutRequest;
use App\Helpers\AccountDeliveryHelper;




class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function download_file($token)
	{
	   $encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
	   $ord_token   = $encrypter->decrypt($token);
	   $allsettings = Settings::allSettings();
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
		$item['data'] = Product::solditemData($ord_token);
		$tempsplit= explode('.',$item['data']->product_file);
		$extension = end($tempsplit);
		if($item['data']->product_file_type == 'file')
		{
		   
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
				$filename = public_path().'/storage/product/'.basename($item['data']->product_file);
				$headers = ['Content-Type: application/octet-stream'];
				$new_name = uniqid().time().'.zip';
				return response()->download($filename,$new_name,$headers);
				}
		
		}
		else
		{
		   return redirect($item['data']->product_file_link);
		}
	}
	
	
	public function favourites_item()
	{
	   
	   $user_id = Auth::user()->id;
	   $fav['product'] = Product::with('ratings')->join('category', 'category.cat_id', '=', 'product.product_category_parent')->join('product_favorite','product_favorite.product_id','product.product_id')->where('product.product_status','=',1)->where('product_favorite.user_id','=',$user_id)->where('product.product_drop_status','=','no')->orderBy('product.product_views', 'desc')->get();
	   $data = array('fav' => $fav);
	   
	   return view('my-favourite')->with($data);
	}
	
	
	
	
	
	
	
	public function remove_favourites_item($favid,$itemid)
	{
	    $fav_id = base64_decode($favid);
		$item_id = base64_decode($itemid);
		Product::dropFavitem($fav_id);
		$get['item'] = Product::selecteditemData($item_id);
		$liked = $get['item']->product_liked - 1;
		$record = array('product_liked' => $liked);
		Product::updatefavouriteData($item_id,$record);
	    return redirect()->back()->with('success', 'Product removed to favorite');
	}
    
    	
	public function add_post_comment(Request $request)
	{
	    $comm_text = $request->input('comm_text');
		$comm_user_id = $request->input('comm_user_id');
		$comm_product_user_id = $request->input('comm_product_user_id');
		$comm_product_id = $request->input('comm_product_id');
		$product_url = $request->input('comm_product_url');
		
		$comm_date = date('Y-m-d H:i:s');
		$comment_data = array('comm_user_id' => $comm_user_id, 'comm_product_user_id' => $comm_product_user_id, 'comm_product_id' => $comm_product_id, 'comm_text' => $comm_text, 'comm_date' => $comm_date);
		Product::savecommentData($comment_data);
		$product_user_id = $comm_product_user_id;
		$user_id = $comm_user_id;
		$getvendor['user'] = Members::singlevendorData($product_user_id);
		$getbuyer['user'] = Members::singlebuyerData($user_id);
			
		$from_name = $getbuyer['user']->name;
		$from_email = $getbuyer['user']->email;
		
		$to_name = $getvendor['user']->name;
		$to_email = $getvendor['user']->email;
		
		$record = array('product_url' => $product_url, 'from_name' => $from_name, 'from_email' => $from_email, 'comm_text' => $comm_text);
		/* email template code */
	    $checktemp = EmailTemplate::checkTemplate(2);
		if($checktemp != 0)
		{
			$template_view['mind'] = EmailTemplate::viewTemplate(2);
			$template_subject = $template_view['mind']->et_subject;
		}
		else
		{
			$template_subject = "New Comment Received";
		}
		/* email template code */
		Mail::send('comment_mail', $record, function($message) use ($from_email, $from_name, $to_name, $to_email, $template_subject) {
				$message->to($to_email, $to_name)
						->subject($template_subject);
				$message->from($from_email,$from_name);
			});
			
		return redirect()->back()->with('success', 'Your comment has been sent successfully');
		
		
	}
	
	
	public function view_favorite_item($itemid,$favorite,$liked)
	{  
	   $product_id = base64_decode($itemid);
	   $like = base64_decode($liked) + 1;
	   $log_user = Auth::user()->id;
	   $getcount  = Product::getfavouriteCount($product_id,$log_user);
	   if($getcount == 0)
	   {
	      $data = array ('product_id' => $product_id, 'user_id' => $log_user);
		  Product::savefavouriteData($data);
		  $record = array('product_liked' => $like);
		  Product::updatefavouriteData($product_id,$record);
		  return redirect()->back()->with('success', 'Product added to favorite');
		  
	   }
	   else
	   {
	     return redirect()->back()->with('error', 'Sorry Product already added to favorite');
	   }
	  
	
	}
	
	
	public function reply_post_comment(Request $request)
	{
	    $comm_text = $request->input('comm_text');
		$comm_user_id = $request->input('comm_user_id');
		$comm_product_user_id = $request->input('comm_product_user_id');
		$comm_product_id = $request->input('comm_product_id');
		$comm_id = $request->input('comm_id');
		$product_url = $request->input('comm_product_url');
		$comm_date = date('Y-m-d H:i:s');
		$comment_data = array('comm_user_id' => $comm_user_id, 'comm_product_user_id' => $comm_product_user_id, 'comm_product_id' => $comm_product_id, 'comm_id' => $comm_id, 'comm_text' => $comm_text, 'comm_date' => $comm_date);
		Product::replycommentData($comment_data);
		
		$product_user_id = $comm_product_user_id;
		$user_id = $comm_user_id;
		$getvendor['user'] = Members::singlevendorData($product_user_id);
		$getbuyer['user'] = Members::singlebuyerData($user_id);
		
		$to_name = $getbuyer['user']->name;
		$to_email = $getbuyer['user']->email;
		
		$from_name = $getvendor['user']->name;
		$from_email = $getvendor['user']->email;
		
		$record = array('product_url' => $product_url, 'from_name' => $from_name, 'from_email' => $from_email, 'comm_text' => $comm_text);
		/* email template code */
	    $checktemp = EmailTemplate::checkTemplate(2);
		if($checktemp != 0)
		{
			$template_view['mind'] = EmailTemplate::viewTemplate(2);
			$template_subject = $template_view['mind']->et_subject;
		}
		else
		{
			$template_subject = "New Comment Received";
		}
		/* email template code */
		Mail::send('comment_mail', $record, function($message) use ($from_email, $from_name, $to_name, $to_email, $template_subject) {
				$message->to($to_email, $to_name)
						->subject($template_subject);
				$message->from($from_email,$from_name);
			});
		
		return redirect()->back()->with('success', 'Your comment has been sent successfully');
		
	}
	
	
	
	
	public function contact_support(Request $request)
	{
	   $support_subject = $request->input('support_subject');
	   $support_msg = $request->input('support_msg');
	   $to_email = $request->input('to_address');
	   $from_email = $request->input('from_address');
	   $to_name = $request->input('to_name');
	   $from_name = $request->input('from_name');
	   $product_url = $request->input('product_url');
	   
	    $sid = 1;
		$setting['setting'] = Settings::editGeneral($sid);
		
		$admin_name = $setting['setting']->sender_name;
        $admin_email = $setting['setting']->sender_email;
		
		$record = array('to_name' => $to_name, 'from_name' => $from_name, 'from_email' => $from_email, 'product_url' => $product_url, 'support_msg' => $support_msg, 'support_subject' => $support_subject);
		/* email template code */
	          	$checktemp = EmailTemplate::checkTemplate(10);
			  	if($checktemp != 0)
			  	{
			  	$template_view['mind'] = EmailTemplate::viewTemplate(10);
			  	$template_subject = $template_view['mind']->et_subject;
			  	}
			  	else
			  	{
			  	$template_subject = "Contact Support";
			  	}
			  	/* email template code */
		Mail::send('support_mail', $record, function($message) use ($admin_name, $admin_email, $to_email, $from_email, $to_name, $from_name, $template_subject) {
			$message->to($admin_email, $admin_name)
					->subject($template_subject);
			$message->from($from_email,$from_name);
		});
		
		
		Mail::send('support_mail', $record, function($message) use ($admin_name, $admin_email, $to_email, $from_email, $to_name, $from_name, $template_subject) {
			$message->to($to_email, $to_name)
					->subject($template_subject);
			$message->from($from_email,$from_name);
		});
	   
	  return redirect()->back()->with('success', 'Thank You! Your message sent successfully'); 
	  
	
	}
	
	
	
	/* checkout */
	
	
	
	public function redirectToGateway()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }
	
	public function razorpay_payment(Request $request)
    {
	    $sid = 1;
	    $setting['setting'] = Settings::editGeneral($sid);
		$custom_settings = Settings::editCustom();
        $input = $request->all();

        $api = new Api($setting['setting']->razorpay_key, $setting['setting']->razorpay_secret);

        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        
        $user_id = Auth::user()->id;

        //dd($paymentDetails);
         //print_r($paymentDetails);
		if(count($input)  && !empty($input['razorpay_payment_id'])) 
		{
		
		 $payment_token = $input['razorpay_payment_id'];
		 $purchased_token = $payment->description;
		 /*$final_amount = $payment->amount / 100;*/
					$payment_status = 'completed';
					$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
					$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
					Product::singleordupdateData($purchased_token,$orderdata);
					Product::singlecheckoutData($purchased_token,$checkoutdata);
					
					$token = $purchased_token;
					$check['display'] = Product::getcheckoutData($token);
					$order_id = $check['display']->order_ids;
					\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
		             
					 
					 $sid = 1;
					$setting['setting'] = Settings::editGeneral($sid);
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
						$logged_id = Auth::user()->id;
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
					
					$data_record = array('payment_token' => $payment_token);
					return view('success')->with($data_record);
					
		
		
	    } 
		else
		{
		  return redirect('/cancel');
		}
		
		
           /* try 
			{
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 

            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }*/
        
        
        
    }
	
	
	public function handleGatewayCallback()
    {   
	    $custom_settings = Settings::editCustom();
        $paymentDetails = Paystack::getPaymentData();
		$user_id = Auth::user()->id;

        //dd($paymentDetails);
         //print_r($paymentDetails);
		if (array_key_exists('data', $paymentDetails) && array_key_exists('status', $paymentDetails['data']) && ($paymentDetails['data']['status'] === 'success')) 
		{
		
		 $payment_token = $paymentDetails['data']['reference'];
		 $purchased_token = $paymentDetails['data']['metadata'];
		 /*$final_amount = $paymentDetails['data']['amount'] / 100;*/
					$payment_status = 'completed';
					$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
					$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
					Product::singleordupdateData($purchased_token,$orderdata);
					Product::singlecheckoutData($purchased_token,$checkoutdata);
					
					$token = $purchased_token;
					$check['display'] = Product::getcheckoutData($token);
					$order_id = $check['display']->order_ids;
					\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
		             
					 
					 $sid = 1;
					$setting['setting'] = Settings::editGeneral($sid);
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
						$logged_id = Auth::user()->id;
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
					$data_record = array('payment_token' => $payment_token);
					return view('success')->with($data_record);
					
		
		
	    } 
		else
		{
		  return redirect('/cancel');
		}
		
    }	
	public function coingate_success()
	{
	   $custom_settings = Settings::editCustom();
	   $ord_token = Cache::get('coingate_id');
	
	   $sid = 1;
	   $setting['setting'] = Settings::editGeneral($sid);
	   $coingate_mode = $setting['setting']->coingate_mode;
	   if($coingate_mode == 0)
	   {
	      $coingate_mode_status = "sandbox";
	   }
	   else
	   {
	      $coingate_mode_status = "live";
	   }
	   $coingate_auth_token = $setting['setting']->coingate_auth_token;
	   \CoinGate\CoinGate::config(array(
					'environment'               => $coingate_mode_status, // sandbox OR live
					'auth_token'                => $coingate_auth_token,
					'curlopt_ssl_verifypeer'    => TRUE // default is false
					 ));
	   try 
	   {
         $order = \CoinGate\Merchant\Order::find($ord_token);
     
		if ($order) 
		{
		  //echo $order->status;
		 /*var_dump($order); 
		 echo $order->status;
		 echo $order->id;
		 echo $order->order_id;
		 echo $order->payment_address;*/
		 if($order->status == 'paid')
		 {
		    $payment_token = $order->payment_address;
			$payment_status = 'completed';
			$purchased_token = $order->order_id;
			$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
			$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
			Product::singleordupdateData($purchased_token,$orderdata);
			Product::singlecheckoutData($purchased_token,$checkoutdata);
			
			$token = $purchased_token;
			$check['display'] = Product::getcheckoutData($token);
			$order_id = $check['display']->order_ids;
			\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
			
			$checkout['details'] = Product::getcheckoutData($purchased_token);
			$final_amount = $checkout['details']->total;
			$user_id = $checkout['details']->user_id;
			$admin['info'] = Members::adminData();
			$admin_token = $admin['info']->user_token;
			$admin_earning = $admin['info']->earnings + $final_amount;
			$admin_record = array('earnings' => $admin_earning);
			Members::updateadminData($admin_token, $admin_record);
			
							 
			$sid = 1;
			$setting['setting'] = Settings::editGeneral($sid);
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
				$logged_id = Auth::user()->id;
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
			$result_data = array('payment_token' => $payment_token);
			return view('success')->with($result_data);
			}
			else
			{	  
		       return redirect('/cancel');
			} 
		 
		}
		else 
		{
		  echo 'Order not found';
		}
	} catch (Exception $e) {
		  echo $e->getMessage(); // BadCredentials Not found App by Access-Key
		}
	}
	
	
	public function cashfree_success(Request $request)
	{
	
	
	$custom_settings = Settings::editCustom();
	$cashfree_api_key = $custom_settings->cashfree_api_key;
	$cashfree_api_secret = $custom_settings->cashfree_api_secret;
	$cashfree_mode = $custom_settings->cashfree_mode;
	\Cashfree\Cashfree::$XClientId = $cashfree_api_key;
	\Cashfree\Cashfree::$XClientSecret = $cashfree_api_secret;
	if($cashfree_mode == 0)
	{
	\Cashfree\Cashfree::$XEnvironment = Cashfree\Cashfree::$SANDBOX; //$SANDBOX $PRODUCTION
	}
	else
	{
	\Cashfree\Cashfree::$XEnvironment = Cashfree\Cashfree::$PRODUCTION;
	}
	$cashfree = new \Cashfree\Cashfree();
	$x_api_version = "2023-08-01";
	try {
		$response = $cashfree->PGFetchOrder($x_api_version, $request->get('order_id'));
		$pieces = explode("_", $request->get('order_id'));
		$purchased_token = $pieces[1];
		$payment_token = '';
		if($response[0]['order_status'] == 'PAID')
	    {
			$payment_status = 'completed';
			$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
			$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
			Product::singleordupdateData($purchased_token,$orderdata);
			Product::singlecheckoutData($purchased_token,$checkoutdata);
			
			$token = $purchased_token;
			$check['display'] = Product::getcheckoutData($token);
			$order_id = $check['display']->order_ids;
			\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
			$order_loop = explode(',',$order_id);
			
			$download_file = "";
			
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
				
				$encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
				$download_file .= URL::to('/download-file').'/'.$encrypter->encrypt($item['display']->product_token).'<br/><br/>';
				
				
			}
			
			$checkout['details'] = Product::getcheckoutData($purchased_token);
			$final_amount = $checkout['details']->total;
			$user_id = $checkout['details']->user_id;
			$admin['info'] = Members::adminData();
			$admin_token = $admin['info']->user_token;
			$admin_earning = $admin['info']->earnings + $final_amount;
			$admin_record = array('earnings' => $admin_earning);
			Members::updateadminData($admin_token, $admin_record);
			
							 
			$sid = 1;
			$setting['setting'] = Settings::editGeneral($sid);
			$to_name = $setting['setting']->sender_name;
			$to_email = $setting['setting']->sender_email;
			$currency = $setting['setting']->site_currency_code;
			$from['info'] = Members::singlevendorData($user_id);
			$from_name = $from['info']->name;
			$from_email = $from['info']->email;
			$data = array('to_name' => $to_name, 'to_email' => $to_email, 'final_amount' => $final_amount, 'currency' => $currency, 'from_name' => $from_name, 'from_email' => $from_email, 'purchased_token' => $purchased_token, 'download_file' => $download_file);
			
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
							 
			
			if($custom_settings->affiliate_referral == 1)
			{
				$logged_id = Auth::user()->id;
				$buyer_details = Members::singlebuyerData($logged_id);
				$referral_by = $buyer_details->referral_by;
				
				if($custom_settings->per_sale_referral_commission_type == 'fixed')
				{
				$per_sale_commission = $setting['setting']->per_sale_referral_commission;
				}
				else
				{
				$per_sale_commission = ($setting['setting']->per_sale_referral_commission * $final_amount) / 100;
				}
				$referral_commission = $per_sale_commission;
				
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
			$result_data = array('payment_token' => $payment_token);
			return view('success')->with($result_data);
	    }
		else
		{
		   return view('cancel');
		}
		
		
	} catch (Exception $e) {
		echo 'Exception when calling PGFetchOrder: ', $e->getMessage(), PHP_EOL;
	}
	
	
	
	/*$client = new \GuzzleHttp\Client();
    $response = $client->request('GET', $url.'/'.$request->get('order_id'). '/settlements',
	
	  [ 'headers' => [ 
	  
	  'accept' => 'application/json', 
	  'x-api-version' => '2022-01-01',
      "x-client-id" => $custom_settings->cashfree_api_key,
      "x-client-secret" => $custom_settings->cashfree_api_secret

     ],

    ]);
    $data = json_decode($response->getBody());


     $clients = new \GuzzleHttp\Client();
    $response_new = $clients->request('GET', $url.'/'.$data->order_id. '/payments/'.$data->cf_payment_id,
	
	  [ 'headers' => [ 
	  
	  'accept' => 'application/json', 
	  'x-api-version' => '2022-01-01',
      "x-client-id" => $custom_settings->cashfree_api_key,
      "x-client-secret" => $custom_settings->cashfree_api_secret

     ],

    ]);
	
	$record = json_decode($response_new->getBody());
	$status = $record->payment_status;
	$order_id = $record->order_id;
	$pieces = explode("_", $order_id);
	$purchased_token = $pieces[1];
	$payment_token = $record->cf_payment_id;
	*/
	
			
			
	}

    
	/* uddoktapay */

	public function uddoktapay_success($ordtoken, Request $request)
	{
	
	$custom_settings = Settings::editCustom();
	$uddoktapay_api_key = $custom_settings->uddoktapay_api_key;
	$uddoktapay_api_url = $custom_settings->uddoktapay_api_url;
	$uddoktapay = UddoktaPay::make($uddoktapay_api_key, $uddoktapay_api_url);
	
	try {
    $response = $uddoktapay->verify($request);

    if ($response->success()) 
	{
	
	    $myarray = $response->toArray(); 
	   
	    if($myarray['status'] == 'COMPLETED')
		{
		$encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
		$ord_token   = $encrypter->decrypt($ordtoken);
		$payment_token = $myarray['transaction_id'];
		$payment_status = 'completed';
		$purchased_token = $ord_token;
		$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
		$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
		Product::singleordupdateData($purchased_token,$orderdata);
		Product::singlecheckoutData($purchased_token,$checkoutdata);
		
		$token = $purchased_token;
		$check['display'] = Product::getcheckoutData($token);
		$order_id = $check['display']->order_ids;
		\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
		
		$checkout['details'] = Product::getcheckoutData($purchased_token);
		$final_amount = $checkout['details']->total;
		$user_id = $checkout['details']->user_id;
		$admin['info'] = Members::adminData();
		$admin_token = $admin['info']->user_token;
		$admin_earning = $admin['info']->earnings + $final_amount;
		$admin_record = array('earnings' => $admin_earning);
		Members::updateadminData($admin_token, $admin_record);
		
						 
		$sid = 1;
		$setting['setting'] = Settings::editGeneral($sid);
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
			$logged_id = Auth::user()->id;
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
		$result_data = array('payment_token' => $payment_token);
		return view('success')->with($result_data);
		}
		else
		{
		    return view('cancel');
		}
		
	} 
	elseif ($response->pending()) 
	{
			// Handle pending status
	} 
	elseif ($response->failed()) 
	{
			// Handle failure
	}
	} 
	catch (\UddoktaPay\LaravelSDK\Exceptions\UddoktaPayException $e) 
	{
			dd("Verification Error: " . $e->getMessage());
	}
	
	}
	
	/* uddoktapay */

	
	/* nowpayments */
	
	public function nowpayments_success($ordtoken, Request $request)
	{
	$custom_settings = Settings::editCustom();
	$encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
	$ord_token   = $encrypter->decrypt($ordtoken);
	$payment_token = '';
	$payment_status = 'completed';
	$purchased_token = $ord_token;
	$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
	$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
	Product::singleordupdateData($purchased_token,$orderdata);
	Product::singlecheckoutData($purchased_token,$checkoutdata);
	
	$token = $purchased_token;
	$check['display'] = Product::getcheckoutData($token);
	$order_id = $check['display']->order_ids;
	\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
	
	$checkout['details'] = Product::getcheckoutData($purchased_token);
	$final_amount = $checkout['details']->total;
	$user_id = $checkout['details']->user_id;
	$admin['info'] = Members::adminData();
	$admin_token = $admin['info']->user_token;
	$admin_earning = $admin['info']->earnings + $final_amount;
	$admin_record = array('earnings' => $admin_earning);
	Members::updateadminData($admin_token, $admin_record);
	
					 
	$sid = 1;
	$setting['setting'] = Settings::editGeneral($sid);
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
		$logged_id = Auth::user()->id;
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
	$result_data = array('payment_token' => $payment_token);
	return view('success')->with($result_data);
	
	}


    /* nowpayments */
	
	
	
	public function coinbase_success($ordtoken, Request $request)
	{
	$custom_settings = Settings::editCustom();
	$encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
	$ord_token   = $encrypter->decrypt($ordtoken);
	$payment_token = '';
	$payment_status = 'completed';
	$purchased_token = $ord_token;
	$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
	$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
	Product::singleordupdateData($purchased_token,$orderdata);
	Product::singlecheckoutData($purchased_token,$checkoutdata);
	
	$token = $purchased_token;
	$check['display'] = Product::getcheckoutData($token);
	$order_id = $check['display']->order_ids;
	\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
	
	$checkout['details'] = Product::getcheckoutData($purchased_token);
	$final_amount = $checkout['details']->total;
	$user_id = $checkout['details']->user_id;
	$admin['info'] = Members::adminData();
	$admin_token = $admin['info']->user_token;
	$admin_earning = $admin['info']->earnings + $final_amount;
	$admin_record = array('earnings' => $admin_earning);
	Members::updateadminData($admin_token, $admin_record);
	
					 
	$sid = 1;
	$setting['setting'] = Settings::editGeneral($sid);
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
		$logged_id = Auth::user()->id;
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
	$result_data = array('payment_token' => $payment_token);
	return view('success')->with($result_data);
	
	}

	
	
	
	
	
	public function coinpayments_success($ord_token, Request $request)
	{
	$custom_settings = Settings::editCustom();
	$payment_token = '';
	$payment_status = 'completed';
	$purchased_token = $ord_token;
	$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
	$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
	Product::singleordupdateData($purchased_token,$orderdata);
	Product::singlecheckoutData($purchased_token,$checkoutdata);
	
	$token = $purchased_token;
	$check['display'] = Product::getcheckoutData($token);
	$order_id = $check['display']->order_ids;
	\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
	
	$checkout['details'] = Product::getcheckoutData($purchased_token);
	$final_amount = $checkout['details']->total;
	$user_id = $checkout['details']->user_id;
	$admin['info'] = Members::adminData();
	$admin_token = $admin['info']->user_token;
	$admin_earning = $admin['info']->earnings + $final_amount;
	$admin_record = array('earnings' => $admin_earning);
	Members::updateadminData($admin_token, $admin_record);
	
					 
	$sid = 1;
	$setting['setting'] = Settings::editGeneral($sid);
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
		$logged_id = Auth::user()->id;
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
	$result_data = array('payment_token' => $payment_token);
	return view('success')->with($result_data);
	
	}
	
	
	public function stripe_success($orderid, Request $request)
	{
	$custom_settings = Settings::editCustom();
	$payment_token = '';
	$payment_status = 'completed';
	$encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
	$ord_token   = $encrypter->decrypt($orderid);
	$purchased_token = $ord_token;
	
	$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
	$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
	Product::singleordupdateData($purchased_token,$orderdata);
	Product::singlecheckoutData($purchased_token,$checkoutdata);
	
	$token = $purchased_token;
	$check['display'] = Product::getcheckoutData($token);
	$order_id = $check['display']->order_ids;
	\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
	
	$checkout['details'] = Product::getcheckoutData($purchased_token);
	$final_amount = $checkout['details']->total;
	$user_id = $checkout['details']->user_id;
	$admin['info'] = Members::adminData();
	$admin_token = $admin['info']->user_token;
	$admin_earning = $admin['info']->earnings + $final_amount;
	$admin_record = array('earnings' => $admin_earning);
	Members::updateadminData($admin_token, $admin_record);
	
					 
	$sid = 1;
	$setting['setting'] = Settings::editGeneral($sid);
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
			$logged_id = Auth::user()->id;
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
	$result_data = array('payment_token' => $payment_token);
	return view('success')->with($result_data);
	
	}
	
	
	

	public function paypal_success($ord_token, Request $request)
	{
	$custom_settings = Settings::editCustom();
	$payment_token = $request->input('tx');
	$payment_status = 'completed';
	$purchased_token = $ord_token;
	$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
	$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
	Product::singleordupdateData($purchased_token,$orderdata);
	Product::singlecheckoutData($purchased_token,$checkoutdata);
	
	$token = $purchased_token;
	$check['display'] = Product::getcheckoutData($token);
	$order_id = $check['display']->order_ids;
	\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
	
	$checkout['details'] = Product::getcheckoutData($purchased_token);
	$final_amount = $checkout['details']->total;
	$user_id = $checkout['details']->user_id;
	$admin['info'] = Members::adminData();
	$admin_token = $admin['info']->user_token;
	$admin_earning = $admin['info']->earnings + $final_amount;
	$admin_record = array('earnings' => $admin_earning);
	Members::updateadminData($admin_token, $admin_record);
	
					 
	$sid = 1;
	$setting['setting'] = Settings::editGeneral($sid);
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
			$logged_id = Auth::user()->id;
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
	$result_data = array('payment_token' => $payment_token);
	return view('success')->with($result_data);
	
	}
	
	
	public function flutterwaveCallback(Request $request)
	{
	    $custom_settings = Settings::editCustom();
		$sid = 1;
		$setting['setting'] = Settings::editGeneral($sid);
		$payment_token = $request->input('transaction_id');
		$ord_token = $request->input('tx_ref');
		$pay_status = $request->input('status');
		if ($pay_status == 'successful') 
		{
		    $payment_status = 'completed';
			$purchased_token = $ord_token;
			$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
			$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
			Product::singleordupdateData($purchased_token,$orderdata);
			Product::singlecheckoutData($purchased_token,$checkoutdata);
			
			$token = $purchased_token;
			$check['display'] = Product::getcheckoutData($token);
			$order_id = $check['display']->order_ids;
			\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
			
			$checkout['details'] = Product::getcheckoutData($purchased_token);
			$final_amount = $checkout['details']->total;
			$user_id = $checkout['details']->user_id;
			$admin['info'] = Members::adminData();
			$admin_token = $admin['info']->user_token;
			$admin_earning = $admin['info']->earnings + $final_amount;
			$admin_record = array('earnings' => $admin_earning);
			Members::updateadminData($admin_token, $admin_record);
			
							 
			$sid = 1;
			$setting['setting'] = Settings::editGeneral($sid);
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
				$logged_id = Auth::user()->id;
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
			$result_data = array('payment_token' => $payment_token);
			return view('success')->with($result_data);
			
		
		
		}
	
	    else
		{
		   return view('cancel');
		}
			
	}
	
	
	public function payfast_success($ord_token, Request $request)
	{
	$custom_settings = Settings::editCustom();
	$payment_token = "";
	$payment_status = 'completed';
	$purchased_token = $ord_token;
	$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
	$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
	Product::singleordupdateData($purchased_token,$orderdata);
	Product::singlecheckoutData($purchased_token,$checkoutdata);
	
	$token = $purchased_token;
	$check['display'] = Product::getcheckoutData($token);
	$order_id = $check['display']->order_ids;
	\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
	
	$checkout['details'] = Product::getcheckoutData($purchased_token);
	$final_amount = $checkout['details']->total;
	$user_id = $checkout['details']->user_id;
	$admin['info'] = Members::adminData();
	$admin_token = $admin['info']->user_token;
	$admin_earning = $admin['info']->earnings + $final_amount;
	$admin_record = array('earnings' => $admin_earning);
	Members::updateadminData($admin_token, $admin_record);
	
					 
	$sid = 1;
	$setting['setting'] = Settings::editGeneral($sid);
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
		$logged_id = Auth::user()->id;
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
	$result_data = array('payment_token' => $payment_token);
	return view('success')->with($result_data);
	
	}
	
	
	
	public function payhere_success($ord_token, Request $request)
	{
	$custom_settings = Settings::editCustom();
	$payment_token = "";
	$payment_status = 'completed';
	$purchased_token = $ord_token;
	$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
	$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
	Product::singleordupdateData($purchased_token,$orderdata);
	Product::singlecheckoutData($purchased_token,$checkoutdata);
	
	$token = $purchased_token;
	$check['display'] = Product::getcheckoutData($token);
	$order_id = $check['display']->order_ids;
	\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
	
	$checkout['details'] = Product::getcheckoutData($purchased_token);
	$final_amount = $checkout['details']->total;
	$user_id = $checkout['details']->user_id;
	$admin['info'] = Members::adminData();
	$admin_token = $admin['info']->user_token;
	$admin_earning = $admin['info']->earnings + $final_amount;
	$admin_record = array('earnings' => $admin_earning);
	Members::updateadminData($admin_token, $admin_record);
	
					 
	$sid = 1;
	$setting['setting'] = Settings::editGeneral($sid);
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
		$logged_id = Auth::user()->id;
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
	$result_data = array('payment_token' => $payment_token);
	return view('success')->with($result_data);
	
	}
	
	/* checkout */
	
	
	
	/* purchases */
	
	public function view_purchases()
	{
	  $orderData['item'] = Product::getuserOrders();
	  return view('my-purchases',[ 'orderData' => $orderData]); 
	 
	}
	
	
	
	public function invoice_download($product_token,$order_id)
	{
	    $logged = Auth::user()->id;
		$check_purchased = Product::checkPurchased($logged,$product_token);
		if($check_purchased != 0)
		{
		  $item['data'] = Product::solditemData($product_token);
		  $order_details = Product::singleorderData($order_id);
		  $pdf_filename = $order_details->ord_id.'-'.$order_details->purchase_token.'-'.$item['data']->product_slug.'.pdf';
		  $product_slug = $item['data']->product_slug;
		  $user_id = $order_details->user_id;
		  $user_details = Members::singlebuyerData($user_id);
		  $data = ['order_id' => $order_details->ord_id, 'purchase_id' => $order_details->purchase_code, 'purchase_date' => $order_details->start_date, 'expiry_date' => $order_details->end_date, 'license' => $order_details->license, 'product_name' => $order_details->product_name, 'product_slug' => $product_slug, 'payment_token' => $order_details->payment_token, 'payment_type' => $order_details->payment_type, 'product_price' => $order_details->product_price, 'username' => $user_details->username ];
        
        $pdf = PDF::loadView('pdf_view', $data);  
        return $pdf->download($pdf_filename);
	    
		}
		else
		{
		  return redirect('404');
		}
	}
	
	
	public function purchases_download($token)
	{
	    $logged = Auth::user()->id;
		$check_purchased = Product::checkPurchased($logged,$token);
		$allsettings = Settings::allSettings();
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
		if($check_purchased != 0)
		{
		    $item['data'] = Product::solditemData($token);
			$tempsplit= explode('.',$item['data']->product_file);
			$extension = end($tempsplit);
			if($item['data']->product_file_type == 'file')
			{
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
			else
			{
			   return redirect($item['data']->product_file_link);
			}	
		}
		else
		{
		  return redirect('404');
		}
	}
	
	
	public function rating_purchases(Request $request)
	{
	  $product_id = $request->input('product_id');
	  $product_token = $request->input('product_token');
	  $user_id = $request->input('user_id');
	  $product_user_id = $request->input('product_user_id');
	  $rating = $request->input('rating');
	  $ord_id = $request->input('ord_id');
	  $rating_reason = $request->input('rating_reason');
	  $product_url = $request->input('product_url');
	  $rating_date = date('Y-m-d H:i:s');
	  
	  $rating_comment = $request->input('rating_comment');
	  $rating_count = Product::checkRating($product_token,$user_id);
	  
	  $savedata = array('or_product_id' => $product_id, 'order_id' => $ord_id, 'or_product_token' => $product_token, 'or_user_id' => $user_id, 'or_product_user_id' => $product_user_id, 'rating' => $rating, 'rating_reason' => $rating_reason, 'rating_comment' => $rating_comment, 'rating_date' => $rating_date); 
	  
	  $updata = array('rating' => $rating, 'rating_reason' => $rating_reason, 'rating_comment' => $rating_comment, 'rating_date' => $rating_date); 
	  
	  if($rating_count == 0)
	  {
	  
	    Product::saveRating($savedata);
		$userto['data'] = Members::singlevendorData($product_user_id);
		$userfrom['data'] = Members::singlebuyerData($user_id);
		$to_email = $userto['data']->email;
		$to_name  = $userto['data']->name;
		$from_email = $userfrom['data']->email;
		$from_name = $userfrom['data']->name;
		$sid = 1;
		$setting['setting'] = Settings::editGeneral($sid);
		$admin_name = $setting['setting']->sender_name;
		$admin_email = $setting['setting']->sender_email;
		$record = array('to_name' => $to_name, 'from_name' => $from_name, 'from_email' => $from_email, 'product_url' => $product_url, 'rating' => $rating, 'rating_reason' => $rating_reason, 'rating_comment' => $rating_comment);
		/* email template code */
	          $checktemp = EmailTemplate::checkTemplate(7);
			  if($checktemp != 0)
			  {
			  $template_view['mind'] = EmailTemplate::viewTemplate(7);
			  $template_subject = $template_view['mind']->et_subject;
			  }
			  else
			  {
			  $template_subject = "Product Item Rating Received";
			  }
			  /* email template code */
		Mail::send('rating_mail', $record, function($message) use ($admin_name, $admin_email, $to_email, $from_email, $to_name, $from_name, $template_subject) {
				$message->to($to_email, $to_name)
						->subject($template_subject);
				$message->from($from_email,$from_name);
			});
		
	   
		
		
		 
	  }
	  else
	  {
	     Product::updateRating($product_token,$user_id,$updata);
	  }
	  
	  return redirect('my-purchases')->with('success','Rating has been updated');
	
	}
	
	/* purchases */
	
	
	/* refund */
	
	public function refund_request(Request $request)
	{
	  $product_id = $request->input('product_id');
	  $product_token = $request->input('product_token');
	  $purchased_token = $request->input('purchased_token');
	  $user_id = $request->input('user_id');
	  $product_user_id = $request->input('product_user_id');
	  $ord_id = $request->input('ord_id');
	  $ref_refund_reason = $request->input('refund_reason');
	  $ref_refund_comment = $request->input('refund_comment');
	  $product_url = $request->input('product_url');
	  $refund_count = Product::checkRefund($product_token,$user_id);
	  
	  $savedata = array('ref_product_id' => $product_id, 'ref_order_id' => $ord_id, 'ref_product_token' => $product_token, 'ref_purchased_token' => $purchased_token,  'ref_user_id' => $user_id, 'ref_product_user_id' => $product_user_id, 'ref_refund_reason' => $ref_refund_reason, 'ref_refund_comment' => $ref_refund_comment); 
	  
	  
	  
	  if($refund_count == 0)
	  {
	    Product::saveRefund($savedata);
		$userfrom['data'] = Members::singlebuyerData($user_id);
		$from_email = $userfrom['data']->email;
		$from_name = $userfrom['data']->name;
		$sid = 1;
		$setting['setting'] = Settings::editGeneral($sid);
		$admin_name = $setting['setting']->sender_name;
		$admin_email = $setting['setting']->sender_email;
		$record = array('from_name' => $from_name, 'from_email' => $from_email, 'product_url' => $product_url, 'ref_refund_reason' => $ref_refund_reason, 'ref_refund_comment' => $ref_refund_comment);
		/* email template code */
	          $checktemp = EmailTemplate::checkTemplate(8);
			  if($checktemp != 0)
			  {
			  $template_view['mind'] = EmailTemplate::viewTemplate(8);
			  $template_subject = $template_view['mind']->et_subject;
			  }
			  else
			  {
			  $template_subject = "Refund Request Received";
			  }
			  /* email template code */
		Mail::send('refund_mail', $record, function($message) use ($admin_name, $admin_email, $from_email, $from_name, $template_subject) {
				$message->to($admin_email, $admin_name)
						->subject($template_subject);
				$message->from($from_email,$from_name);
			});
		
		
		
	    return redirect('my-purchases')->with('success','Your refund request has been sent successfully');
	  }
	  else
	  {
	     
		 return redirect('my-purchases')->with('error','Sorry! Your refund request already sent');
	  }
	  
	  
	  
	
	}
	
	/* refund */
	
	
	public function view_withdrawal()
	{
	  $sid = 1;
	  $setting['setting'] = Settings::editGeneral($sid); 
	  $withdraw_option = explode(',', $setting['setting']->withdraw_option);
	  $itemData['item'] = Product::getdrawalData();
	  $data = array('withdraw_option' => $withdraw_option, 'itemData' => $itemData);
	  
	  return view('withdrawal')->with($data);
	}
	
	
	public function withdrawal_request(Request $request)
	{
	   $withdrawal = $request->input('withdrawal');
	   $paypal_email = $request->input('paypal_email');
	   $stripe_email = $request->input('stripe_email');
	   $paystack_email = $request->input('paystack_email');
	   $bank_details = $request->input('bank_details');
	   $available_balance = base64_decode($request->input('available_balance'));
	   $get_amount = $request->input('get_amount');
	   $user_id = $request->input('user_id');
	   $token = $request->input('user_token');
	   $wd_data = date('Y-m-d');
	   $wd_status = "pending";
	   
	   $payfast_email = $request->input('payfast_email');
	   $paytm_no = $request->input('paytm_no');
	   $upi_id = $request->input('upi_id');
	   $skrill_email = $request->input('skrill_email');
	   $crypto_address = $request->input('crypto_address');
	   
	   $drawal_data = array('wd_user_id' => $user_id, 'withdraw_type' => $withdrawal, 'paypal_email' => $paypal_email, 'stripe_email' => $stripe_email, 'paystack_email' => $paystack_email, 'wd_amount' => $get_amount, 'wd_status' => $wd_status, 'wd_date' => $wd_data, 'bank_details' => $bank_details, 'payfast_email' => $payfast_email, 'skrill_email' => $skrill_email, 'upi_id' => $upi_id, 'paytm_no' => $paytm_no, 'crypto_address' => $crypto_address);
	   if($available_balance >= $get_amount)
	   {
	     Product::savedrawalData($drawal_data);
		 $less_amount = $available_balance - $get_amount;
		 $data = array('earnings' => $less_amount);
		 Members::updateData($token,$data);
		 return redirect()->back()->with('success', 'Your withdrawal request has been sent');
	   }
	   else
	   {
	     return redirect()->back()->with('error', 'Sorry Please check your available balance');
	   }
	   
	   
	   
	}
	
	public function view_redeem_voucher()
	{
	  return view('redeem-voucher');
	}
	
	
	public function add_money(Request $request)
	{
	   $sid = 1;
	   $setting['setting'] = Settings::editGeneral($sid);
	   $user_id = Auth::user()->id;
	   $voucher_code = $request->input('voucher_code');
	   $count = Voucher::checkVoucher($voucher_code);
	   if($count != 0)
	   {
	      $voucher = Voucher::getVoucher($voucher_code);
		  $earnings = Auth::user()->earnings + $voucher->voucher_total;
		  $update = array('earnings' => $earnings);
		  Members::updateprofileData($user_id,$update);
		  $voucher_token = $voucher->voucher_token;
		  $voucher_redeem_date = date('d-M-Y h:i a');
		  $updatedata = array('voucher_redeem_user_id' => $user_id, 'voucher_status' => 'Used', 'voucher_redeem_date' => $voucher_redeem_date);
		  Voucher::updateData($voucher_token,$updatedata);
		  /* redeem email */
		  $vendor['info'] = Members::singlevendorData($user_id);
		  $user_token = $vendor['info']->user_token;
		  $to_name = $vendor['info']->name;
		  $to_email = $vendor['info']->email;
			 		  
		  $admin_name = $setting['setting']->sender_name;
		  $admin_email = $setting['setting']->sender_email;
		  $currency = $setting['setting']->site_currency_code;
		  $credits = $voucher->voucher_total;
		  $record_data = array('to_name' => $to_name, 'to_email' => $to_email, 'voucher_code' => $voucher_code, 'credits' => $credits, 'currency' => $currency);
		  /* email template code */
			 $checktemp = EmailTemplate::checkTemplate(25);
			 if($checktemp != 0)
			 {
				 $template_view['mind'] = EmailTemplate::viewTemplate(25);
				 $template_subject = $template_view['mind']->et_subject;
			 }
			 else
			 {
				 $template_subject = "Redeem Voucher Notifications";
			 }
			 /* email template code */
			 Mail::send('redeem_voucher_mail', $record_data , function($message) use ($admin_name, $admin_email, $to_name, $to_email, $template_subject) {
				$message->to($to_email, $to_name)
				->subject($template_subject);
				$message->from($admin_email,$admin_name);
			 });
		  /* redeem email */
		  return redirect()->back()->with('success','Your voucher value has been added. please check your wallet balance.');
		  
	   }
	   else
	   {
	   return redirect()->back()->with('error', 'Your voucher code is invalid or expired');
	   }
	
	}
	
	public function mercadopago_success($ord_token, Request $request)
	{
	    $custom_settings = Settings::editCustom();
		$sid = 1;
		$setting['setting'] = Settings::editGeneral($sid);
		$pay_status = $request->input('status');
		if($pay_status == 'approved')
		{
			$payment_token = $request->input('payment_id');
			$payment_status = 'completed';
			$purchased_token = $ord_token;
			$orderdata = array('payment_token' => $payment_token, 'order_status' => $payment_status);
			$checkoutdata = array('payment_token' => $payment_token, 'payment_status' => $payment_status);
			Product::singleordupdateData($purchased_token,$orderdata);
			Product::singlecheckoutData($purchased_token,$checkoutdata);
			
			$token = $purchased_token;
			$check['display'] = Product::getcheckoutData($token);
			$order_id = $check['display']->order_ids;
			\App\Helpers\AccountDeliveryHelper::assignAccounts($order_id, $purchased_token);
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
			
			$checkout['details'] = Product::getcheckoutData($purchased_token);
			$final_amount = $checkout['details']->total;
			$user_id = $checkout['details']->user_id;
			$admin['info'] = Members::adminData();
			$admin_token = $admin['info']->user_token;
			$admin_earning = $admin['info']->earnings + $final_amount;
			$admin_record = array('earnings' => $admin_earning);
			Members::updateadminData($admin_token, $admin_record);
			
							 
			$sid = 1;
			$setting['setting'] = Settings::editGeneral($sid);
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
				$logged_id = Auth::user()->id;
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
			$result_data = array('payment_token' => $payment_token);
			return view('success')->with($result_data);
	
			
		}
		else
		{
		   return view('failure');
		}
	
		
	}
	
	/* tickets */
	public function view_tickets()
	{
	  
	  $tickets = Product::getticketData();
	  $data = array('tickets' => $tickets);
	  
	  return view('my-tickets')->with($data);
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
	  
	  return view('ticket')->with($data);
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
	  return redirect('my-tickets')->with('success', 'Your ticket #'.$token.' has been closed');
	}
	
	
	public function reply_ticket(Request $request)
	{
	   $tickets_token = $request->input('tickets_token');
	   $tickets_user_token = $request->input('tickets_user_token');
	   $tickets_message = $request->input('tickets_message');
	   $ticket_status = 'customer replied';
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
							$checktemp = EmailTemplate::checkTemplate(27);
							if($checktemp != 0)
							{
								$template_view['mind'] = EmailTemplate::viewTemplate(27);
								$template_subject = $template_view['mind']->et_subject;
							}
							else
							{
								$template_subject = "Ticket Replied By Customer";
							}
							/* email template code */
							Mail::send('ticket_replied_mail', $data , function($message) use ($from_name, $from_email, $to_name, $to_email, $tickets_token, $tickets_message, $template_subject) {
									$message->to($to_email, $to_name)
											->subject($template_subject);
									$message->from($from_email,$from_name);
								});
		
		 return redirect('ticket/'.$tickets_token)->with('success', 'Your ticket reply message has been sent');
	   }
	   
	   
	   
	   
	}
	
	/* tickets */
	
	
}
