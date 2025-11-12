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
        Schema::create('settings', function (Blueprint $table) {
            $table->id(); // Kita akan selalu pakai baris dengan id=1

            // Info Perusahaan
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_city_state_zip')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_logo')->nullable(); // Hanya menyimpan path file

            // Info Bank / Catatan Kaki
            $table->text('default_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
