<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seksi_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('ketua_id')->nullable()->constrained('students')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('seksi_kegiatan_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seksi_id')->constrained('seksi_kegiatan')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seksi_kegiatan_members');
        Schema::dropIfExists('seksi_kegiatan');
    }
};
