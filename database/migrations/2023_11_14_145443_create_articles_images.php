<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class createArticlesImages extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('articles_images')) {
            Schema::create('articles_images', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('article_id')->nullable();
                $table->string('image_name', 64)->nullable();
                $table->string('image_path', 255)->nullable();
                $table->string('extension', 10)->nullable();
                $table->smallInteger('priority')->unsigned()->default(0);

                $table->timestamps();

                $table->foreign('article_id')->references('id')->on('articles')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles_images', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
        });

        Schema::dropIfExists('articles_images');
    }
};
