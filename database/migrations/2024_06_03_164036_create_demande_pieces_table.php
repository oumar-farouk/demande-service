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
        Schema::create('demande_pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piece_id')->constrained('pieces')->onDelete('cascade');
            $table->foreignId('demande_id')->constrained('demandes')->onDelete('cascade');
            $table->string('chemin_fichier');
            $table->string('nom_fichier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_pieces');
    }
};
