<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('topic');
            $table->string('device');
            $table->Integer('size');
            $table->Integer('min')->nullable();
            $table->Integer('max')->nullable();
            $table->string('unit')->nullable();

            $table->Integer('parent_id')->nullable()->default(0);
            $table->Integer('lft')->default(0);
            $table->Integer('rgt')->default(0);
            $table->Integer('depth')->default(0);


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
        Schema::dropIfExists('widgets');
    }
}
