<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('description', 255);
            $table->string('event_location_human');
            $table->json('event_location_latlng');
            $table->string('event_destination_human')->nullable();
            $table->json('event_destination_latlng')->nullable();
            $table->dateTime('date');
            $table->unsignedTinyInteger('is_top')->default(0);
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
