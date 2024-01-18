<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCoursesHooksTable extends Migration
{
    public function up()
    {
        Schema::table('courses_hooks', function (Blueprint $table) {
            $table->unsignedBigInteger('entidad_id')->nullable();
            $table->foreign('entidad_id', 'entidad_fk_5974760')->references('id')->on('entities');
        });
    }
}
