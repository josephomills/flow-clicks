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
        Schema::create('link_group_assignments', function (Blueprint $table) {
            $table->foreignId('denomination_id')->constrained()->cascadeOnDelete();
            $table->foreignId('link_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained('link_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_group_assignments');
    }
};
