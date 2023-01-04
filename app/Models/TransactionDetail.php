<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'transaction_id', 'product_id', 'quantity', 'total_amount','created_at'];

    public function Transaction()
    {
        return $this->belongsto(Transaction::class);
    }
    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public $incrementing = false;
}
