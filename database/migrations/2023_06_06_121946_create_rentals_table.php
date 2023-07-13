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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('unit_id');
            $table->float('monthly_amount');
            $table->integer('due_date');
            $table->date('date_start');
            $table->date('date_end')->nullable();
            $table->tinyInteger('rental_status')->default(0)->comment('0 -> pending | 1 -> approved | 2 -> denied | 3 -> cancelled | 4 -> terminated');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();


            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('unit_id')
                ->references('id')
                ->on('units');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
