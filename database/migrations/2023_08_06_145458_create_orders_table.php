<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->decimal('order_price', 5)->default(0);
                $table->string('delivery', 128)->nullable();
                $table->string('payment_method', 128)->nullable();
                $table->string('status', 128)->nullable();
                $table->string('destination', 256)->nullable();
                $table->string('comment', 256)->nullable();
                $table->foreign('user_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();

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
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['user_id']);

            });
        }

        Schema::dropIfExists('orders');
    }
};
