<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['quantity' , 'product_id','user_id'];


    public function product(){
        return $this->belongsTo(Product::class);
    }

}
