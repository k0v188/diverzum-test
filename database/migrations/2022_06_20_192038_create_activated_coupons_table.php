<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivatedCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activated_coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->timestamps();

            $table->foreign('coupon_id')->on('coupons')->references('id');
            $table->foreign('product_id')->on('products')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activated_coupons');
    }
}
