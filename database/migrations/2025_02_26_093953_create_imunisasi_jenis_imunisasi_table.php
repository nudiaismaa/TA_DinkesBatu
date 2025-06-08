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
        Schema::create('imunisasi_jenis_imunisasi', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('imunisasi_id')->constrained('imunisasis')->onDelete('cascade');
            $table->foreignUuid('jenis_imunisasi_id')->constrained('jenis_imunisasis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imunisasi_jenis_imunisasi');
    }
};
