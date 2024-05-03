<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_return_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_return_id');
            $table->unsignedBigInteger('product_id')->nullable();
            // $table->string('product_name');
            // $table->string('product_code')->nullable();
            $table->integer('quantity');
            $table->unsignedBigInteger('price_id');
            $table->foreign('price_id')->references('id')->on('prices')->onDelete('cascade');
            // $table->string('unit_price');
            // $table->integer('sub_total');
            // $table->integer('product_discount_amount');
            // $table->string('product_discount_type')->default('fixed');
            // $table->integer('product_tax_amount');
            $table->foreign('sale_return_id')->references('id')
                ->on('sale_returns')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')
                ->on('products')->nullOnDelete();
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
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
        Schema::dropIfExists('sale_return_details');
    }
}
