<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('resource_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('resource_id');
            $table->foreign('resource_id', 'resource_id_fk_5974032')->references('id')->on('resources')->onDelete('cascade');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id', 'tag_id_fk_5974032')->references('id')->on('tags')->onDelete('cascade');
        });
    }
}
