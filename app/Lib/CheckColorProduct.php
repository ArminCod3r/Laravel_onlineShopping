<?php

namespace App\Lib;

use App\Product;
use App\Color;


class CheckColorProduct
{
    public static function verify($color, $product_id)
    {
        $color_id   = explode('_', $color)[1];

        // Verifications
        Product::findOrFail($product_id);        
        Color::findOrFail($color_id);

        Color::where([
                      'id'          => $color_id,
                       'product_id' => $product_id
                    ])->get();

        return [$color_id, $product_id];
    }
}



?>