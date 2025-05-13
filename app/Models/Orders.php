<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $guarded = [];
    protected $table ='orders';

    public function user() {
    return $this->belongsTo(User::class, 'user_id');
        }

    public function orderItems() {
        return $this->hasMany(Orders_Items::class, 'order_id');
    }


}
