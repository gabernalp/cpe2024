<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCoursesUsersTable extends Migration
{
    public function up()
    {
        Schema::table('courses_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_5973977')->references('id')->on('users');
            $table->unsignedBigInteger('course_schedule_id')->nullable();
            $table->foreign('course_schedule_id', 'course_schedule_fk_5973984')->references('id')->on('course_schedules');
        });
    }
}
