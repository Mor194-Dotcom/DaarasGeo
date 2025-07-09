<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('talibes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->date('date_naissance');
            $table->string('photo')->nullable();
            $table->double('latitude', 10, 7);
            $table->double('longitude', 10, 7);
            $table->foreignId('daara_id')->constrained('daaras')->onDelete('cascade');
            $table->foreignId('zone_id')->constrained('zones_delimitees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('talibes');
    }
};
