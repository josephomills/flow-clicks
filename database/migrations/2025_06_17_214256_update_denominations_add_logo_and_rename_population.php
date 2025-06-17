<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('denominations', function (Blueprint $table) {
            // Rename population to avg_attendance if it exists
            if (Schema::hasColumn('denominations', 'population')) {
                $table->renameColumn('population', 'avg_attendance');
            }

            // Add logo column if it doesn't exist
            if (!Schema::hasColumn('denominations', 'logo')) {
                $table->string('logo')->nullable()->after('country');
            }
        });
    }

    public function down(): void
    {
        Schema::table('denominations', function (Blueprint $table) {
            // Rollback logo
            if (Schema::hasColumn('denominations', 'logo')) {
                $table->dropColumn('logo');
            }

            // Rename back avg_attendance to population
            if (Schema::hasColumn('denominations', 'avg_attendance')) {
                $table->renameColumn('avg_attendance', 'population');
            }
        });
    }
};
