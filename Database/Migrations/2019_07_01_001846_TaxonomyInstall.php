<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaxonomyInstall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('machineName')->unique();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('taxonomy_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('machineName')->unique();
            $table->text('description');
            $table->integer('taxonomy_id')->unsigned();
            $table->foreign('taxonomy_id')->references('id')->on('taxonomies');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('taxonomy_items');
            $table->integer('weight')->unsigned();
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
        Schema::dropIfExists('taxonomy_items');
        Schema::dropIfExists('taxonomies');
    }
}
