<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCoursesTable extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('tematica_asociada_id')->nullable();
            $table->foreign('tematica_asociada_id', 'tematica_asociada_fk_5973911')->references('id')->on('background_processes');
        });
    }
}
