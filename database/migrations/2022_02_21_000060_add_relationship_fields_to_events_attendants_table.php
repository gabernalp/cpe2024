<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEventsAttendantsTable extends Migration
{
    public function up()
    {
        Schema::table('events_attendants', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id', 'event_fk_5988938')->references('id')->on('events_schedules');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id', 'department_fk_5974074')->references('id')->on('departments');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id', 'city_fk_5974075')->references('id')->on('cities');
        });
    }
}
