<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAssignToSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_assign_to_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no');
            $table->string('product_id');
            $table->string('product_name');
            $table->string('product_qty');
            $table->string('order_id');
            $table->string('supplier_id');
            $table->string('customer_id');
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
        Schema::dropIfExists('product_assign_to_suppliers');
    }
}
