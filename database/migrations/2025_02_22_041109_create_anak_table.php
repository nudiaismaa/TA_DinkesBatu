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
        Schema::create('anak', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('orangtua_id')->constrained('orangtua')->onDelete('cascade');
            $table->foreignId('kelurahan_id')->constrained('kelurahans');
            $table->foreignUuid('posyandu_id')->constrained('posyandus')->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->decimal('berat_badan_saat_lahir', places: 3);
            $table->integer('anak_ke');
            $table->text('alamat');
            $table->foreignId('user_status_id')->on('user_statuses')->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak');
    }
};
