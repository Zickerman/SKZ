<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('category_id')->nullable();
                $table->unsignedBigInteger('vendor_id')->nullable();
                $table->unsignedBigInteger('image_id')->nullable();
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->decimal('price', 5)->default(0);
                $table->boolean('available')->default(0);
                $table->unsignedSmallInteger('amount')->default(0);
                $table->foreign('category_id')->references('id')->on('categories')->restrictOnDelete()->onUpdate('cascade');
                $table->foreign('vendor_id')->references('id')->on('vendors')->restrictOnDelete()->onUpdate('cascade');
                $table->foreign('image_id')->references('id')->on('images')->cascadeOnDelete()->onUpdate('cascade');

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
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropForeign(['vendor_id']);
                $table->dropForeign(['image_id']);
            });
        }

        Schema::dropIfExists('products');

    }
};
