<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengesUsersTable extends Migration
{
    public function up()
    {
        Schema::create('challenges_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('reference_text')->nullable();
            $table->string('reference_media')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
