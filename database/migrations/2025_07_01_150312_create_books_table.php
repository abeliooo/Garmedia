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
            $table->string('judul');
            $table->string('author');
            $table->enum('format', ['soft cover', 'hard cover']);
            $table->text('deskripsi');
            $table->string('penerbit');
            $table->string('isbn')->unique();
            $table->string('bahasa');
            $table->float('panjang');
            $table->float('lebar');
            $table->integer('berat');
            $table->integer('halaman');
            $table->date('tanggal_terbit');
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
