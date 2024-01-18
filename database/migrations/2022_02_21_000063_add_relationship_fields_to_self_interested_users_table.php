<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSelfInterestedUsersTable extends Migration
{
    public function up()
    {
        Schema::table('self_interested_users', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->foreign('profile_id', 'profile_fk_6005947')->references('id')->on('profiles');
            $table->unsignedBigInteger('documenttype_id')->nullable();
            $table->foreign('documenttype_id', 'documenttype_fk_5974162')->references('id')->on('document_types');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id', 'department_fk_5974168')->references('id')->on('departments');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id', 'city_fk_5974169')->references('id')->on('cities');
        });
    }
}
