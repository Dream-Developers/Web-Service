<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('recidencia',250);
            $table->string('telefono');
            $table->string('email')->unique();
            $table->unsignedInteger("rol_id");
            $table->string('password');
            $table->foreign("rol_id")->references("id")->on("roles");
            $table->string('foto')->nullable();
            $table->string("firebase_token")->nullable();
            $table->string('sexo');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
