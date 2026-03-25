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
            $table->string('uuid')->unique();
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
            $table->string('status');
            $table->foreign('table_id')->references('id')->on('tables');
            $table->foreign('opened_by_user')->references('id')->on('user');
            $table->foreign('closed_by_user')->references('id')->on('user');
            $table->integer('diners');
            $table->timestamp('opened_at');
            $table->timestamp('closed_at');
            $table->timestamps();
            $table->softDeletes('deleted_at');
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
