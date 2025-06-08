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
        Schema::create('imunisasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pemeriksaan_id')->constrained('pemeriksaan')->onDelete('cascade');
            $table->enum('status_imunisasi', ['Diberikan', 'Belum Diberikan']);
            $table->dateTime('tanggal_pemberian');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imunisasis');
    }
};
