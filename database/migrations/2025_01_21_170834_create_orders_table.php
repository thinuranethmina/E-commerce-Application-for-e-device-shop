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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('ref');
            $table->text('session_id');
            $table->string('customer_first_name');
            $table->string('customer_last_name');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->text('note')->nullable();
            $table->double('sub_total');
            $table->double('delivery_fee');
            $table->double('total');
            $table->enum('deliver_status', ['Pending', 'Confirmed', 'Delivered', 'Cancelled', 'Returned'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
