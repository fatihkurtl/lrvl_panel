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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->unique();
            $table->string('image')->nullable();
            $table->string('brand')->nullable();
            $table->decimal('price');
            $table->string('category');
            $table->unsignedInteger('weight')->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->string('color')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
