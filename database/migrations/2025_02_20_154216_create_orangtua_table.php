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
        Schema::create('orangtua', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kelurahan_id')->constrained('kelurahans')->cascadeOnDelete();
            $table->string('nik', 16)->unique();
            $table->string('nomor_hp', 15)->unique();
            $table->text('alamat_ktp');
            $table->text('alamat_domisili');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orangtua');
    }
};
