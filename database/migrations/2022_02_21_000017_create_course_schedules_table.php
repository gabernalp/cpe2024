<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('course_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('start_date');
            $table->boolean('revisa_tutor')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
