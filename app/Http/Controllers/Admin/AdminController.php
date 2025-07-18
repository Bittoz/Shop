<?php

namespace DownGrade\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DownGrade\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use DownGrade\Models\Pages;
use DownGrade\Models\Product;
use DownGrade\Models\Blog;
use DownGrade\Models\Settings;
use DownGrade\Models\Events;
use DownGrade\Models\Members;
use DownGrade\Models\Category;
use Auth;
use Mail;
use Helper;

class AdminController extends Controller
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
    public function admin()
    {
       
	  $sid = 1;
		$setting['setting'] = Settings::editGeneral($sid);
		
		$today = date('d F Y');
		$first_day = date('d F Y', strtotime('-1 days'));
		$second_day = date('d F Y', strtotime('-2 days'));
		$third_day = date('d F Y', strtotime('-3 days'));
		$fourth_day = date('d F Y', strtotime('-4 days'));
		$fifth_day = date('d F Y', strtotime('-5 days'));
		$sixth_day = date('d F Y', strtotime('-6 days'));
		
		$data1 = date('Y-m-d');
		$data2 = date('Y-m-d', strtotime('-1 days'));
		$data3 = date('Y-m-d', strtotime('-2 days'));
		$data4 = date('Y-m-d', strtotime('-3 days'));
		$data5 = date('Y-m-d', strtotime('-4 days'));
		$data6 = date('Y-m-d', strtotime('-5 days'));
		$data7 = date('Y-m-d', strtotime('-6 days'));
		
		
		$view1 = Product::orderdataCheck($data1);
		$view2 = Product::orderdataCheck($data2);
		$view3 = Product::orderdataCheck($data3);
		$view4 = Product::orderdataCheck($data4);
		$view5 = Product::orderdataCheck($data5);
		$view6 = Product::orderdataCheck($data6);
		$view7 = Product::orderdataCheck($data7);  
		
	  $total_customers = Members::totaluserCount();
	  
	  $total_category = Category::totalcategoryCount();
	  $total_pages = Pages::totalpageData();
	  $total_pages = Pages::totalpageData();
	  $total_post = Blog::totalblogData();
	  $total_product = Product::totalProduct();
	  $total_order = Product::totalOrder();
	  $total_refund = Product::totalRefund();
	  $total_withdrawal = Product::totalWithdrawal();
	  $total_tickets = Product::totalTickets();
	  $total_coupons = Product::totalCoupon();
	  $total_subadmin = Product::totalSubadmin();
	  $total_subscription = Product::totalSubscription();
	  
	  $approved = Product::itemapprovedCheck(1);
		$unapproved = Product::itemapprovedCheck(0);
	  
	  $data = array('setting' => $setting, 'today' => $today, 'first_day' => $first_day, 'second_day' => $second_day, 'third_day' => $third_day, 'fourth_day' => $fourth_day, 'fifth_day' => $fifth_day, 'sixth_day' => $sixth_day, 'view1' => $view1, 'view2' => $view2, 'view3' => $view3, 'view4' => $view4, 'view5' => $view5, 'view6' => $view6, 'view7' => $view7, 'total_customers' => $total_customers, 'total_category' => $total_category, 'total_pages' => $total_pages, 'total_post' => $total_post, 'total_product' => $total_product, 'total_order' => $total_order, 'total_refund' => $total_refund, 'total_withdrawal' => $total_withdrawal, 'approved' => $approved, 'unapproved' => $unapproved, 'total_tickets' => $total_tickets, 'total_coupons' => $total_coupons, 'total_subadmin' => $total_subadmin, 'total_subscription' => $total_subscription);
	  if($this->custom() != 0)
	  {
	  return view('admin.index')->with($data);
	  }
      else
	  {
	  return redirect('/admin/license');
	  }
		
		
    }
	public function license_check()
	{
	   return view('admin.license');
	}
	
	public function verify_purchase(Request $request)
	{
	        $dw_ver = Helper::version_no();
	        $username = $request->input('username');
	        $purchased_code = $request->input('purchased_code');
	        $code= $purchased_code; 
			$encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
			$key = Settings::productcode();
			$keyname = $encrypter->decrypt($key);
			$url = "https://api.envato.com/v3/market/author/sale?code=".$code;
			$curl = curl_init($url);
			$personal_token = "sS3y8m5fMdYZMWVbSPtI7LdJYmtC9F2O";
			$header = array();
			$header[] = 'Authorization: Bearer '.$personal_token;
			$header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0';
			$header[] = 'timeout: 20';
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
			$envatoRes = curl_exec($curl);
			curl_close($curl);
			$envatoRes = json_decode($envatoRes);
			if($envatoRes->license == base64_decode(Helper::key_no())){ $key_val = 1; } else { $key_val = 0; }
			if (isset($envatoRes->item->name))
			{
				if($keyname == $envatoRes->item->id && $envatoRes->buyer == $username)
				{   
					$data = array($dw_ver => 1, 'author_key' => $key_val);
					Settings::updateCustomData($data);
					return redirect('admin');
				}
				else
				{
				  return redirect('admin/license')->with('error','Sorry, This is not a valid username & purchase code');
				}
			}
			else
		    {
				  return redirect('admin/license')->with('error','Sorry, This is not a valid username & purchase code');
			}	
	
	}
	
	
	
}
