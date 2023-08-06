<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vendors')) {
            Schema::create('vendors', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('image_id')->nullable();
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->boolean('available')->default(0);
                $table->unsignedSmallInteger('products_amount')->default(0);
                $table->foreign('image_id')->references('id')->on('images')->cascadeOnDelete()->cascadeOnUpdate();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('vendors')) {
            Schema::table('vendors', function (Blueprint $table) {
                $table->dropForeign(['image_id']);
            });
        }

        Schema::dropIfExists('vendors');
    }
};
