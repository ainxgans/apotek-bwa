<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('total_amount');
            $table->boolean('is_paid');
            $table->string('address');
            $table->string('city');
            $table->string('post_code');
            $table->string('phone_number');
            $table->text('notes');
            $table->string('proof');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_transations');
    }
};
