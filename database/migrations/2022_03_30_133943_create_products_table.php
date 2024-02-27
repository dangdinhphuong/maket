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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('namePro')->unique();
            $table->string('image');
            $table->integer('quantity');
            $table->double('price');
            $table->double('cost');
            $table->string('status');
            $table->double('discounts')->default(0);
            $table->string('slug')->unique();
            $table->text('Description')->nullable();
            $table->foreignId('origin_id')->constrained('origins')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('users_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('sale_id')->constrained('sales')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
