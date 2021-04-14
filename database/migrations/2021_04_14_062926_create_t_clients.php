<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('surname');
            $table->string('address');
            $table->integer('postal_code');
            $table->string('city');
            $table->string('country');
            $table->string('email');
            $table->integer('telephone');
            $table->integer('order_id')->unique();
            $table->date('date_ordered');
            $table->date('date_sended');
            $table->string('payment');
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
        Schema::dropIfExists('t_clients');
    }
}
