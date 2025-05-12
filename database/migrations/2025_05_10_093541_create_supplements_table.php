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
        Schema::create('supplements', function (Blueprint $table) {
            $table->id(); // Same as foreign key for single-table inheritance
            $table->foreignId('productId')->constrained('gym_products')->onDelete('cascade');
            $table->string('flavor');
            $table->double('weight');
            $table->enum('form', ['Powder', 'Capsule', 'Liquid']);
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplements');
    }
};
