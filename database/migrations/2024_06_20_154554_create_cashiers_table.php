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
        Schema::create('cashiers', function (Blueprint $table) {
            $table->id();
            $table->integer("bills_1")->default(0)->nullable();
            $table->integer("bills_5")->default(0)->nullable();
            $table->integer("bills_10")->default(0)->nullable();
            $table->integer("bills_20")->default(0)->nullable();
            $table->integer("bills_50")->default(0)->nullable();
            $table->integer("bills_100")->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashiers');
    }
};
