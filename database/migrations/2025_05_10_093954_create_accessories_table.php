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
         Schema::create('accessories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('productId')->constrained('gym_products')->onDelete('cascade');
            $table->string('material');
            $table->string('brand');
            $table->string('size');
            $table->double('weight');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessories');
    }
};
