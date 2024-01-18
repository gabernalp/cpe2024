<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesHookProfilePivotTable extends Migration
{
    public function up()
    {
        Schema::create('courses_hook_profile', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id', 'profile_id_fk_5995788')->references('id')->on('profiles')->onDelete('cascade');
            $table->unsignedBigInteger('courses_hook_id');
            $table->foreign('courses_hook_id', 'courses_hook_id_fk_5995788')->references('id')->on('courses_hooks')->onDelete('cascade');
        });
    }
}
