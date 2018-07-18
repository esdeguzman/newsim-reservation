<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id')->nullable();
            $table->unsignedInteger('original_price_id')->nullable();
            $table->unsignedInteger('schedule_id')->nullable();
            $table->unsignedInteger('reservation_id')->nullable();
            $table->unsignedInteger('updated_by');
            $table->text('log');
            $table->text('remarks');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_details');
    }
}
