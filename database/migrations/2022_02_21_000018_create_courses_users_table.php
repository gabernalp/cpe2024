<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesUsersTable extends Migration
{
    public function up()
    {
        Schema::create('courses_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('course_name')->nullable();
            $table->boolean('whatsapp_user')->default(0)->nullable();
            $table->integer('actual_challenge')->nullable();
            $table->string('alert_messages')->nullable();
            $table->longText('manual_feedback')->nullable();
            $table->string('additional_link')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
