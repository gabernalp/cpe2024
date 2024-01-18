<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesAuditsTable extends Migration
{
    public function up()
    {
        Schema::create('resources_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
