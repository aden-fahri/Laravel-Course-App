<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->text('assignment_instruction')->nullable()->after('content');
            $table->enum('assignment_type', ['none', 'file', 'text', 'link', 'mixed'])
                ->default('none')
                ->after('assignment_instruction');
            $table->boolean('assignment_required')->default(false)
                ->after('assignment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['assignment_instruction', 'assignment_type', 'assignment_required']);
        });
    }
};
