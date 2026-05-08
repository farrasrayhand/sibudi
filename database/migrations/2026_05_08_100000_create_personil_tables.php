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
        Schema::create('employment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('bidangs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('personils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidang_id')->constrained('bidangs')->cascadeOnDelete();
            $table->foreignId('employment_status_id')->constrained('employment_statuses')->restrictOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['bidang_id', 'name']);
            $table->index('employment_status_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personils');
        Schema::dropIfExists('bidangs');
        Schema::dropIfExists('employment_statuses');
    }
};
