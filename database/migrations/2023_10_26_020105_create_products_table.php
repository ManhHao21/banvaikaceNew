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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('sku')->nullable();
            $table->string('price')->nullable();
            $table->unsignedBigInteger('categories_id')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->text('material_id')->nullable();
            $table->unsignedBigInteger('user_id')->default(0)->nullable();
            $table->string('gms')->nullable();
            $table->integer('publish')->default(0);
            $table->string('seller')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
