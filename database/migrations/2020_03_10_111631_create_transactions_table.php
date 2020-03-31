<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->unsignedBigInteger('buyer_id');
            $table->foreign('buyer_id')
                ->references('id')->on('users');
            $table->double('price');
            $table->double('unit_price');
            $table->integer('quantity');
            $table->string('reference');
            $table->string('payment_reference')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
