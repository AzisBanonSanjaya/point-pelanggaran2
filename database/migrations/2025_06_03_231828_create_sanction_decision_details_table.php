<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanction_decision_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sanction_decision_id');
            $table->unsignedBigInteger('category_id');
            $table->date('incident_date');
            $table->text('comment')->nullable();
            $table->text('file')->nullable();
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
        Schema::dropIfExists('sanction_decision_details');
    }
};
