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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('cover');
            $table->string('title');
            $table->string('author');
            $table->enum('format', ['soft cover', 'hard cover']);
            $table->text('description');
            $table->string('publisher');
            $table->string('isbn')->unique();
            $table->string('language');
            $table->float('length');
            $table->float('width');
            $table->integer('weight');
            $table->integer('page');
            $table->date('release_date');
            $table->unsignedInteger('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
