<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserFavResourcesTable extends Migration
{
    public function up()
    {
        Schema::table('user_fav_resources', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6000175')->references('id')->on('users');
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->foreign('resource_id', 'resource_fk_6000176')->references('id')->on('resources');
        });
    }
}
