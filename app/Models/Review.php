<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable =['product_id' , 'rating' , 'comment' , 'user_id'];



}
