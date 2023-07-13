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
        Schema::create('unit_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('image_id');
            $table->tinyInteger('is_thumbnail')->default(0);
            $table->timestamps();


            $table->foreign('unit_id')
                ->references('id')
                ->on('units');

            $table->foreign('image_id')
                ->references('id')
                ->on('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_images');
    }
};
