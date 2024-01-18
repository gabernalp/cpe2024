<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToResourcesSubcategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('resources_subcategories', function (Blueprint $table) {
            $table->unsignedBigInteger('resourcescategory_id')->nullable();
            $table->foreign('resourcescategory_id', 'resourcescategory_fk_5974003')->references('id')->on('resources_categories');
        });
    }
}
