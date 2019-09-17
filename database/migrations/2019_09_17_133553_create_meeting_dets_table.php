<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingDetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_dets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('meeting_id');
            $table->unsignedInteger('representation_id');
            $table->dateTime('date_added');
            $table->unsignedInteger('user_id');
            $table->string('caption');
            $table->text('note');
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
        Schema::dropIfExists('meeting_dets');
    }
}
