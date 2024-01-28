<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('total', 50);
            $table->string('vat', 50);
            $table->string('payable', 50);
            $table->string('cus_details', 500);
            $table->string('ship_details', 500);
            $table->string('tran_id', 100);
            $table->string('val_id', 100)->default(0);
            $table->enum('delivery_status', ['Pending', 'Processing', 'Complete']);
            $table->string('payment_status');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
