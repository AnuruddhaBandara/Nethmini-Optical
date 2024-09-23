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
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->decimal('sub_total', 9, 2)->default(0.00);
            $table->decimal('discount', 9, 2)->default(0.00);
            $table->decimal('final_total', 9, 2);
            $table->decimal('payment_received', 9, 2)->default(0.00);
            $table->decimal('remaining_payment', 9, 2)->default(0.00);
            $table->string('payment_method');
            $table->string('remark')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
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
