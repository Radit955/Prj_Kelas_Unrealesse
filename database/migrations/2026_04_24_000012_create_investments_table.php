<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

return new class extends Migration

{

    public function up(): void

    {

        Schema::create('investments', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('type')->default('obligasi');

            $table->decimal('principal', 15, 2);

            $table->decimal('rate_percent', 5, 2);

            $table->date('start_date');

            $table->date('maturity_date');

            $table->decimal('current_value', 15, 2);

            $table->timestamps();

        });

    }

    public function down(): void

    {

        Schema::dropIfExists('investments');

    }

};