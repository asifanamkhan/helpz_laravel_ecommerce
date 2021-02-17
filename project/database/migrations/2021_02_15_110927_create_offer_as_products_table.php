<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferAsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_as_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id');
            $table->double('offer_price');
            $table->string('quantity')->nullable();
            $table->string('banner');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_as_products');
    }
}
