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
	    Schema::create('category_recipe', function (Blueprint $table) {
		    $table->unsignedBigInteger('category_id');
		    $table->unsignedBigInteger('recipe_id');

		    $table->foreign('category_id')->references('id')->on('categories')->onDelete('CASCADE');
		    $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('CASCADE');

		    $table->primary(['category_id', 'recipe_id']);

	    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_recipe');
    }
};
