<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('alertes', function (Blueprint $table) {
            $table->foreignId('utilisateur_id')->nullable()->constrained('utilisateurs')->onDelete('set null')->after('zone_id');
            $table->decimal('latitude', 10, 7)->nullable()->after('utilisateur_id');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->decimal('distance', 10, 2)->nullable()->after('longitude');
            $table->timestamp('date')->nullable()->after('distance');
        });
    }

    public function down(): void
    {
        Schema::table('alertes', function (Blueprint $table) {
            $table->dropForeign(['utilisateur_id']);
            $table->dropColumn(['utilisateur_id', 'latitude', 'longitude', 'distance', 'date']);
        });
    }
};
