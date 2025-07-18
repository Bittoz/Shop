<?php

namespace DownGrade\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Auth;
use DownGrade\Models\Import;
use DownGrade\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportProduct implements ToModel, WithStartRow
{

  
   public function startRow(): int
    {
       return 2;
    }
	
   public function model(array $row)
    {
	     
	    
           $data = Product::findProduct($row[2]);
		   if($row[25] == ""){ $product_liked = 0; } else { $product_liked = $row[25]; }
		   if($row[24] == ""){ $product_views = 0; } else { $product_views = $row[24]; }
		   if($row[38] == ""){ $subscription_item = 0; } else { $subscription_item = $row[38]; }
		   if($row[39] == ""){ $product_status = 0; } else { $product_status = $row[39]; }
           if (empty($data)) {
          
					  return new Import([
					   'user_id'    => $row[1], 
					   'product_token' => $row[2],
					   'product_name' => $row[3],
					   'product_slug' => $row[4],
					   'product_category' => $row[5],
					   'product_category_parent' => $row[6],
					   'product_category_type' => $row[7],
					   'product_type_cat_id' => $row[8],
					   'product_short_desc' => $row[9],
					   'product_desc' => $row[10],
					   'regular_price' => $row[11],
					   'extended_price' => $row[12],
					   'product_image' => $row[13],
					   'product_preview' => $row[14],
					   'product_video_url' => $row[15],
					   'product_demo_url' => $row[16],
					   'product_allow_seo' => $row[17],
					   'product_seo_keyword' => $row[18],
					   'product_seo_desc' => $row[19],
					   'product_tags' => $row[20],
					   'product_flash_sale' => $row[21],
					   'product_free' => $row[22],
					   'download_count' => $row[23],
					   'product_views' => $product_views,
					   'product_liked' => $product_liked,
					   'product_sold' => $row[26],
					   'product_fake_stars' => $row[27],
					   'product_featured' => $row[28],
					   'product_file' => $row[29],
					   'product_file_type' => $row[30],
					   'product_file_link' => $row[31],
					   'package_includes' => $row[32],
					   'compatible_browsers' => $row[33],
					   'future_update' => $row[34],
					   'item_support' => $row[35],
					   'product_date' => $row[36],
					   'product_update' => $row[37],
					   'subscription_item' => $subscription_item,
					   'product_status' => $product_status,
					   'product_drop_status' => $row[40],
					]);
		  
		  
              } 
     
	    
	
        
    }
   
   
  
  
}
