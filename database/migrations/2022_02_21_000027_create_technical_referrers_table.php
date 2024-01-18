<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalReferrersTable extends Migration
{
    public function up()
    {
        Schema::create('technical_referrers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
