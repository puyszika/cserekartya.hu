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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('price' , 10, 2)->change();
            $table->unsignedBigInteger('category_id');
            $table->string('city');
            $table->string('delivery_method');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Külső kulcsok hozzáadása
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->string('price')->change();
        });
    }
};
