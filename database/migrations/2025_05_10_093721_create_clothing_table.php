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
       Schema::create('clothing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('productId')->constrained('gym_products')->onDelete('cascade');
        
            // Attributes from UML
            $table->enum('size', ['S', 'M', 'L', 'XL']);  // Exact enum values
            $table->string('color');
            $table->enum('gender', ['Men', 'Women', 'Unisex']);  // Fixed "Unless" to "Unisex"
            $table->string('material');  // Note: Fixed UML typo "Capaule"
            $table->timestamps(); // Add if missing

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clothing');
    }
};
