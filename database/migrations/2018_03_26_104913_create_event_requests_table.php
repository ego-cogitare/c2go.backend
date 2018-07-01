<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('event_proposals_id');
            $table->unsignedInteger('user_id');
            $table->string('message', 255);
            $table->unsignedTinyInteger('state')->default(1);
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->foreign('event_proposals_id')->references('id')->on('event_proposals')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['event_proposals_id', 'user_id'], 'unique_event_proposals_id_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_requests');
    }
}
