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
   Schema::create('annonces', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // l’auteur de l’annonce
    $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');

    $table->string('titre');
    $table->text('description')->nullable();
    $table->decimal('prix', 10, 2)->nullable(); // certaines annonces n’ont pas de prix (ex: gratuit, à donner)
    $table->string('ville')->nullable(); // localisation (ville)
    $table->string('region')->nullable(); // région/pays
    $table->enum('etat', ['neuf', 'occasion']);
    $table->enum('status', ['disponible', 'vendu'])->default('disponible');
    $table->string('image')->nullable(); // image principale
    $table->json('galerie')->nullable(); // plusieurs images (sauvegardées en JSON)
    $table->softDeletes();
    $table->timestamps();
});

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
