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
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('anak_id')->constrained('anak')->onDelete('cascade');
            $table->timestamp('tanggal_pemeriksaan')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->float('berat_badan')->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('lingkar_kepala', 5, 2)->nullable();
            $table->text('catatan_pemeriksaan')->nullable();
            $table->foreignUuid('posyandu_id')->constrained('posyandus')->onDelete('cascade');
            $table->integer('hasil_standar')->nullable();
            $table->decimal('zscore', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan');
    }
};
