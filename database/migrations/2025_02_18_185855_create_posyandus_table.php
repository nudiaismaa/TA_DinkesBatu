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
        Schema::create('posyandus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_posyandu');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->foreignId('kelurahan_id')->constrained('kelurahans')->nullable();

            $table->foreignUuid('puskesmas_id')->constrained('puskesmas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandus');
    }
};
