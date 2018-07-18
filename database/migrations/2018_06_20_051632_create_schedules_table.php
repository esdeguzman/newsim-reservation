<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('schedule_id')->nullable();
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('branch_course_id');
            $table->unsignedSmallInteger('month');
            $table->unsignedSmallInteger('year');
            $table->unique(['branch_course_id', 'month']);
            $table->string('status')->default('new');
            $table->decimal('discount', 3, 2);
            $table->unsignedInteger('added_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('schedules');
    }
}
