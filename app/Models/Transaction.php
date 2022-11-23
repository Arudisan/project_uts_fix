<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'customer', 'quantity', 'total_amount'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    public $incrementing = false;
}
