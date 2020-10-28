<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','name', 'email', 'product_catagory',  'product_name', 'quantity',
'payment_status', 'payment_option','order_token' ];

protected function users() 
{
    return $this->belongsTo(User::class);
}
}


