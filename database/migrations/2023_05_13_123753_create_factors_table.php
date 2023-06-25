<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('factors', function (Blueprint $table) {
            $table->id();
            $table->integer("buyer_id");
            $table->integer("driver_id");
            $table->integer("s1count")->default(0);
            $table->integer("s2count")->nullable();
            $table->integer("s3count")->nullable();
            $table->integer("s4count")->nullable();
            $table->integer("s1price")->default(0);
            $table->integer("s2price")->nullable();
            $table->integer("s3price")->nullable();
            $table->integer("s4price")->nullable();
            $table->integer("totalPrice");
            $table->integer("prePay");
            $table->integer("afterPay")->default(0);
            $table->integer("transport");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factors');
    }
};
