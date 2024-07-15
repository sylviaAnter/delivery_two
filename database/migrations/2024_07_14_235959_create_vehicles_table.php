<?php

use App\Models\Company;
use App\Models\Invoice;
use App\Models\Region;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Company::class);
            $table->foreignIdFor(Invoice::class);
            $table->foreignIdFor(Region::class);
            $table->string('vehicle_type');
            $table->string('plate_number');
            $table->string('brand');
            $table->string('model');
            $table->string('color');
            $table->integer('capacity');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
