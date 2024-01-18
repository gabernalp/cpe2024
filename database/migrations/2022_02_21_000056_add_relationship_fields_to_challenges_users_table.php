<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToChallengesUsersTable extends Migration
{
    public function up()
    {
        Schema::table('challenges_users', function (Blueprint $table) {
            $table->unsignedBigInteger('courseschedule_id')->nullable();
            $table->foreign('courseschedule_id', 'courseschedule_fk_5973995')->references('id')->on('course_schedules');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_5973987')->references('id')->on('users');
            $table->unsignedBigInteger('challenge_id')->nullable();
            $table->foreign('challenge_id', 'challenge_fk_5973986')->references('id')->on('challenges');
        });
    }
}
