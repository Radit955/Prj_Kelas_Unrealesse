<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

return new class extends Migration

{

    public function up(): void

    {

        Schema::create('schedules', function (Blueprint $table) {

            $table->id();

            $table->string('day');

            $table->string('lesson_code');

            $table->string('lesson_name');

            $table->string('teacher_code');

            $table->time('start_time');

            $table->time('end_time');

            $table->string('class_name');

            $table->timestamps();

        });

    }

    public function down(): void

    {

        Schema::dropIfExists('schedules');

    }

};