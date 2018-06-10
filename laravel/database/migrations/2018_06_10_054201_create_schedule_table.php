<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_data', function (Blueprint $table) {
            $table->increments('id');

            $table->date('date');
            $table->text('location');
            $table->text('room');
            $table->longText('case_procedure');
            $table->text('lead_surgeon');
            $table->longText('patient_class');
            $table->time('start_time');
            $table->time('end_time');

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
        Schema::dropIfExists('schedule_data');
    }
}
