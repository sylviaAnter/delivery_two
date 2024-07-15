<?php

use App\Models\Company;
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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Company::class);
            $table->text('Region_name');
            $table->text('city');
            $table->bigInteger('PostalCode');
            $table->bigInteger('DeliveryFee');
            $table->integer('EstimatedDeliveryTime');
            $table->text('description')->nullable();
            $table->string('status')->nullable()->default('shipped');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
