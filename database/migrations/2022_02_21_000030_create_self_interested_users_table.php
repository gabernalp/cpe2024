<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelfInterestedUsersTable extends Migration
{
    public function up()
    {
        Schema::create('self_interested_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('email');
            $table->integer('document');
            $table->date('document_date');
            $table->string('phone')->nullable();
            $table->string('education_background');
            $table->string('modality');
            $table->string('living_zone');
            $table->boolean('contacted')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
