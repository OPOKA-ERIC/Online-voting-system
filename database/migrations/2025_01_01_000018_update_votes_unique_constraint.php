<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('votes', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'election_id']);
            $table->unique(['user_id', 'election_id', 'position_id']);
        });
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'election_id', 'position_id']);
            $table->unique(['user_id', 'election_id']);
        });
    }
};
