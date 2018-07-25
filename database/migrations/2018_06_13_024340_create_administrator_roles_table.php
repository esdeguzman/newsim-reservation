<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrator_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('administrator_id');
            $table->unsignedInteger('role_id');
            $table->unique(['administrator_id', 'role_id']);
            $table->unsignedInteger('assigned_by');
            $table->unsignedInteger('revoked_by')->nullable();
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
        Schema::dropIfExists('administrator_roles');
    }
}
