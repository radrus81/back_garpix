<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartitem extends Model {

    public function product() {
        return $this->belongsToMany('App\Models\Product', 'id_product', 'id');
    }

    use HasFactory;
}
