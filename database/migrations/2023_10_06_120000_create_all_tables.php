<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('ships', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->json('spec');
            $table->text('description');
            $table->integer('ordering')->default(9999);
            $table->tinyInteger('state')->default(0);
            //$table->timestamps();
        });

        Schema::create('cabin_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ship_id')->unsigned();
            $table->string('vendor_code', 10);
            $table->string('title', 255);
            $table->enum('type', ['Inside', 'Ocean view', 'Balcony', 'Suite'])->nullable()->default('Inside');
            $table->text('description');
            $table->json('photos')->nullable();
            $table->integer('ordering')->default(9999);
            $table->tinyInteger('state')->default(0);
            //$table->timestamps();

            $table->foreign('ship_id')
                ->references('id')
                ->on('ships')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unique(['ship_id', 'vendor_code']);
        });

        Schema::create('ships_gallery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ship_id')->unsigned();
            $table->string('title', 255);
            $table->string('url', 1000);
            $table->smallInteger('ordering')->default(999);
            //$table->timestamps();

            $table->foreign('ship_id')
                ->references('id')
                ->on('ships')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('cabin_categories', function (Blueprint $table) {
            $table->index('ship_id', 'ship_id_2');
        });

        Schema::table('ships_gallery', function (Blueprint $table) {
            $table->index('ship_id', 'ship_id');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('cabin_categories', function (Blueprint $table) {
            $table->dropForeign('cabin_categories_ship_id_foreign');
            $table->dropUnique('cabin_categories_ship_id_vendor_code_unique');
            $table->dropIndex('cabin_categories_ship_id_2_index');
        });

        Schema::table('ships_gallery', function (Blueprint $table) {
            $table->dropForeign('ships_gallery_ship_id_foreign');
            $table->dropIndex('ships_gallery_ship_id_index');
        });

        Schema::dropIfExists('ships');
        Schema::dropIfExists('cabin_categories');
        Schema::dropIfExists('ships_gallery');

    }
};
