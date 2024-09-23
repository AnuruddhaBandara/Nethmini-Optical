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
        Schema::table('lens_details', function (Blueprint $table) {
            $table->boolean('is_draft')->nullable()->after('id');
            $table->foreignId('branch_id')->nullable()->after('is_draft')->constrained('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lens_details', function (Blueprint $table) {
            //
        });
    }
};
