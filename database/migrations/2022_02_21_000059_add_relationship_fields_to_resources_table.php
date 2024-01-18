<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToResourcesTable extends Migration
{
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->unsignedBigInteger('resourcescategory_id')->nullable();
            $table->foreign('resourcescategory_id', 'resourcescategory_fk_5974022')->references('id')->on('resources_categories');
        });
    }
}
