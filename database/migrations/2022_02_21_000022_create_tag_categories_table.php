<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('tag_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->longText('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}