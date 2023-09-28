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
        Schema::create('unit_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('pop_image_id');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('email_address');
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->tinyInteger('type')->default(0)->comment('0 -> active | 1 -> expired | 2 -> terminated');
            $table->tinyInteger('request_status')->default(0)->comment('0 -> pending | 1 -> approved | 2 -> denied');
            $table->timestamps();


            $table->foreign('unit_id')
                ->references('id')
                ->on('units');
            $table->foreign('subscription_id')
                ->references('id')
                ->on('subscriptions');
            $table->foreign('pop_image_id')
                ->references('id')
                ->on('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_subscriptions');
    }
};
