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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
	    $table->timestamps();
	    $table->string('name');
	    $table->string('image');
	    $table->string('timeToPrepare');
	    $table->integer('portions');
	    $table->integer('difficulty');
	    $table->string('ingredients');
	    $table->string('stepsToPrepare');
	    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
