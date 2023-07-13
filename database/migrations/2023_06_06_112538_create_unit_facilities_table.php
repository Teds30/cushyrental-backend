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
        Schema::create('unit_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('facility_id');
            $table->tinyInteger('is_shared')->default(0);
            $table->timestamps();


            $table->foreign('unit_id')
                ->references('id')
                ->on('units');

            $table->foreign('facility_id')
                ->references('id')
                ->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_facilities');
    }
};
