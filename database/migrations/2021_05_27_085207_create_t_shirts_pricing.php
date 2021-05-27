<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTShirtsPricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_shirts_pricing', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->decimal('original_price',8, 2);
            $table->decimal('taxes', 8, 2);
            $table->decimal('discount', 3, 2);
            $table->decimal('price',8, 2);
            $table->boolean('active');
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
        Schema::dropIfExists('t_products_pricing');
    }
}
