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
        Schema::table('guestbooks', function (Blueprint $table) {
            if (!Schema::hasColumn('guestbooks', 'photo')) {
                $table->string('photo')->nullable()->after('message');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guestbooks', function (Blueprint $table) {
            if (Schema::hasColumn('guestbooks', 'photo')) {
                $table->dropColumn('photo');
            }
        });
    }
};
