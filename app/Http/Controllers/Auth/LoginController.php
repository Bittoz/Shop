<?php

namespace DownGrade\Http\Controllers\Auth;

use DownGrade\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DownGrade\Models\Settings;
use DownGrade\Models\EmailTemplate;
use Auth;
use Socialite;
use DownGrade\User;
use Illuminate\Support\Facades\Validator;
use Session;
use DownGrade\Models\Product;
use Helper;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 
	public function custom()
	{
	    $dw_v = Helper::version_no();
		$custom = Settings::editCustom();
		return $custom->$dw_v;
	}   
	 
	public function authenticated($request , $user)
	{
			if($user->user_type=='admin')
			{
				  if($this->custom() != 0)
				  {
					 return redirect('/admin');
				  }
				  else
				  {
					 return redirect('/admin/license');
				  }
			}
			else
			{
				return redirect('/');
			}
    } 
	 
	public function redirectToProvider($provider)
	{
	   return Socialite::driver($provider)->scopes(['email'])->redirect();
	}
	 
	public function handleProviderCallback($provider)
	{
	  $user = Socialite::driver($provider)->user();
	  $authUser = $this->CreateUser($user,$provider);
	  Auth::login($authUser, true); 
	  return redirect('/');
	
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
	
	public function user_slug($string){
		   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
		   return $slug;
    } 
	
	public function CreateUser($user, $provider)
	{
	  $authUser = User::where('provider_id', $user->id)->first();
	  if($authUser)
	  {
		return $authUser;
	  }
	  
	  $token = $this->generateRandomString();
	  return User::create([
            'name' => $user->name,
            'email' => $user->email,
			'username' => $this->user_slug($user->name),
			'user_token' => $token,
			'earnings' => 0,
			'user_type' => 'customer',
			'verified' => 1,
			'provider' => $provider,
            'provider_id' => $user->id
			   

			  
        ]);
	  
	  
	
	}
	  
	
	 
	public function login(Request $request)
	{
		$field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
		$email = trim($request->email);
	    $password = trim($request->password);
	    $session_id = Session::getId();
		if (Auth::attempt(array($field => $email, 'password' =>  $password, 'verified' => 1, 'drop_status' => 'no' )))
		{
		    Session::setId($session_id);
			$updata = array('user_id' => auth()->user()->id); 
			Product::changeOrder($session_id,$updata);
			if(auth()->user()->user_type == 'admin')
			{
			 
			  if($this->custom() != 0)
			  {
			     return redirect('/admin');
			  }
			  else
			  {
			     return redirect('/admin/license');
			  }
			 
			 
			}
			else
			{
			  return redirect('/');
			}
	
		}
		else
	   	{
	     return redirect()->back()->with('error', 'These credentials do not match our records.');
	   	}
	    
	
		/*return redirect('login')->withErrors([
			'error' => 'These credentials do not match our records.',
		]);*/
		
		
	} 
	 
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
