<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountInventoriesTable extends Migration
{
    public function up()
    {
        Schema::create('account_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('username');
            $table->text('password');
            $table->text('note')->nullable();
            $table->enum('status', ['Available', 'Assigned', 'Delivered', 'Invalid']);
            $table->unsignedBigInteger('order_id')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_inventories');
    }
}
