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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->string('street')->nullable();
            $table->string('town')->nullable();
            $table->string('state')->nullable();
            $table->string('phone')->nullable();
            $table->string('zip')->nullable();
            $table->string('email')->nullable();
            $table->string('note')->nullable();
            $table->float('total');
            $table->string('shipping_method')->nullable();
            $table->integer('status')->default(1)->nullable()->comment("0:đơn hàng mới, 1:Đã tiếp nhận, 2:Hủy, 3:thành công");
            $table->integer('Payment_method')->default(1)->comment("1:cash, 2:bnk");
            $table->string('TransactionStatus')->default(1);
            $table->string('BankCode')->nullable();
            $table->string('TransactionNo')->nullable();
            $table->string('payment_status')->nullable()->comment("0:chưa thanh toán, 1:đã thanh toán,  2:Hủy");
            $table->string('vnp_BankTranNo')->nullable();
            $table->string('vnp_ResponseCode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
