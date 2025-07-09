<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zones_delimitees', function (Blueprint $table) {
            $table->id();
            $table->double('latitude', 10, 7);
            $table->double('longitude', 10, 7);
            $table->integer('rayon')->default(500);
            $table->foreignId('daara_id')->constrained('daaras')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zones_delimitees');
    }
};
