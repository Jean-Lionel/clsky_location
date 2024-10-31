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
        Schema::disableForeignKeyConstraints();

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->date('check_in');
            $table->date('check_out');
            $table->decimal('total_price', 10, 2);
            $table->integer('guests');
            $table->enum('status', ["pending","confirmed","cancelled","completed"])->default('pending');
            $table->enum('payment_status', ["pending","paid","refunded"])->default('pending');
            $table->text('notes')->nullable();
            $table->decimal('total_paid', 10, 2)->default(0);
            $table->string('motif_annulation')->nullable();
            $table->timestamp('date_annulation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
