<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('talibes', function (Blueprint $table) {
            $table->boolean('simulation_active')->default(false)->after('tuteur_id');
        });
    }

    public function down()
    {
        Schema::table('talibes', function (Blueprint $table) {
            $table->dropColumn('simulation_active');
        });
    }
};
