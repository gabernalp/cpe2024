<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingTechnicalReferrerPivotTable extends Migration
{
    public function up()
    {
        Schema::create('meeting_technical_referrer', function (Blueprint $table) {
            $table->unsignedBigInteger('meeting_id');
            $table->foreign('meeting_id', 'meeting_id_fk_5974146')->references('id')->on('meetings')->onDelete('cascade');
            $table->unsignedBigInteger('technical_referrer_id');
            $table->foreign('technical_referrer_id', 'technical_referrer_id_fk_5974146')->references('id')->on('technical_referrers')->onDelete('cascade');
        });
    }
}
