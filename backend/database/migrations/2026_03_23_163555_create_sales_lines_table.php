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
        Schema::create('sales_lines', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->integer('quantity');
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->foreign('product_id')->references('id')->on('product');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('price');
            $table->integer('tax_percentage');
            $table->timestamps();
            $table->softDeletes('deleted_at')
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_lines');
    }
};
