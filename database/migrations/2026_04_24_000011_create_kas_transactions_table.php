<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

return new class extends Migration

{

    public function up(): void

    {

        Schema::create('kas_transactions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('student_id')->constrained('students');

            $table->decimal('amount', 10, 2);

            $table->enum('method', ['qris', 'cash']);

            $table->integer('week');

            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

        });

    }

    public function down(): void

    {

        Schema::dropIfExists('kas_transactions');

    }

};