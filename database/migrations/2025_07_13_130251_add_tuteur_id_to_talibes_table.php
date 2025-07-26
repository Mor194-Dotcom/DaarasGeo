<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTuteurIdToTalibesTable extends Migration
{
    public function up()
    {
        Schema::table('talibes', function (Blueprint $table) {
            $table->foreignId('tuteur_id')->nullable()->constrained()->after('zone_id');
        });
    }

    public function down()
    {
        Schema::table('talibes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tuteur_id');
        });
    }
}
