<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('goal');
            $table->string('tipo_ciclo')->nullable();
            $table->boolean('unico')->default(0)->nullable();
            $table->longText('mensaje_cierre')->nullable();
            $table->longText('additional_comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
