<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('pid');
            $table->string('name');
            $table->string('url');
            $table->string('behavior');
            $table->smallInteger('weight');
            $table->timestamps();
        });
        
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
            
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('role_id');
            $table->string('permission_ids', 1000);
            $table->timestamps();
        });
        
        Schema::create('user_has_roles', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('role_id');
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
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('user_has_roles');
    }
}
