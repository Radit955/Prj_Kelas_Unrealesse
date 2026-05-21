<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['active', 'suspended', 'timeout'])->default('active')->after('avatar');
            }
            if (!Schema::hasColumn('users', 'timeout_until')) {
                $table->timestamp('timeout_until')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('timeout_until');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('phone');
            }
        });

        Schema::table('announcements', function (Blueprint $table) {
            if (!Schema::hasColumn('announcements', 'display_mode')) {
                $table->enum('display_mode', ['notification', 'dashboard', 'fullscreen'])->default('dashboard')->after('pinned');
            }
            if (!Schema::hasColumn('announcements', 'closeable')) {
                $table->boolean('closeable')->default(true)->after('display_mode');
            }
            if (!Schema::hasColumn('announcements', 'expires_at')) {
                $table->timestamp('expires_at')->nullable()->after('closeable');
            }
        });

        Schema::table('absences', function (Blueprint $table) {
            if (!Schema::hasColumn('absences', 'duration_days')) {
                $table->integer('duration_days')->default(0)->after('reason');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn(['status', 'timeout_until', 'bio', 'phone', 'address']);
            }
        });

        Schema::table('announcements', function (Blueprint $table) {
            if (Schema::hasColumn('announcements', 'display_mode')) {
                $table->dropColumn(['display_mode', 'closeable', 'expires_at']);
            }
        });

        Schema::table('absences', function (Blueprint $table) {
            if (Schema::hasColumn('absences', 'duration_days')) {
                $table->dropColumn('duration_days');
            }
        });
    }
};
