<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('trainee_id');
            $table->unsignedInteger('schedule_id');
            $table->string('status')->default('new');
            $table->string('code');
            $table->string('cor_number')->unique()->nullable();
            $table->unsignedInteger('registered_by')->nullable();
            $table->unsignedInteger('confirmed_by')->nullable();
            $table->decimal('original_price',8,2);
            $table->decimal('discount',8,2);
            $table->boolean('receive_payment')->default(1);
            $table->decimal('balance', 8,2);
            $table->boolean('seen')->default(0);
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
        Schema::dropIfExists('reservations');
    }
}
