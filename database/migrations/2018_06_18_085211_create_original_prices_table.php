<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOriginalPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('original_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('branch_course_id');
            $table->unsignedInteger('original_price_id')->nullable();
            $table->decimal('value', 10, 2);
            $table->text('remarks')->nullable();
            $table->unsignedInteger('added_by');
            $table->unsignedInteger('deleted_by')->nullable();
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
        Schema::dropIfExists('original_prices');
    }
}
