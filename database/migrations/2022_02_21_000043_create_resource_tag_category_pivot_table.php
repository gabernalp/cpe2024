<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceTagCategoryPivotTable extends Migration
{
    public function up()
    {
        Schema::create('resource_tag_category', function (Blueprint $table) {
            $table->unsignedBigInteger('resource_id');
            $table->foreign('resource_id', 'resource_id_fk_5974031')->references('id')->on('resources')->onDelete('cascade');
            $table->unsignedBigInteger('tag_category_id');
            $table->foreign('tag_category_id', 'tag_category_id_fk_5974031')->references('id')->on('tag_categories')->onDelete('cascade');
        });
    }
}
