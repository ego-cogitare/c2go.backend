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
            $table->char('first_name', 255);
            $table->char('last_name', 255);
            $table->string('email')->unique();
            $table->boolean('verified')->default(false);
            $table->string('password');
            $table->boolean('is_blocked')->default(false);
            $table->string('home_address')->nullable();
            $table->date('birth_date')->nullable();
            $table->boolean('is_subscribed')->default(0);
            $table->unsignedTinyInteger('progress')->nullable();
            $table->softDeletes();
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
