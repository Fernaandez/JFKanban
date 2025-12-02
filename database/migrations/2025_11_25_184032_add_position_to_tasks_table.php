<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Afegir un camp per a la posició, que comença per 0
            $table->unsignedInteger('position')->default(0)->after('status');
            // Nota: Afegim un index compost per optimitzar les consultes per columna
            $table->index(['status', 'position']);
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['status', 'position']);
            $table->dropColumn('position');
        });
    }
};


