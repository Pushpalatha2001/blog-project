<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders_Items extends Model
{
    protected $guarded = [];
    protected $table ='orders__items';

    public function order() {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
