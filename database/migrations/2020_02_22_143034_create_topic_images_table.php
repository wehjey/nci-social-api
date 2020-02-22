<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image_url');
            $table->unsignedBigInteger('topic_id');
            $table->foreign('topic_id')->references('id')->on('topics');
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
        Schema::dropIfExists('topic_images');
    }
}
