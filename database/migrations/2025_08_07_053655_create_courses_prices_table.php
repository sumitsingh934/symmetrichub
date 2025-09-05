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
        Schema::create('courses_prices', function (Blueprint $table) {
            $table->id();      
            $table->unsignedBigInteger('course_id');            
            $table->decimal('price', 10, 2)->default(0.00);  
            $table->string('currency', 3)->default('INR');   
            $table->decimal('discount', 5, 2)->nullable();   
            $table->timestamps();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses_prices');
    }
};
