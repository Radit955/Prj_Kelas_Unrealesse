<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

return new class extends Migration

{

    public function up(): void

    {

        Schema::create('piket_assignments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')->constrained('students');

            $table->date('date');

            $table->enum('status', ['hadir', 'terlambat', 'alpha']);

            $table->timestamps();

        });

    }

    public function down(): void

    {

        Schema::dropIfExists('piket_assignments');

    }

};