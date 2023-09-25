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
        Schema::create('account_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('checked_by_id')->nullable();
            $table->unsignedBigInteger('identification_card_type_id');
            $table->tinyInteger('verdict')->nullable();
            $table->string('denied_reason')->nullable();
            $table->string('submitted_id_image_url');
            $table->string('address');
            $table->string('contact_number');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();


            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('checked_by_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('identification_card_type_id')
                ->references('id')
                ->on('identification_card_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_verifications');
    }
};
