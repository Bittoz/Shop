<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->enum('type', ['downloadable', 'non_downloadable'])
                  ->default('downloadable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
