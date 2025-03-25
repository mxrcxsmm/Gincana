<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGimcanaIdToGruposTable extends Migration {
    public function up() {
        Schema::table('grupos', function (Blueprint $table) {
            $table->foreignId('gimcana_id')->nullable()->constrained('gimcanas')->onDelete('cascade');
        });
    }
    public function down() {
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropForeign(['gimcana_id']);
            $table->dropColumn('gimcana_id');
        });
    }
}
