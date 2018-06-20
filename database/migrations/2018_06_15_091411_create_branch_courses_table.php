<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('course_id');
            $table->unique(['branch_id', 'course_id']);
            $table->unsignedInteger('added_by');
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
        Schema::dropIfExists('branch_courses');
    }
}
