<?php

use App\Enums\ServiceEnum;
use App\Enums\StatusEnum;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('customer_id')->references('id')->on('customers');
            $table->date('transaction_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('description')->default(ServiceEnum::beliPulsa->value);
            $table->string('status')->default(StatusEnum::debit->value);
            $table->bigInteger('amount')->default(0);
            $table->timestamps(3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
