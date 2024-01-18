<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToChallengesTable extends Migration
{
    public function up()
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id', 'course_fk_5973934')->references('id')->on('courses');
            $table->unsignedBigInteger('referencetype_capsule_id')->nullable();
            $table->foreign('referencetype_capsule_id', 'referencetype_capsule_fk_5973935')->references('id')->on('reference_types');
            $table->unsignedBigInteger('referencetype_id')->nullable();
            $table->foreign('referencetype_id', 'referencetype_fk_5973929')->references('id')->on('reference_types');
        });
    }
}
