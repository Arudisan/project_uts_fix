<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable=['category_id','title','status','description','image','weight','price'];

    public function category(){
        return $this->belongsTo(CategoryProduct::class, 'category_id', 'id');
    }
}
