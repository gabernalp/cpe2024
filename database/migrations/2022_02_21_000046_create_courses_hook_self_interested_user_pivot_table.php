<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesHookSelfInterestedUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('courses_hook_self_interested_user', function (Blueprint $table) {
            $table->unsignedBigInteger('self_interested_user_id');
            $table->foreign('self_interested_user_id', 'self_interested_user_id_fk_5974172')->references('id')->on('self_interested_users')->onDelete('cascade');
            $table->unsignedBigInteger('courses_hook_id');
            $table->foreign('courses_hook_id', 'courses_hook_id_fk_5974172')->references('id')->on('courses_hooks')->onDelete('cascade');
        });
    }
}
