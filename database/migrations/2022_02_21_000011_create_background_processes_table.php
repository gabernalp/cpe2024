<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackgroundProcessesTable extends Migration
{
    public function up()
    {
        Schema::create('background_processes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('description');
            $table->string('link')->nullable();
            $table->boolean('especial')->default(0)->nullable();
            $table->longText('descripcion_especial')->nullable();
            $table->longText('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
