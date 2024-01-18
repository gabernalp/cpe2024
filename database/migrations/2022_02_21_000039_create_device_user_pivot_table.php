<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('device_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_5973853')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('device_id');
            $table->foreign('device_id', 'device_id_fk_5973853')->references('id')->on('devices')->onDelete('cascade');
        });
    }
}
