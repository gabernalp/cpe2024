<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProfilesTable extends Migration
{
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('entidad_asociada_id')->nullable();
            $table->foreign('entidad_asociada_id', 'entidad_asociada_fk_5995705')->references('id')->on('entities');
        });
    }
}
