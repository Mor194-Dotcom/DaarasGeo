<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('talibes', function (Blueprint $table) {
            $table->dropColumn('simulation_active');
        });
    }

    public function down(): void
    {
        Schema::table('talibes', function (Blueprint $table) {
            $table->boolean('simulation_active')->default(false);
        });
    }
};
