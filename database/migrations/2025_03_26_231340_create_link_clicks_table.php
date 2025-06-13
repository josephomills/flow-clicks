<?php

use App\Models\Denomination;
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
        // Migration
Schema::create('link_clicks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('link_id')->constrained()->cascadeOnDelete();
    $table->foreignId('denomination_id')->constrained()->cascadeOnDelete(); // Fixed this line
    $table->foreignId('link_type_id')->constrained('link_types')->cascadeOnDelete();
    // location and device data
    $table->string('ip_address', 45)->nullable(); // Supports IPv6
    $table->char('country_code', 2)->nullable(); // ISO 3166-1 alpha-2
    $table->string('device_type', 20)->nullable(); // mobile/desktop/tablet
    $table->string('browser', 50)->nullable();
    $table->string('platform', 50)->nullable();

    $table->timestamps();
    
    // indices for quick transactions
    $table->index(['link_id', 'created_at']); // For time-based queries
    $table->index('country_code');
    $table->index('device_type');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_clicks');
    }
};
