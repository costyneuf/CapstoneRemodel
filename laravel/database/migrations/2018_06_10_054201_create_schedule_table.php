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
            $table->text('location')->nullable();
            $table->text('room')->nullable();
            $table->longText('case_procedure')->nullable();
            $table->text('lead_surgeon')->nullable();
            $table->longText('patient_class')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

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
