<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('booking_id')
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->date('loan_date');
            $table->date('return_date')->nullable();
            $table->enum('status', ['Pendiente', 'Devuelto', 'Atrasado'])->default('Pendiente');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
