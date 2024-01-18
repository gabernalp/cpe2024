<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceResourcesSubcategoryPivotTable extends Migration
{
    public function up()
    {
        Schema::create('resource_resources_subcategory', function (Blueprint $table) {
            $table->unsignedBigInteger('resource_id');
            $table->foreign('resource_id', 'resource_id_fk_6053187')->references('id')->on('resources')->onDelete('cascade');
            $table->unsignedBigInteger('resources_subcategory_id');
            $table->foreign('resources_subcategory_id', 'resources_subcategory_id_fk_6053187')->references('id')->on('resources_subcategories')->onDelete('cascade');
        });
    }
}
