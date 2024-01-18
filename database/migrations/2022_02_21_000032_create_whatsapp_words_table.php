<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappWordsTable extends Migration
{
    public function up()
    {
        Schema::create('whatsapp_words', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('word')->nullable();
            $table->string('object')->nullable();
            $table->string('action')->nullable();
            $table->string('link')->nullable();
            $table->longText('message')->nullable();
            $table->string('status')->nullable();
            $table->string('extra')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
