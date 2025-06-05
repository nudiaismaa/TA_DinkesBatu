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
        Schema::create('standar_antropometri_laki', function (Blueprint $table) {
            $table->id();
            $table->integer('usia_bulan');
            $table->decimal('tb_sd_minus_3',5,2);
            $table->decimal('tb_sd_minus_2',5,2);
            $table->decimal('tb_sd_minus_1',5,2);
            $table->decimal('tb_sd_median',5,2);
            $table->decimal('tb_sd_plus_1',5,2);
            $table->decimal('tb_sd_plus_2',5,2);
            $table->decimal('tb_sd_plus_3',5,2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar_antropometri_laki');
    }
};
