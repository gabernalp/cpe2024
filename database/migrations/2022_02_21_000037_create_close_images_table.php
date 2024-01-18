<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloseImagesTable extends Migration
{
    public function up()
    {
        Schema::create('close_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('answered_challenges')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
