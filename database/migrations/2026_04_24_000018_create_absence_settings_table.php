<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absence_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('max_izin_days')->default(3);
            $table->boolean('sakit_unlimited')->default(true);
            $table->timestamps();
        });

        DB::table('absence_settings')->insert([
            'max_izin_days'   => 3,
            'sakit_unlimited' => true,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('absence_settings');
    }
};
