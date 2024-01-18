<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTagsTable extends Migration
{
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_category_id')->nullable();
            $table->foreign('tag_category_id', 'tag_category_fk_5974016')->references('id')->on('tag_categories');
        });
    }
}
