<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_posyandu_anak', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('anak_id')->constrained('anak')->onDelete('cascade');
            $table->foreignUuid('posyandu_id')->constrained('posyandus')->onDelete('cascade');
            $table->timestamp('tanggal_pindah')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_posyandu_anak');
    }
};
