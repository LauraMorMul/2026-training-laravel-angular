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
        Schema::table('users', function (Blueprint $table) {
            $table->string('uuid')->unique()->after('id');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->after('uuid');
            $table->string('role')->after('restaurant_id');
            $table->string('image_src')->after('role');
            $table->string('pin')->after('password');
            $table->softDeletes('deleted_at')->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('image_src');
            $table->dropColumn('delete_at');
        });
    }
};
