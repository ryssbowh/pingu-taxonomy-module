<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class M2019_08_12_142050080221_AddTaxonomyContentField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_taxonomies', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('required');
            $table->boolean('multiple');
            $table->integer('taxonomy_id')->unsigned()->nullable();
            $table->foreign('taxonomy_id')->references('id')->on('taxonomies')->onDelete('set null');
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
        Schema::dropIfExists('field_taxonomies');
    }
}
