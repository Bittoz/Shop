<?php

namespace App\Helpers;

use App\Models\AccountInventory;
use App\Models\Product;
use Illuminate\Support\Carbon;

class AccountDeliveryHelper
{
    public static function assignAccounts($order_ids, $purchase_token)
    {
        $order_list = explode(',', $order_ids);
        foreach ($order_list as $order_id) {
            $orderItem = Product::getorderData($order_id);
            $product = Product::solditemData($orderItem->product_token);

            if ($product->product_type !== 'non_downloadable') continue;

            $account = AccountInventory::where('product_id', $product->product_id)
                        ->where('status', 'Available')->first();

            if ($account) {
                $account->update([
                    'status' => 'Delivered',
                    'order_id' => $order_id,
                    'assigned_at' => Carbon::now(),
                    'delivered_at' => Carbon::now(),
                ]);
                    $buyer = \DownGrade\Models\Members::singlebuyerData($orderItem->user_id ?? null);

    if ($buyer) {
        $emailData = [
            'username' => $account->username,
            'password' => $account->password,
            'note' => $account->note,
            'product_name' => $product->product_name,
        ];

        \Mail::send('emails.account_delivery', $emailData, function($message) use ($buyer, $product) {
            $message->to($buyer->email, $buyer->name)
                    ->subject("Your {$product->product_name} account credentials");
        });
    }

            }
        }
    }
}
