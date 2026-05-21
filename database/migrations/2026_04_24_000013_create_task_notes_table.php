<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

return new class extends Migration

{

    public function up(): void

    {

        Schema::create('task_notes', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->string('subject');

            $table->text('description');

            $table->date('due_date');

            $table->foreignId('created_by')->constrained('users');

            $table->boolean('from_absent_teacher')->default(false);

            $table->timestamps();

        });

    }

    public function down(): void

    {

        Schema::dropIfExists('task_notes');

    }

};