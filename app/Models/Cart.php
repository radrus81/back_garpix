<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

    protected $table = 'cart';
    protected $fillable = ['id_user'];
    
    public function cartitems(){
        return $this->hasMany('App\Models\Cartitem','id_cart','id');
    }

    use HasFactory;
}
