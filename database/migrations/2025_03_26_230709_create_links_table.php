<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('link_type_id');
            $table->foreignId('link_group_id');
            $table->foreignId('denomination_id');
            $table->string('original_url');
            $table->string('short_url')->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->unsignedInteger('clicks')->default(0);
            $table->timestamps();

            // Unique contraunts

            $table->unique(['user_id', 'short_url']);   // Shortcodes unique per user

            // Indexes
            $table->index('original_url');
            $table->index('short_url');
            $table->index('user_id');
            $table->index('expires_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
