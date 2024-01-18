<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchesTable extends Migration
{
    public function up()
    {
        Schema::create('searches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('search_item')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
