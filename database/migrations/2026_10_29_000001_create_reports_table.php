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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Person 1 details
            $table->string('p1_first_name');
            $table->string('p1_last_name')->nullable();
            $table->date('p1_dob');
            $table->integer('p1_life_path');
            $table->integer('p1_destiny');
            $table->integer('p1_soul');
            $table->integer('p1_personality');

            // Person 2 details
            $table->string('p2_first_name');
            $table->string('p2_last_name')->nullable();
            $table->date('p2_dob');
            $table->integer('p2_life_path');
            $table->integer('p2_destiny');
            $table->integer('p2_soul');
            $table->integer('p2_personality');

            // Compatibility calculation results
            $table->integer('compatibility_score');
            $table->text('summary_en');
            $table->text('summary_ta');

            // Workflow status: pending, approved, rejected, emailed
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('emailed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
