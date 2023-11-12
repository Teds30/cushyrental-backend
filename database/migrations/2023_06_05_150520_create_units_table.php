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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('landlord_id');
            $table->string('name');
            $table->text('details');
            $table->float('price');
            $table->integer('month_advance');
            $table->integer('month_deposit');
            $table->text('location');
            $table->text('address');
            $table->tinyInteger('target_gender');
            $table->integer('slots');
            $table->tinyInteger('is_listed')->default(0);
            $table->tinyInteger('request_status')->default(0);
            $table->text('verdict')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('landlord_id')
                ->references('id')
                ->on('users');
            // $table->foreign('subscription_id')
            //     ->references('id')
            //     ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
