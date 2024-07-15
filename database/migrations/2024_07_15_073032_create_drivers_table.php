<?php

use App\Models\Company;
use App\Models\Vehicle;
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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Company::class);
            $table->foreignIdFor(Vehicle::class);
            $table->string('status')->nullable()->default('available');
            $table->text('image')->nullable();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('phone_number')->nullable();
            $table->text('phone_number_2')->nullable();
            $table->text('address')->nullable();
            $table->text('sex')->nullable();
            $table->date('dob')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
