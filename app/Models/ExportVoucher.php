<?php

namespace DownGrade\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Auth;
use DownGrade\Models\Voucher;
use DownGrade\Models\Members;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
/*class ExportProduct implements FromCollection, WithHeadings*/

class ExportVoucher implements FromCollection, WithHeadings, WithMapping
{

   
   protected $id;

	 function __construct($id) {
			$this->id = $id;
	 }
    
   
   public function collection()
    {
	 
	  if(!empty($this->id))
	  {
        return Voucher::select('voucher_code','voucher_price','voucher_bonus','voucher_status','voucher_create_date','voucher_expiry_date','voucher_redeem_date','voucher_redeem_user_id')->whereRaw('FIND_IN_SET(voucher_token,"'.$this->id.'")')->get();
	  }
	  else
	  {
	    return Voucher::select('voucher_code','voucher_price','voucher_bonus','voucher_status','voucher_create_date','voucher_expiry_date','voucher_redeem_date','voucher_redeem_user_id')->get();
	  }	
    }
	
   	public static function Redeem_User($user_id)
	{
	   $checkout = Members::referralCheck($user_id);
	   if($checkout != 0)
	   {
	   $single = Members::logindataUser($user_id);
	   return $single->username;
	   }
	   else
	   {
	   return "";
	   }
	   
	}
  
   public function headings(): array
    {
        return [
            'Topup/Recharge Voucher  Secret',
            'Voucher Value',
            'Bonus Credits',
            'Voucher Status',
            'Generation Date',
			'Expiry Date',
			'Redemption Date',
			'Redeemed By'
        ];
    }
	
	
	public function map($voucher): array
    {
        if(strtotime($voucher->voucher_expiry_date) < strtotime(date('Y-m-d h:i:s'))){
            return [
                $voucher->voucher_code,
                $voucher->voucher_price,
                $voucher->voucher_bonus,
                "Expired",
                $voucher->voucher_create_date,
                date("d-M-Y h:i a", strtotime($voucher->voucher_expiry_date)),
                $voucher->voucher_redeem_date,
                $this->Redeem_User($voucher->voucher_redeem_user_id)
            ];
        }else{
            return [
                $voucher->voucher_code,
                $voucher->voucher_price,
                $voucher->voucher_bonus,
                $voucher->voucher_status,
                $voucher->voucher_create_date,
                date("d-M-Y h:i a", strtotime($voucher->voucher_expiry_date)),
                $voucher->voucher_redeem_date,
                $this->Redeem_User($voucher->voucher_redeem_user_id)
            ];
        }
		
		
    }


  
}
