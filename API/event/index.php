<?php

use yii\web\Response;
use yii\helpers\BaseJson;

$cart = array(
    "orderID" => 12345,
    "shopperName" => "John Smith",
    "shopperEmail" => "johnsmith@example.com",
    "contents" => array(
        array(
            "productID" => 34,
            "productName" => "SuperWidget",
            "quantity" => 1
        ),
        array(
            "productID" => 56,
            "productName" => "WonderWidget",
            "quantity" => 3
        )
    ),
    "orderCompleted" => true
);
var_dump(json_encode( $cart ));

//$items = ['galaxy 7', 'iphone 8'];
//echo var_dump(json_encode($items));
return json_encode($cart);
