<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vaccination_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->unique()->constrained()->cascadeOnDelete(); // Each user has one schedule
            $table->date('vaccination_date')->nullable()->index();
            $table->enum('status', ['Not registered', 'Not scheduled', 'Scheduled', 'Vaccinated'])->default('Not scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccination_schedules');
    }
};
