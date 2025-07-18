<?php

namespace DownGrade\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Auth;

class Import extends Model
{

   protected $table = 'product';
   public $timestamps = false;
   
   protected $fillable = [
            'product_id',
            'user_id',
            'product_token',
            'product_name',
            'product_slug',
			'product_category',
			'product_category_parent',
			'product_category_type',
			'product_type_cat_id',
			'product_short_desc',
			'product_desc',
			'regular_price',
			'extended_price',
			'product_image',
			'product_preview',
			'product_video_url',
			'product_demo_url',
			'product_allow_seo',
			'product_seo_keyword',
			'product_seo_desc',
			'product_tags',
			'product_flash_sale',
			'product_free',
			'download_count',
			'product_views',
			'product_liked',
			'product_sold',
			'product_fake_stars',
			'product_featured',
			'product_file',
			'product_file_type',
			'product_file_link',
			'package_includes',
			'compatible_browsers',
			'future_update',
			'item_support',
			'product_date',
			'product_update',
			'subscription_item',
			'product_status',
			'product_drop_status'
      
    ];
   
   
  
  
  
}
