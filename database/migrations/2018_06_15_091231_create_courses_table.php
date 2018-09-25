<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id')->nullable();
            $table->string('code')->unique();
            $table->string('description')->unique();
            $table->string('category');
            $table->string('accreditation_body');
            $table->text('aims')->nullable();
            $table->text('objectives_header')->nullable();
            $table->text('objectives')->nullable();
            $table->text('target_audience')->nullable();
            $table->text('prerequisites')->nullable();
            $table->string('status')->default('active');
            $table->unsignedInteger('duration');
            $table->unsignedInteger('validity')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
