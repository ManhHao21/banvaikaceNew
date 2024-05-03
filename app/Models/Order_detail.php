<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order_detail extends Model
{
    use HasFactory;
    protected $table = 'order_detail';
    protected $fillable = [
        'order_code',
        'user_id',
        'name',
        'province_id',
        'district_id',
        'email',
        'zip',
        'phone',
        'ward_id',
        'note',
        'total',
        'vnp_ResponseCode',
        'vnp_BankTranNo',
        'payment_status',
        'TransactionNo',
        'BankCode',
        'TransactionStatus',
        'Payment_method',
        'status',
        'shipping_method',
    ];

}
