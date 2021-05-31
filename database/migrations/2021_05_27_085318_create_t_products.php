<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id')->nullable(true);
            $table->unsignedInteger('specifications_id')->nullable(true);
            $table->decimal('original_price',8, 2)->nullable(true);
            $table->decimal('taxes', 8, 2)->nullable(true);
            $table->decimal('discount', 4, 2)->nullable(true);
            $table->decimal('price',8, 2)->nullable(true);
            $table->boolean('visible');
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
        Schema::dropIfExists('t_products');
    }
}
