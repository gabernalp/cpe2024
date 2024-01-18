<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceSearchPivotTable extends Migration
{
    public function up()
    {
        Schema::create('resource_search', function (Blueprint $table) {
            $table->unsignedBigInteger('search_id');
            $table->foreign('search_id', 'search_id_fk_6038790')->references('id')->on('searches')->onDelete('cascade');
            $table->unsignedBigInteger('resource_id');
            $table->foreign('resource_id', 'resource_id_fk_6038790')->references('id')->on('resources')->onDelete('cascade');
        });
    }
}
