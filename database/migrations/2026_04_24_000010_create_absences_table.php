<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

return new class extends Migration

{

    public function up(): void

    {

        Schema::create('absences', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')->constrained('students');

            $table->date('date');

            $table->enum('type', ['izin', 'sakit', 'alpha']);

            $table->text('reason');

            $table->string('parent_signature_path')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->foreignId('approved_by')->nullable()->constrained('users');

            $table->timestamps();

        });

    }

    public function down(): void

    {

        Schema::dropIfExists('absences');

    }

};