<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('description');
            $table->date('date');
            $table->time('time');
            $table->string('meeting_term')->nullable();
            $table->string('methodology')->nullable();
            $table->boolean('teachers_network')->default(0)->nullable();
            $table->string('otro_referente')->nullable();
            $table->string('link')->nullable();
            $table->longText('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
