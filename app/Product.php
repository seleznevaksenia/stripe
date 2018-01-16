<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected static function invertPrice($price){
        return round($price*100,2);
    }

    public static function invertPriceReverse($price){
        return round($price/100,2);
    }

}
