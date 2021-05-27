<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTShirtsSpecifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_shirts_specifications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->integer('product_number');
            $table->string('designer_name', 255);
            $table->unsignedInteger('colour_id');
            $table->unsignedInteger('size_id');
            $table->string('material', 255);
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
        Schema::dropIfExists('t_products_specifications');
    }
}
