<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

return new class extends Migration

{

    public function up(): void

    {

        Schema::create('seat_layouts', function (Blueprint $table) {

            $table->id();

            $table->integer('row');

            $table->integer('col');

            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('set null');

            $table->string('label')->nullable();

            $table->timestamps();

        });

    }

    public function down(): void

    {

        Schema::dropIfExists('seat_layouts');

    }

};